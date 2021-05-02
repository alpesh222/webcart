<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Location;
use App\Product;
use App\Voucher;
use App\Http\Requests\ProductDiscountsCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageProductDiscountsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read-discount', Voucher::class)) {
            if(request()->has('status') && request()->status == 'active') {
                $discounts = Voucher::where('type', 2)->where('location_id', Auth::user()->location_id)->get()->filter(function($discount) {
                return Carbon::now()->gte(Carbon::parse($discount->starts_at)) && Carbon::now()->lte(Carbon::parse($discount->expires_at));
                });
            } else {
                $discounts = Voucher::where('type', 2)->where('location_id', Auth::user()->location_id)->get();
            }
            return view('manage.discounts.products.index', compact('discounts'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create-discount', Voucher::class)) {

            $location_id = Auth::user()->location_id;
            $products = Product::select('id', 'name')->where('location_id', $location_id)->get();

            return view('manage.discounts.products.create', compact('products'));

        } else {
            return view('errors.403');
        }
    }

    public function store(ProductDiscountsCreateRequest $request)
    {
        if(Auth::user()->can('create-discount', Voucher::class)) {
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["discount_amount"] = $userInput["discount_amount"];
            $input["starts_at"] = $userInput["starts_at"];
            $input["expires_at"] = $userInput["expires_at"];
            $input["product"] = $userInput["product"];

            $input['type'] = 2;
            $input['is_fixed'] = false;

            $locations = Location::pluck('name','id')->all();

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            $discount = Voucher::create($input);
            Product::whereIn('id', $input['product'])->update(['voucher_id' => $discount->id]);

            session()->flash('discount_created', __("New discount has been added."));
            return redirect(route('manage.product-discounts.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update-discount', Voucher::class)) {

            $discount = Voucher::where('location_id', Auth::user()->location_id)->where('id', $id)->firstOrFail();
            $products = Product::select('id', 'name', 'voucher_id')->where('location_id', $discount->location_id)->get();
            return view('manage.discounts.products.edit', compact('discount', 'products'));
        } else {
            return view('errors.403');
        }
    }

    public function update(ProductDiscountsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update-discount', Voucher::class)) {
            $discount = Voucher::findOrFail($id);
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["discount_amount"] = $userInput["discount_amount"];
            $input["starts_at"] = $userInput["starts_at"];
            $input["expires_at"] = $userInput["expires_at"];
            $input["product"] = $userInput["product"];
            $discount->update($input);
            Product::where('voucher_id', $discount->id)->update(['voucher_id' => NULL]);
            if(array_key_exists('product', $input)) {
                Product::whereIn('id', $input['product'])->update(['voucher_id' => $discount->id]);
            }
            session()->flash('discount_updated', __("The discount has been updated."));
            return redirect(route('manage.product-discounts.edit', $discount->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete-discount', Voucher::class)) {
            $discount = Voucher::findOrFail($id);
            if(count($discount->products)) {
                foreach($discount->products as $product) {
                    $product->voucher_id = NULL;
                    $product->save();
                }
            }
            $discount->delete();
            session()->flash('discount_deleted', __("The discount has been deleted."));
            return redirect(route('manage.product-discounts.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteProductDiscounts(Request $request)
    {
        if(Auth::user()->can('delete-discount', Voucher::class)) {
            if(isset($request->delete_single)) {
                $discount = Voucher::findOrFail($request->delete_single);
                if(count($discount->products)) {
                    foreach($discount->products as $product) {
                        $product->voucher_id = NULL;
                        $product->save();
                    }
                }
                $discount->delete();
                session()->flash('discount_deleted', __("The discount has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $discounts = Voucher::findOrFail($request->checkboxArray);
                    foreach($discounts as $discount) {
                        if(count($discount->products)) {
                            foreach($discount->products as $product) {
                                $product->voucher_id = NULL;
                                $product->save();
                            }
                        }
                        $discount->delete();
                    }
                    session()->flash('discount_deleted', __("The selected discounts have been deleted."));
                } else {
                    session()->flash('discount_not_deleted', __("Please select discounts to be deleted."));
                }
            }
            return redirect(route('manage.product-discounts.index'));
        } else {
            return view('errors.403');
        }
    }
}
