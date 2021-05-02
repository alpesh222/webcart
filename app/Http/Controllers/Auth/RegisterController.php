<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Mobile;
use App\Http\Controllers\Controller;
use App\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Events\Auth\UserActivationEmail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['name'] = trim($data['name']);
        $data['name'] = ucwords(strtolower($data['name']));

        $validationRules = [
            'name'          =>'required|max:50',
            'email'         =>'unique:users|required|min:5|max:80|email',
            'username'      =>'unique:users|required|min:4|max:50',
            'password'      =>'confirmed|required|min:6|max:80',
            'shop_name'     =>'required_with:vendor'
        ];

        if(config('settings.phone_otp_verification')) {
            $validationRules['phone'] = 'required';
            $validationRules['phone-number'] = 'required';

            $mobile = Mobile::where('number', $data['phone'])->where('verified', true)->first();
            if($mobile) {
                $validator = Validator::make([], []);
                $validator->errors()->add('phone', __('This phone number is already registered.'));
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        }

        if(config('recaptcha.enable')) {
            $validationRules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return Validator::make($data, $validationRules);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (Cart::count() > 0) {
            $this->redirectTo = '/cart';
        }
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user_data = [
            'name'      => $data['name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'verified'  => false,
            'activation_token' => str_random(191)
        ];

        $phone_otp_verification = config('settings.phone_otp_verification');

        if($phone_otp_verification) {
            $user_data['phone'] = $data['phone'];
        }

        if(request()->vendor) {
            $user_role_id = Role::vendorRoleId();
            $user_data['role_id'] = $user_role_id;
        }
        $user = User::create($user_data);

        // Check if the referral system is enabled or not
        if ( config('referral.enable') ){
            $user->self_referral_code    =  User::generateUniqueReferralCode(6);
            if ( isset( $data['referral_by_code'] ) && !empty( $data['referral_by_code'] ) ){
                $user->referral_by_code  = $data['referral_by_code'];
                $user->save();
                $referral_exist = User::checkReferralCodeExist($user->referral_by_code);
                if ( $referral_exist['status'] ){
                    //Add amount to Current user wallet
                    $wallet     = new Wallet();
                    $action     = 'credit';
                    $amount     = config('referral.referral_to_amt');
                    $txn_code   = config('wallet.codes.refer');
                    $txn_des    = 'Cr. W.A. '.$amount.'/- | Referral Amount For Code : #'. $user->referral_by_code;
                    $wallet->walletTransaction($amount, $action, $txn_code, $user->id, $txn_des);
                    //Add amount to referred by person wallet
                    $wallet     = new Wallet();
                    $action     = 'credit';
                    $amount     = config('wallet.referral_by_amt');
                    $txn_code   = config('wallet.codes.refer');
                    $refer_by_user = User::where(['self_referral_code' => $user->referral_by_code, 'verified' => 1, 'is_active' => 1,])->first();
                    $txn_des    = 'Cr. W.A. '.$amount.'/- | Referral Code Used Amount By Username : #'. $user->username;
                    $wallet->walletTransaction($amount, $action, $txn_code, $refer_by_user->id, $txn_des);
                }
            }
        }

        if($phone_otp_verification) {
            $mobile = new Mobile([
                'number' => $data['phone']
            ]);
            $user->mobile()->save($mobile);
        }

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if(config('vendor.enable_vendor_signup') && $request->vendor) {
            $user->vendor()->create([
                'shop_name' => $request->shop_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state
            ]);
        }

        // Sending Email
        event(new UserActivationEmail($user));
        $this->guard()->logout();
        return redirect()->route('login')->withSuccess(__('Registered. Please check your email to activate your account.'));
    }

    public function checkValidReferralCode(Request $request){
        $response = User::checkReferralCodeExist($request->referral_code);
        return response()->json($response);
    }
}
