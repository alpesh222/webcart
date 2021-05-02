@extends('layouts.manage')

@section('title')
    @lang('Settings Overview')
@endsection

@section('page-header-title')
    @lang('Save Settings')
@endsection

@section('page-header-description')
    @lang('View and Update Settings')
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('settings_saved'))
            toastr.success("{{session('settings_saved')}}");
        @endif
        @if(session()->has('settings_not_saved'))
            toastr.error("{{session('settings_not_saved')}}");
        @endif
    </script>
    @endif
    @include('includes.tab_system_scripts')
@endsection

@section('content')
    @include('partials.manage.settings.index')
@endsection