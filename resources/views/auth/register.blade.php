@extends('layouts.front')

@section('title')
    @lang('Register') - {{config('app.name')}}
@endsection

@section('styles')
@if(config('settings.phone_otp_verification'))
@include('partials.phone_style')
<style>
.intl-tel-input {
    z-index: 3;
}
.input-group #phone-number:focus {
    z-index: unset;
}
.intl-tel-input.separate-dial-code .selected-flag {
    border-radius: 50px 0 0 50px;
}
</style>
@endif
<style>
#myFooter {
    bottom: -100px;
    position: relative
}

.register_page_inner .form-control {
    height: 50px;
    background: #fff;
    border-radius: 50px!important;
    display: block;
    font-size: 18px;
}

.register_page_inner .text-danger,
.register_page_inner .text-danger:hover {
    font-weight: normal;
}

.register_page_inner .form-group {
    margin: 15px 0px;
    float: left;
    padding: 0px 15px;
}

.container.register_page .nav-tabs.nav-justified>li.nav-item.active>a {
    background-color: #fff;
    color: var(--main-color)!important;
}

.nav-tabs.nav-justified>.active>a,
.nav-tabs.nav-justified>.active>a:focus,
.nav-tabs.nav-justified>.active>a:hover {
    border: 1px solid #e7e7e7;
    height: 50px;
}

.container.register_page .nav-tabs.nav-justified>li>a {
    border-bottom: 1px solid var(--main-color);
    border-radius: 20px 20px 0 0;
    line-height: 30px;
    height: 50px;
    margin: 0px 0px;
    font-size: 20px;
    background-color: var(--main-color);
}

.container.register_page .nav-tabs>li>a:hover {
    color: var(--mian-color);
    border-color: var(--mian-color);
}

.container.register_page form.form-horizontal {
    height: 100%;
    background: #ffffff;
    border: 1px solid var(--main-color);
    display: flow-root;
    margin: -2px 0px;
    padding-bottom: 60px;
}

.register_page_inner>h3 {
    text-align: center;
    font-weight: bold;
    font-size: 30px;
    color: #363636;
    margin-bottom: 60px;
}

.container.register_page {
    padding: 60px;
    margin-bottom: 80px;
    background: #ebebeb;
    border-radius: 20px;
}

.register_page_inner #register-button {
    height: 50px;
    border-radius: 50px!important;
    display: block;
    font-size: 18px;
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

.nav-tabs>li>a {
    border-color: var(--dark-color)!important;
}

.nav-tabs>li.active>a {
    border-color: var(--main-color)!important;
}

.form-group.col-md-6.input-group p {
    padding-top: 0;
    padding-left: 10px;
}
</style>
@endsection

@section('scripts')
    @if(config('settings.phone_otp_verification'))
    @include('partials.phone_script')
    @endif
    <script>
    $('#sellor-tab').on('click', function() {
        $('.is_vendor').remove();
        $('.check_vendor_terms').remove();
        $('#register-button').attr('disabled',true);
        $('<input type="hidden" name="vendor" value="1" class="is_vendor">').appendTo('#sellor');
        var terms_url = '';
        @if(config('settings.terms_of_service_url'))
                terms_url = '<a class="text-primary" href="{{config('settings.terms_of_service_url')}}">terms and conditions</a>';
        @endif
        $('<div class="col-md-12 check_vendor_terms"><input type="checkbox" id="check_vendor_terms" onclick="checkTermsConditions()"> <span> I Accept Terms and Conditions '+terms_url+'</span></div>').appendTo('#term_checkbox');
    });
    $('#buyer-tab').on('click', function() {
        $('.is_vendor').remove();
        $('.check_vendor_terms').remove();
        $('#register-button').attr('disabled',false);
    });
    function checkTermsConditions(){
        if ($('#check_vendor_terms').prop('checked') == true){
            $('#register-button').attr('disabled',false);
        } else {
            $('#register-button').attr('disabled',true);
        }
    }
    </script>
@endsection

