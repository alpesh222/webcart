@extends('layouts.manage')

@section('title')
    @lang('Edit Page')
@endsection

@section('page-header-title')
    @lang('Edit Page') <a class="btn btn-info btn-sm" href="{{route('manage.pages.index')}}">@lang('View Pages')</a>
@endsection

@section('page-header-description')
    @lang('Edit Page') <a href="{{route('manage.pages.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @include('includes.tinymce')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('page_updated'))
            toastr.success("{{session('page_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.pages.edit')
@endsection