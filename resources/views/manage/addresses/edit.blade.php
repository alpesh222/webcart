@extends('layouts.manage')

@section('title')
    @lang('Edit Shipping Address')
@endsection

@section('page-header-title')
    @lang('Edit Shipping Address') <a class="btn btn-info btn-sm" href="{{route('manage.customers.index')}}#addresses">@lang('View Shipping Addresses')</a>
@endsection

@section('page-header-description')
    @lang('Edit Role') <a href="{{route('manage.customers.edit', $customer->user_id)}}">@lang('Go Back')</a>
@endsection

@section('styles')
    @include('partials.phone_style')
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('address_updated'))
            toastr.success("{{session('address_updated')}}");
        @endif
    </script>
    @endif
    @include('partials.phone_script')
    <script>
        @if($customer->country)
            $('#country').val("{{$customer->country}}");
        @endif
    </script>
@endsection

@section('content')
    @include('partials.manage.addresses.edit')
@endsection
