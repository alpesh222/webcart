@extends('layouts.front')

@section('title')
    @lang('Login Or Sign Up') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('User Login Or Sign Up')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Login Or Sign Up') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('User Login Or Sign Up')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
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
        </style>
    @endif
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Login Or Sign Up')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="sign-in-page">
        <!-- Sign-in -->
        <div class="col-md-6 col-sm-6 sign-in">
            @include('includes.auth.login-form')
        </div>
        <!-- Sign-in -->

        <!-- create a new account -->
        <div class="col-md-6 col-sm-6 create-new-account">
            @include('includes.auth.register-form')
        </div>
        <!-- create a new account -->
    </div>
@endsection

@section('scripts')
    @if(config('settings.phone_otp_verification'))
        @include('partials.phone_script')
    @endif
    @include('includes.scripts.register-form-script')
    @include('includes.scripts.register_tab_system_script')
@endsection
