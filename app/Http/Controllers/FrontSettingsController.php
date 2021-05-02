<?php

namespace App\Http\Controllers;

use App\User;
use App\Photo;
use App\Mobile;
use Validator;
use App\Http\Requests\UsersUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Auth\UserActivationEmail;

class FrontSettingsController extends Controller
{
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        return view('front.settings.profile', compact('user'));
    }

    function updateProfile(UsersUpdateRequest $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'unique:users,email,'.$user->id,
            'username' => 'unique:users,username,'.$user->id
        ];

        $phone_verification = config('settings.phone_otp_verification');

        if($phone_verification) {
            $mobile = Mobile::where('number', $request->phone)->where('verified', true)->where('user_id', '!=', $id)->first();

            if($mobile) {
                $validator = Validator::make([], []);
                $validator->errors()->add('phone', 'This phone number is already registered.');
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $rules['phone'] = 'required';
            $rules['phone-number'] = 'required';
        }

        $this->validate($request, $rules);

        $input = $request->all();

        $old_email = $user->email;

        if($old_email != $request->email) {
            if($user->id != 1){
                $input['verified'] = false;
            }else{
                $input['verified'] = true;
            }
            $input['activation_token'] = str_random(191);
        } else {
            $input['verified'] = $user->verified;
            $input['activation_token'] = $user->activation_token;
        }

        $user_data = [
            "name" => $input["name"],
            "username" => $input["username"],
            "email" => $input["email"],
            "password" => $request->password ? bcrypt($request->password) : $user->password,
            "verified" => $input["verified"],
            "activation_token" => $input["activation_token"]
        ];

        if($phone_verification) {
            $user_data['phone'] = $input['phone'];
        }

        $user->fill($user_data)->save();

        if($phone_verification) {
            if($user->mobile) {
                $old_mobile = $user->mobile->number;
                if($old_mobile != $request->phone) {
                    $user->mobile()->update(['verified' => false, 'number' => $request->phone]);
                }
            } else {
                $mobile = new Mobile(['verified' => false, 'number' => $request->phone]);
                $user->mobile()->save($mobile);
            }  
        }

        if($request->email != $old_email) {
            event(new UserActivationEmail($user));
            session()->flash('email_activation', __('Activation link has been sent to :request_email. Please activate your account.', ['request_email'=>$request->email]));
            Auth::logout();
            return redirect('/');
        }

        session()->flash('profile_updated', __("The profile has been updated."));

        return redirect(route('front.settings.profile'));
    }
}
