@extends('layouts.manage')

@section('title')
    @lang('Add Page')
@endsection

@section('page-header-title')
    @lang('Add Page') <a class="btn btn-info btn-sm" href="{{route('manage.pages.index')}}">@lang('View Pages')</a>
@endsection

@section('page-header-description')
    @lang('Add New Page') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @include('includes.tinymce')
@endsection

@section('content')
    @include('partials.manage.pages.create')
@endsection