@extends('layouts.manage')

@section('title')
    @lang('Edit Delivery Location')
@endsection

@section('page-header-title')
    @lang('Edit Delivery Location') <a class="btn btn-info btn-sm" href="{{route('manage.delivery-location.index')}}">@lang('View Delivery Locations')</a>
@endsection

@section('page-header-description')
    @lang('Edit Delivery Location') <a href="{{route('manage.delivery-location.index')}}">@lang('Go Back')</a>
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
        @if($delivery_location_data->country)
            $('#country').val("{{$delivery_location_data->country}}");
        @endif
    </script>
@endsection

@section('content')
    @include('partials.manage.deliveryLocation.edit')
@endsection