@section('content')
    <div class="breadcrumb_container">
        <div class="text-center container">
            <div class="col-md-12">
                <br/><br/>
                <h1 class="text-primary"> {{config('app.name')}} : @lang('Register')</h1>

                <h5>( @lang('Register yourself to get access') )</h5>
            </div>
        </div>
    </div>
    <div>
        <div class="container register_page">
            <div class="register_page_inner">
                <h3> @lang('New User ? Register Yourself') </h3>

                @if(config('vendor.enable_vendor_signup'))
                <div class="nav_cover_tabs">
                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" id="buyer-tab" data-toggle="tab" href="#buyer" role="tab" aria-controls="buyer" aria-selected="true">@lang('Buyer')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sellor-tab" data-toggle="tab" href="#sellor" role="tab" aria-controls="sellor" aria-selected="false">@lang('Seller')</a>
                        </li>
                    </ul>
                </div>
                @endif

                <form onsubmit="register();" class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <br/>
                    <div class="form-group col-md-6 input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input placeholder="@lang('Your Name')" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
                                </strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6 input-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="@lang('Your Username')" name="username" value="{{ old('username') }}" required>
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('username') }}
                                </strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6 input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input placeholder="@lang('Your Email')" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('email') }}
                                </strong>
                            </span>
                        @endif
                    </div>

                    @if(config('settings.phone_otp_verification'))
                    <div class="form-group col-md-6 input-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" name="phone-number" id="phone-number" class="form-control" value="{{old('phone')}}" placeholder="@lang('Your Phone Number')">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('phone') }}
                                </strong>
                            </span>
                        @endif
                    </div>
                    @endif

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="buyer" role="tabpanel" aria-labelledby="buyer-tab">
                        </div>
                        <div class="tab-pane fade" id="sellor" role="tabpanel" aria-labelledby="sellor-tab">
                            <div class="form-group col-md-6 input-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                                <input placeholder="@lang('Shop Name')" type="text" class="form-control" name="shop_name" value="{{ old('shop_name') }}">
                                @if ($errors->has('shop_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">
                                            {{ $errors->first('shop_name') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 input-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <input placeholder="@lang('Address')" type="text" class="form-control" name="address" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">
                                            {{ $errors->first('address') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 input-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <input placeholder="@lang('City')" type="text" class="form-control" name="city" value="{{ old('city') }}">
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong class="text-danger">
                                            {{ $errors->first('city') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6 input-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                <input placeholder="@lang('State')" type="text" class="form-control" name="state" value="{{ old('state') }}">
                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong class="text-danger">
                                            {{ $errors->first('state') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="form-group col-md-6 input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input required type="password" name="password" class="form-control"
                               placeholder="@lang('Enter Password')" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('password') }}
                                </strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6 input-group">
                        <input placeholder="@lang('Retype Password')" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    @if( config('referral.enable') )
                        <div class="form-group col-md-6 input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input placeholder="@lang('Your Email')" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('email') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 input-group{{ $errors->has('referral_by_code') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" id="referral_by_code" name="referral_by_code"
                                   onblur="checkValidReferralCode(this.id, this.value, 'referral_error')"
                                   placeholder="@lang('Enter referral code')" value="{{ old('referral_by_code') }}" >
                            <span class="help-block hidden" id="referral_error">
                            <strong class="text-danger">{{ !empty( $errors->has('referral_by') ) ? $errors->first('referral_by') : '' }}</strong>
                        </span>
                        </div>
                    @endif

                    <div id="term_checkbox">

                    </div>
                    <br>

                    @if(config('recaptcha.enable'))

                        <div align="center" class="form-group col-md-6 {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong class="text-danger">
                                        {{ $errors->first('g-recaptcha-response') }}
                                    </strong>
                                </span>
                            @endif
                            {!! Recaptcha::render() !!}
                        </div>
                    @endif

                    <div class="form-group col-md-6 input-group">
                        <button id="register-button" type="submit" class="btn btn-primary btn-block">@lang('Register')</button>
                    </div>

                    <div class="form-group col-md-6 input-group">
                        <p>@lang('Already Registered ?') <a href="{{url('/login')}}">@lang('Login here')</a></p>
                    </div>
                </form>
                <script>
                    function register() {
                        $('#register-button')
                            .text('{{__('Please Wait...')}}')
                            .prop('disabled', true);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection