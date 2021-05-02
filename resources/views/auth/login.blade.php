@extends('layouts.front')

@section('title')
    @lang('Login') - {{config('app.name')}}
@endsection

@section('styles')
<style>
#myFooter {
    bottom: -100px;
    position: relative
}

.login-container {
    margin-top: 5%;
    margin-bottom: 5%;
}

.login-logo {
    position: relative;
    margin-left: -41.5%;
}

.login-logo img {
    position: absolute;
    width: 20%;
    margin-top: 19%;
    background: #282726;
    border-radius: 4.5rem;
    padding: 5%;
}

.login-form-1 {
    padding: 9%;
    background: var(--main-color);
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}

.login-form-1 h3 {
    margin-left: 4px;
    color: #fff;
}

.login-form-2 {
    padding: 9% 5%;
    background: #ebebeb;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}

.login-form-2 h3 {
    text-align: center;
    margin-bottom: 6%;
    color: #2196f3;
}

.btnSubmit {
    font-weight: 600;
    width: 50%;
    color: #282726;
    background-color: #fff;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
}

.btnForgetPwd {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}

.wb_credentials_inner-col a.text-primary {
    font-size: 18px;
    color: #2196f3;
}

.btnForgetPwd:hover {
    text-decoration: none;
    color: #fff;
}

.breadcrumb_container {
    box-shadow: 12px 9px 17px #adadad;
    background-color: var(--main-color);
    margin-bottom: 60px;
    color: #ffff;
    padding: 40px;
}

.breadcrumb_container h1.text-primary {
    color: #fff;
}

.login-container .form-control {
    height: 50px;
    background: #fff;
    border-radius: 50px!important;
    display: block;
    font-size: 18px;
}

.login-container .input-group {
    display: -webkit-box;
    margin-bottom: 20px;
    border-collapse: separate;
}

.login-container .text-danger,
.login-container .text-danger:hover {
    color: #fff;
}

.login-container,
.login-container a {
    color: #fff;
    font-size: 16px;
}

.login-container button#login-button {
    width: 200px;
    height: 46px;
    margin-bottom: 20px;
    background-color: rgba(0, 0, 0, 0.38);
    font-size: 18px;
    border-radius: 50px!important;
}

.login-container a.btn.btn-sm.btn-primary:hover,
.login-container .btn-group.open .dropdown-toggle.btn-primary,
.login-container .btn-primary:focus,
.login-container .btn-primary:hover {
    background-color: #000;
    border-color: #000;
}

.wb_credentials_inner-col {
    padding-bottom: 15px;
    margin-bottom: 14px;
    border-bottom: 1px solid rgba(109, 109, 109, 0.1803921568627451);
    font-size: 16px;
    padding: 22px;
    color: #333;
    float: left;
}

.wb_credentials_inner-col:last-child {
    border-bottom: 0;
    margin-bottom: 0;
}

.col-md-8.wb_flex {
    display: flex;
}

.col-md-8.wb_flex a {
    color: #fff;
}

.login-container a:hover {
    /*color: #333;*/
}

@media (min-width: 992px) {
    .container.login-container {
        display: flex;
    }
}
</style>
@endsection

@section('content')
    <div class="breadcrumb_container">
        <div class="container text-center">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <br/><br/>
                <h1 class="text-primary"> {{config('app.name')}} : @lang('Login')</h1>
                <h5>( @lang('Login to get access') )</h5>
                <br/>
            </div>
        </div>
    </div>
    <div>
    <div class="container login-container">
        <div class="col-md-6 col-md-offset-3 login-form-1">
                <h3>@lang('Enter Details To Login')</h3>

                <form onsubmit="login();" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <br/>
                    <div class="form-group input-group{{ $errors->has('username') || $errors->has('email') ? ' has-error' : '' }}">
                        <input  type="text" name="username" class="form-control" placeholder="@lang('Your Username')"/>
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong class="text-danger">
                                {{ $errors->first('username') }}
                            </strong>
                        </span>
                    @endif
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong class="text-danger">
                                {{ $errors->first('email') }}
                            </strong>
                        </span>
                    @endif
                    <div class="form-group input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input  type="password" name="password" class="form-control"
                               placeholder="@lang('Your Password')"/>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong class="text-danger">
                                {{ $errors->first('password') }}
                            </strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                            @lang('Remember me')
                        </label>
                    </div>
                    <button id="login-button" type="submit" class="btn btn-primary btn-block">@lang('Login Now')</button>
                    <hr />
                    @lang('Not Register ?') <a href="{{url('/register')}}" >@lang('Click here') </a>
                    @if (count($errors) > 0)
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                @lang('Forgot Your Password?')
                            </a>
                            <a class="btn btn-link" href="{{ route('auth.activate.resend') }}">
                                @lang('Resend Activation Email')
                            </a>
                        </div>
                    </div>
                    @endif
                </form>
                <script>
                    function login() {
                        $('#login-button')
                            .text('{{__('Please Wait...')}}')
                            .prop('disabled', true);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
