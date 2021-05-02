@extends('layouts.manage')

@section('title')
    @lang('Add Role')
@endsection

@section('page-header-title')
    @lang('Add Role') <a class="btn btn-info btn-sm" href="{{route('manage.roles.index')}}">@lang('View Roles')</a>
@endsection

@section('page-header-description')
    @lang('Add New Role') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('content')
    @include('partials.manage.roles.create')
@endsection