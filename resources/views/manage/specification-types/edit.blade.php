@extends('layouts.manage')

@section('title')
    @lang('Edit Specification Types')
@endsection

@section('page-header-title')
    @lang('Edit Specification Types') <a class="btn btn-sm btn-info" href="{{route('manage.specification-types.index')}}">@lang('View Specifications')</a>
@endsection

@section('page-header-description')
    @lang('Edit Specification Types') <a href="{{route('manage.specification-types.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('specification_type_updated'))
            toastr.success("{{session('specification_type_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.specification-types.edit')
@endsection