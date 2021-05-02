@extends('layouts.manage')

@section('title')
    @lang('Language Settings')
@endsection

@section('page-header-title')
    @lang('Language Settings')
@endsection

@section('page-header-description')
    @lang('View or Change Language Settings')
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('language_updated'))
            toastr.success("{{session('language_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.settings.language')
@endsection