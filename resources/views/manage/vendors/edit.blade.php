@extends('layouts.manage')

@section('title')
    @lang('Edit Vendor')
@endsection

@section('page-header-title')
    @lang('Edit Vendor') <a class="btn btn-info btn-sm" href="{{route('manage.vendors.index')}}">@lang('View Vendors')</a>
@endsection

@section('page-header-description')
    @lang('Edit Vendor') <a href="{{route('manage.vendors.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    @include('partials.phone_style')
@endsection

@section('scripts')
    @include('includes.tinymce')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('vendor_updated'))
            toastr.success("{{session('vendor_updated')}}");
        @endif
        @if(session()->has('vendor_not_updated'))
            toastr.success("{{session('vendor_not_updated')}}");
        @endif
    </script>
    @endif
    @include('partials.phone_script')
@endsection

@section('content')
    @include('partials.manage.vendors.edit')
@endsection