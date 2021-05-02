@extends('layouts.manage')

@section('title')
    @lang('Add New Discount to Products')
@endsection

@section('page-header-title')
    @lang('Add New Discount to Products') <a class="btn btn-info btn-sm" href="{{route('manage.product-discounts.index')}}">@lang('View Product Discounts')</a>
@endsection

@section('page-header-description')
    @lang('Add New Discount to Products') <a href="{{route('manage.product-discounts.index')}}">@lang('Go Back')</a>
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
    @include('partials.manage.discounts.products.create')
@endsection