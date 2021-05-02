@extends('layouts.manage')

@section('title')
    @lang('Edit Section')
@endsection

@section('page-header-title')
    @lang('Edit Section') <a class="btn btn-sm btn-info" href="{{route('manage.sections.index')}}#sections-table">@lang('View Sections')</a>
@endsection

@section('page-header-description')
    @lang('Edit Section') <a href="{{route('manage.sections.index')}}">@lang('Go Back')</a>
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
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    @include('includes.tinymce')
    @include('partials.manage.categories-tree-script');
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('section_updated'))
            toastr.success("{{session('section_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.sections.edit')
@endsection