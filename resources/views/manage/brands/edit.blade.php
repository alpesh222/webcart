@extends('layouts.manage')

@section('title')
    @lang('Edit Brand')
@endsection

@section('page-header-title')
    @lang('Edit Brand') <a class="btn btn-sm btn-info" href="{{route('manage.brands.index')}}">@lang('View Brands')</a>
@endsection

@section('page-header-description')
    @lang('Edit Brand') <a href="{{route('manage.brands.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('brand_updated'))
            toastr.success("{{session('brand_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.brands.edit')
@endsection