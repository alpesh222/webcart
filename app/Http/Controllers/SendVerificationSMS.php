<?php

namespace App\Http\Controllers;

use App\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SmsHelper;

class SendVerificationSMS extends Controller
{
    public function sendOtp(Request $request) {
        if(config('settings.phone_otp_verification') && \Illuminate\Support\Facades\Request::ajax()) {
            $user = Auth::user();
            if($user->mobile && !$user->mobile->verified) {
                $phone_exists = Mobile::where('number', $user->mobile->number)->where('verified', 1)->first();
                if($phone_exists) {
                    return response()->json(['sent' => false, 'number' => $user->mobile->number, 'message' => __('This phone number is already associated with an account. Please update your phone number.')]);
                }
                $otp = rand(100000, 999999);
                session(['phone_verification_code' => $otp]);

                $mobile = $user->mobile->number;
                $message = __('Your phone verification OTP is: :OTP', ['OTP' => $otp]);

        		SmsHelper::send($mobile, $message, true);
                return response()->json(['sent' => true, 'number' => $user->mobile->number]);
            }
            return response()->json(['sent' => false]);
        }
    }

    public function verifyForm(Request $request) {
        if(config('settings.phone_otp_verification') && $request->ajax()) {
            return view('partials.front.verify-phone');
        }
    }

    public function verifyOtp(Request $request) {
        if(config('settings.phone_otp_verification') && \Illuminate\Support\Facades\Request::ajax()) {
            if(session()->has('phone_verification_code')) {
                $user = Auth::user();
                if($request->code && $user->mobile) {
                    $otp = session('phone_verification_code');
                    if($otp == $request->code) {
                        $user->mobile()->update(['verified' => true]);
                        session()->forget('phone_verification_code');
                        session()->forget('phone_verification_code_attempt');
                        return response()->json(['verified' => true]);
                    }
                }
                $phone_verification_code_attempt = session()->has('phone_verification_code_attempt') ? session('phone_verification_code_attempt') : 0;
                session(['phone_verification_code_attempt' => $phone_verification_code_attempt + 1]);

                if($phone_verification_code_attempt >= 3) {
                    session()->forget('phone_verification_code');
                    session()->forget('phone_verification_code_attempt');
                    return response()->json(['verified' => false, 'redirect' => true]);
                }
            }
            return response()->json(['verified' => false]);
        }
    }
}
