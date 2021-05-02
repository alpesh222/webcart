<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $loginType = request()->input('username');
        $this->username = filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$this->username => $loginType]);
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => [ //Make an custom array
                'required','string',
                Rule::exists('users')->where(function ($query) { //create closure with query builder to check the users
                    $query->where('verified', true); //where verified column is true
                })
            ],
            'password' => 'required|string',
        ], $this->validationErrors());
    }
    /**
     * Get the validation errors for login.
     *
     * @return array
     */
    public function validationErrors()
    {
        return [
            $this->username() . '.exists' => __('The selected username is invalid or you need to activate your account.')
        ];
    }
}
