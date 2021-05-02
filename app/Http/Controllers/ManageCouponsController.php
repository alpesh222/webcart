<?php

namespace App\Http\Controllers;

use App\Location;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CouponsCreateRequest;
use App\Http\Requests\CouponsUpdateRequest;
use Illuminate\Http\Request;

class ManageCouponsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read-coupon', Voucher::class)) {
            if(request()->has('status') && request()->status == 'active') {
                $coupons = Voucher::where('type', 1)->where('location_id', Auth::user()->location_id)->get()->filter(function($coupon) {
                return Carbon::now()->gte(Carbon::parse($coupon->starts_at)) && Carbon::now()->lte(Carbon::parse($coupon->expires_at));
                });
            } else {
                $coupons = Voucher::where('type', 1)->where('location_id', Auth::user()->location_id)->get();
            }
            return view('manage.coupons.index', compact('coupons'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create-coupon', Voucher::class)) {

            $location_id = Auth::user()->location_id;
            return view('manage.coupons.create');

        } else {
            return view('errors.403');
        }
    }

    public function store(CouponsCreateRequest $request)
    {
        if(Auth::user()->can('create-coupon', Voucher::class)) {
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["code"] = $userInput["code"];
            $input["description"] = $userInput["description"];
            $input["discount_amount"] = $userInput["discount_amount"];
            $input["starts_at"] = $userInput["starts_at"];
            $input["expires_at"] = $userInput["expires_at"];
            $input["valid_above_amount"] = $userInput["valid_above_amount"];

            $input['type'] = 1;
            $input['is_fixed'] = true;
            $input['uses'] = 0;

            $locations = Location::pluck('name','id')->all();

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            $coupon = Voucher::create($input);

            session()->flash('coupon_created', __("New coupon has been added."));
            return redirect(route('manage.coupons.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update-coupon', Voucher::class)) {

            $coupon = Voucher::where('location_id', Auth::user()->location_id)->where('id', $id)->firstOrFail();
            return view('manage.coupons.edit', compact('coupon'));
        } else {
            return view('errors.403');
        }
    }

    public function update(CouponsUpdateRequest $request, $id)
    {
        if(Auth::user()->can('update-coupon', Voucher::class)) {
            $coupon = Voucher::findOrFail($id);
            $this->validate($request, [
                'code' => 'unique:vouchers,code,'.$coupon->id
            ]);
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["code"] = $userInput["code"];
            $input["description"] = $userInput["description"];
            $input["discount_amount"] = $userInput["discount_amount"];
            $input["starts_at"] = $userInput["starts_at"];
            $input["expires_at"] = $userInput["expires_at"];
            $input["valid_above_amount"] = $userInput["valid_above_amount"];
            $coupon->update($input);
            session()->flash('coupon_updated', __("The coupon has been updated."));
            return redirect(route('manage.coupons.edit', $coupon->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete-coupon', Voucher::class)) {
            $coupon = Voucher::findOrFail($id);
            $coupon->delete();
            session()->flash('coupon_deleted', __("The coupon has been deleted."));
            return redirect(route('manage.coupons.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteCoupons(Request $request)
    {
        if(Auth::user()->can('delete-coupon', Voucher::class)) {
            if(isset($request->delete_single)) {
                $coupon = Voucher::findOrFail($request->delete_single);
                $coupon->delete();
                session()->flash('coupon_deleted', __("The coupon has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $coupons = Voucher::findOrFail($request->checkboxArray);
                    foreach($coupons as $coupon) {
                        $coupon->delete();
                    }
                    session()->flash('coupon_deleted', __("The selected coupons have been deleted."));
                } else {
                    session()->flash('coupon_not_deleted', __("Please select coupons to be deleted."));
                }
            }
            return redirect(route('manage.coupons.index'));
        } else {
            return view('errors.403');
        }
    }
}
