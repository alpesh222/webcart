@extends('layouts.manage')

@section('title')
    @lang('Edit Customer')
@endsection

@section('page-header-title')
    @lang('Edit Customer') <a class="btn btn-info btn-sm" href="{{route('manage.customers.index')}}">@lang('View Customers')</a>
@endsection

@section('page-header-description')
    @lang('Edit Customer') <a href="{{route('manage.customers.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
@if(config('settings.phone_otp_verification'))
@include('partials.phone_style')
@endif
@endsection

@section('scripts')
    @if(config('settings.phone_otp_verification'))
    @include('partials.phone_script')
    @endif
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('user_updated'))
            toastr.success("{{session('user_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.customers.edit')
@endsection