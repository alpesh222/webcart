@extends('layouts.manage')

@section('title')
    @lang('Add Testimonial')
@endsection

@section('page-header-title')
    @lang('Add Testimonial') <a class="btn btn-info btn-sm" href="{{route('manage.testimonials.index')}}">@lang('View Testimonials')</a>
@endsection

@section('page-header-description')
    @lang('Add New Testimonial') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('content')
    @include('partials.manage.testimonials.create')
@endsection