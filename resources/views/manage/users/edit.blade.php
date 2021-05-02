@extends('layouts.manage')

@section('title')
    @lang('Edit Staff')
@endsection

@section('page-header-title')
    @lang('Edit Staff') <a class="btn btn-info btn-sm" href="{{route('manage.users.index')}}">@lang('View Staff')</a>
@endsection

@section('page-header-description')
    @lang('Edit Staff') <a href="{{route('manage.users.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('user_updated'))
            toastr.success("{{session('user_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.users.edit')
@endsection