<h4 class="">@lang('Sign in')</h4>
<p class="">@lang('Hello, Welcome to your account.')</p>

<form class="register-form outer-top-xs" role="form" method="POST" action="{{ route('login') }}"
      onsubmit="$('#login-button').text('{{__('Please Wait...')}}').prop('disabled', true);">
    {{ csrf_field() }}

    <div class="form-group input-group{{ $errors->has('username') || $errors->has('email') ? ' has-error' : '' }}">
        <label class="info-title" for="username">@lang('Username') <span>*</span></label>
        <input type="text" class="form-control unicase-form-control text-input" name="username" id="username" required
               placeholder="@lang('Enter your username')">
    </div>
    @if ($errors->has('username'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('username') }}</strong></span>
    @endif
    @if ($errors->has('email'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('email') }}</strong></span>
    @endif

    <div class="form-group input-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="info-title" for="password">@lang('Password') <span>*</span></label>
        <input type="password" class="form-control unicase-form-control text-input" id="password" name="password"
               required placeholder="@lang('Enter your password')">
    </div>
    @if ($errors->has('password'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('password') }}</strong></span>
    @endif

    <div class="radio mb-20">
        <label class="pl-0">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember me')
        </label>
        @if (count($errors) > 0)
            <a href="{{ route('password.request') }}" class="forgot-password pull-right"> @lang('Forgot Your Password?')</a><br>
            <a href="{{ route('auth.activate.resend') }}" class="forgot-password pull-right">@lang('Resend Activation Email')</a>
        @endif
    </div>
    <button type="submit" id="login-button" class="btn-upper btn btn-primary checkout-page-button">Login</button>
</form>