@extends('layouts.manage')

@section('title')
    @lang('Edit Role')
@endsection

@section('page-header-title')
    @lang('Edit Role') <a class="btn btn-info btn-sm" href="{{route('manage.roles.index')}}">@lang('View Roles')</a>
@endsection

@section('page-header-description')
    @lang('Edit Role') <a href="{{route('manage.roles.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('role_updated'))
            toastr.success("{{session('role_updated')}}");
        @endif
    </script>
    @endif
@endsection
@section('content')
    @include('partials.manage.roles.edit')
@endsection