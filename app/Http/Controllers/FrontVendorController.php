<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontVendorController extends Controller
{
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $vendor = $user->vendor;

        if ( ! $vendor ) {
            return view('errors.404');
        }

        return view('front.vendor.profile', compact('vendor'));
    }

    function updateProfile(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'name.required' => __('The company name is required.'),
        ];

        $this->validate($request, [
            'name' => 'required|max:191',
            'phone' => 'required|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/',
            'description' => 'required'
        ], $messages);

        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'phone' => $input['phone'],
            'description' => $input['description'],
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state']
        ];

        if($user->vendor) {
            if(!$user->vendor->profile_completed) {
                $data['profile_completed'] = 1;
                $user->location_id = 1;
                $user->save();
            }
            $user->vendor()->update($data);
        } else {
            return view('errors.404');
        }

        session()->flash('profile_updated', __("The profile has been updated."));
        return redirect(route('front.vendor.profile'));
    }

    public function show($slug) {
        $vendor = Vendor::where('slug', $slug)->where('approved', 1)->firstOrFail();
        $location_id = session('location_id');

        $pagination_count = config('settings.pagination_count') ? config('settings.pagination_count') : 9;
        $products = $vendor->products()->where('location_id', $location_id)->where('is_active', 1)->orderBy('id', 'desc');
        $product_max_price = $products->max('price');
        $products = $products->paginate($pagination_count);
          
        return view('front.vendor', compact('products', 'vendor', 'product_max_price'));
    }
}
