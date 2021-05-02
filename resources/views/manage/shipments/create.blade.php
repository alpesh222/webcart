@extends('layouts.manage')

@section('title')
    @lang('Add New Shipment')
@endsection

@section('page-header-title')
    @lang('Add New Shipment') <a class="btn btn-info btn-sm" href="{{route('manage.shipments.index')}}">@lang('View Shipments')</a>
@endsection

@section('page-header-description')
    @lang('Add New Shipment') <a href="{{route('manage.shipments.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    <script>
        $('.user_box').dropdown({
            // options here
        });
    </script>
@endsection

@section('content')
    @include('partials.manage.shipments.create')
@endsection