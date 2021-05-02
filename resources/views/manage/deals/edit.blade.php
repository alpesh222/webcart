@extends('layouts.manage')

@section('title')
    @lang('Edit Deal')
@endsection

@section('page-header-title')
    @lang('Edit Deal') <a class="btn btn-info btn-sm" href="{{route('manage.deals.index')}}">@lang('View Deals')</a>
@endsection

@section('page-header-description')
    @lang('Edit Deal') <a href="{{route('manage.deals.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <link href="{{asset('css/jquery.datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    <script>
        $('#datetimepicker_start').datetimepicker({
            // options here
        });
        $('#datetimepicker_end').datetimepicker({
            // options here
        });
        $('.product_box').dropdown({
            // options here
        });
    </script>
@endsection

@section('content')
    @include('partials.manage.deals.edit')
@endsection