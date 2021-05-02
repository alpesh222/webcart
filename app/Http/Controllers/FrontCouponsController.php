<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voucher;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontCouponsController extends Controller
{
    public function checkCoupon(Request $request)
    {
        $coupon = Voucher::where('type', 1)->where('code', $request->coupon)->first();

        if($coupon && ($coupon->location_id == session('location_id')) && $coupon->valid_above_amount < Cart::total() && Carbon::now()->gte(Carbon::parse($coupon->starts_at)) && Carbon::now()->lte(Carbon::parse($coupon->expires_at))) {

            // If user has already used this coupon
            if($coupon->users()->where('user_id', Auth::user()->id)->count() > 0) {
                $coupon_user = $coupon->users()->where('user_id', Auth::user()->id)->first();
                $coupon_user->pivot->uses += 1;
                $coupon_user->pivot->save();

            // If user has not used this coupon
            } else {
                Auth::user()->vouchers()->attach($coupon->id, ['uses'=>1]);
            }

            $coupon->uses += 1;
            $coupon->save();

            session(['coupon_amount' => $coupon->discount_amount]);
            session(['coupon_valid_above_amount' => $coupon->valid_above_amount]);
            session(['coupon_code' => $coupon->code]);
        } else {
            $this->clearCoupon();
        }
        return back();
    }

    private function clearCoupon()
    {
        session()->forget('coupon_amount');
        session()->forget('coupon_valid_above_amount');
        session()->forget('coupon_code');
        session()->flash('coupon_invalid', __('Coupon invalid or expired.'));
    }
}
