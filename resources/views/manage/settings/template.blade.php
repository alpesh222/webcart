@extends('layouts.manage')

@section('title')
    @lang('Demo Data Settings')
@endsection

@section('page-header-title')
    @lang('Demo Data Settings')
@endsection

@section('page-header-description')
    @lang('View or Change Demo Data Settings')
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('template_updated'))
            toastr.success("{{session('template_updated')}}");
        @endif
    </script>
    @endif
    <script>
        function updateTemplateConfirm() {
            if(confirm('@lang('Are you sure you want to import demo data? All your old data will also be overwrite.')')) {
                event.preventDefault();
                $('#update-template-form').submit();
            } else {
                event.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
    @include('partials.manage.settings.template')
@endsection