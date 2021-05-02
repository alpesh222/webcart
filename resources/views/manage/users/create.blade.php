@extends('layouts.manage')

@section('title')
    @lang('Add Staff')
@endsection

@section('page-header-title')
    @lang('Add Staff') <a class="btn btn-info btn-sm" href="{{route('manage.users.index')}}">@lang('View Staff')</a>
@endsection

@section('page-header-description')
    @lang('Add New Staff') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('content')
    @include('partials.manage.users.create')
@endsection