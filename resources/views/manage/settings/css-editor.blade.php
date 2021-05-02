@extends('layouts.manage')

@section('title')
    @lang('Custom CSS')
@endsection

@section('page-header-title')
    @lang('Save Settings')
@endsection

@section('page-header-description')
    @lang('View and Update Settings')
@endsection

@section('styles')
    <link href="{{asset('css/colorpicker/colorpicker.css')}}" rel="stylesheet">
    <style>
        .colorpicker-component{
            margin-right: 30px;
        }
        .input-group[class*=col-]{
            float: inherit;
        }
        .pl-0{
            padding-left: 0;
        }
        .mt-2{
            margin-top: 20px;
        }
    </style>
@endsection()

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
    @include('partials.manage.settings.css-editor')
@endsection