<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Events\Auth\UserActivationEmail;

class ActivationResendController extends Controller
{
    public function showResendForm()
    {
    	return view('auth.activate.resend');
    }

    public function resend(Request $request)
    {
    	$this->validateResendRequest($request);
    	$user = User::where('email', $request->email)->first();
    	if($user->verified) {
    		return redirect()->route('login')->withSuccess(__('Email is already activated.'));
    	}
    	event(new UserActivationEmail($user));
    	return redirect()->route('login')->withSuccess(__('Email activation link has been resent. Please check your email to activate your account.'));
    }

    protected function validateResendRequest(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email|exists:users,email'
		], [
			'email.exists' => __('This email does not exist.')
		]);
    }
}
