@extends('layouts.manage')

@section('title')
    @lang('Edit Banner')
@endsection

@section('page-header-title')
    @lang('Edit Banner') <a class="btn btn-sm btn-info" href="{{route('manage.banners.index')}}#banners-table">@lang('View Banners')</a>
@endsection

@section('page-header-description')
    @lang('Edit Banner') <a href="{{route('manage.banners.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    @include('partials.manage.categories-tree-style')
    <style>
        .bolden {
            font-family: "Arial Black";
        }
    </style>
@endsection

@section('scripts')
    @include('partials.manage.categories-tree-script');
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('banner_updated'))
            toastr.success("{{session('banner_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.banners.edit')
@endsection