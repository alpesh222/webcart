@extends('layouts.manage')

@section('title')
    @lang('Add New Delivery Location')
@endsection

@section('page-header-title')
    @lang('Add New Delivery Location') <a class="btn btn-info btn-sm" href="{{route('manage.delivery-location.index')}}">@lang('View Shipments')</a>
@endsection

@section('page-header-description')
    @lang('Add New Delivery Location') <a href="{{route('manage.delivery-location.index')}}">@lang('Go Back')</a>
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
    @include('partials.manage.deliveryLocation.create')
@endsection