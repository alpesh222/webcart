@extends('layouts.manage')

@section('title')
    @lang('Edit Testimonial')
@endsection

@section('page-header-title')
    @lang('Edit Testimonial') <a class="btn btn-info btn-sm" href="{{route('manage.testimonials.index')}}">@lang('View Testimonials')</a>
@endsection

@section('page-header-description')
    @lang('Edit Testimonial') <a href="{{route('manage.testimonials.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('testimonial_updated'))
            toastr.success("{{session('testimonial_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.testimonials.edit')
@endsection