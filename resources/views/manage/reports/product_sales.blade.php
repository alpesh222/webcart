@extends('layouts.manage')

@section('title')
    @lang('Product Sales Report')
@endsection

@section('page-header-title')
    @lang('Product Sales Report')
@endsection

@section('page-header-description')
    @lang('View Report for Product Sales')
@endsection

@section('styles')
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
    <script>
        $('.product_box').dropdown({
            // options here
        });
        $('#datetimepicker_start').datetimepicker({
            // options here
        });
        $('#datetimepicker_end').datetimepicker({
            // options here
        });
    </script>
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
@endsection

@section('content')
    @include('partials.manage.reports.product_sales')
@endsection