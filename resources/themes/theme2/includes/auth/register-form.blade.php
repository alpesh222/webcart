<h4 class="checkout-subtitle">
    @lang('Create a new account')
    @if(config('vendor.enable_vendor_signup'))
        <div class="pull-right">
            <label><input type="radio" name="user_role" checked value="buyer"> Buyer</label> |
            <label><input type="radio" name="user_role" value="seller"> Seller</label>
        </div>
    @endif
</h4>
<p class="text title-tag-line">@lang('Sign up to get access to exciting offers and promotions')</p>

<form class="register-form outer-top-xs" role="form" id="registration_form" method="POST" action="{{ route('register') }}"
      onsubmit=" $('#register-button').text('{{__('Please Wait...')}}').prop('disabled', true);" >
    {{ csrf_field() }}

    <div class="form-group input-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="info-title" for="name">@lang('Full Name') <span>*</span></label>
        <input type="text" class="form-control unicase-form-control text-input" id="name" name="name"
               value="{{ old('name') }}" placeholder="@lang('Enter your full name')" required >
    </div>
    @if ($errors->has('name'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('name') }}</strong></span>
    @endif

    <div class="form-group input-group{{ $errors->has('username') ? ' has-error' : '' }}">
        <label class="info-title" for="username">@lang('Username') <span>*</span></label>
        <input type="text" class="form-control unicase-form-control text-input" id="username" name="username"
               placeholder="@lang('Enter your username')" value="{{ old('username') }}" required>
    </div>
    @if ($errors->has('username'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('username') }}</strong></span>
    @endif

    <div class="form-group input-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="info-title" for="email">@lang('Email') <span>*</span></label>
        <input type="email" class="form-control unicase-form-control text-input" id="email" name="email"
               placeholder="@lang('Enter your email')" value="{{ old('email') }}" required>
    </div>
    @if ($errors->has('email'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('email') }}</strong></span>
    @endif

    @if(config('settings.phone_otp_verification'))
        <div class="form-group input-group{{ $errors->has('phone-number') ? ' has-error' : '' }}">
            <label class="info-title" for="phone-number">@lang('Phone Number') <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="phone-number" name="phone-number"
                   placeholder="@lang('Enter your phone number')" value="{{ old('phone-number') }}" required>
        </div>
        @if ($errors->has('phone-number'))
            <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('phone-number') }}</strong></span>
        @endif
    @endif

    <div id="seller_form">
        <div class="form-group input-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
            <label class="info-title" for="shop_name">@lang('Shop Name') <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="shop_name" name="shop_name"
                   placeholder="@lang('Enter your shop name')" value="{{ old('shop_name') }}" >
        </div>
        @if ($errors->has('shop_name'))
            <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('shop_name') }}</strong></span>
        @endif

        <div class="form-group input-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="info-title" for="address">@lang('Address') <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="address" name="address"
                   placeholder="@lang('Enter your address')" value="{{ old('address') }}" >
        </div>
        @if ($errors->has('address'))
            <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('address') }}</strong></span>
        @endif

        <div class="form-group input-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label class="info-title" for="city">@lang('City') <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="city" name="city"
                   placeholder="@lang('Enter your city')" value="{{ old('city') }}" >
        </div>
        @if ($errors->has('city'))
            <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('city') }}</strong></span>
        @endif

        <div class="form-group input-group{{ $errors->has('state') ? ' has-error' : '' }}">
            <label class="info-title" for="state">@lang('State') <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="state" name="state"
                   placeholder="@lang('Enter your state')" value="{{ old('state') }}" >
        </div>
        @if ($errors->has('state'))
            <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('state') }}</strong></span>
        @endif
    </div>

    @if( config('referral.enable') )
        <div class="form-group input-group{{ $errors->has('referral_by_code') ? ' has-error' : '' }}">
            <label class="info-title" for="referral_by">@lang('Referral Code')</label>
            <input type="text" class="form-control unicase-form-control text-input" id="referral_by_code" name="referral_by_code"
                   onblur="checkValidReferralCode(this.id, this.value, 'referral_error')"
                   placeholder="@lang('Enter referral code')" value="{{ old('referral_by_code') }}" >
        </div>
        <span class="help-block mt-minus-20 hidden" id="referral_error">
        <strong class="text-danger">{{ !empty( $errors->has('referral_by') ) ? $errors->first('referral_by') : '' }}</strong>
    </span>
    @endif

    <div class="form-group input-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="info-title" for="password">@lang('Password') <span>*</span></label>
        <input type="password" class="form-control unicase-form-control text-input" id="password" name="password"
               value="{{old('password')}}" placeholder="@lang('Enter your password')" required>
    </div>
    @if ($errors->has('password'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('password') }}</strong></span>
    @endif

    <div class="form-group input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="info-title" for="password_confirmation">@lang('Confirm Password') <span>*</span></label>
        <input type="password" class="form-control unicase-form-control text-input" id="password_confirmation" name="password_confirmation"
               value="{{old('password_confirmation')}}" placeholder="@lang('Confirm your password')" required>
    </div>
    @if ($errors->has('password_confirmation'))
        <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong></span>
    @endif

    @if(config('recaptcha.enable'))
        <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
            {!! Recaptcha::render() !!}
            @if ($errors->has('g-recaptcha-response'))
                <span class="help-block mt-minus-20"><strong class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong></span>
            @endif
        </div>
    @endif

    <div id="term_checkbox">

    </div>

    <button type="submit" id="register-button" class="btn-upper btn btn-primary checkout-page-button">@lang('Sign Up')</button>
</form>