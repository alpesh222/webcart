@extends('layouts.manage')

@section('title')
    @lang('Edit Shipment')
@endsection

@section('page-header-title')
    @lang('Edit Shipment') <a class="btn btn-info btn-sm" href="{{route('manage.shipments.index')}}">@lang('View Shipments')</a>
@endsection

@section('page-header-description')
    @lang('Edit Shipment') <a href="{{route('manage.shipments.index')}}">@lang('Go Back')</a>
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
        @if($shipment->country)
            $('#country').val("{{$shipment->country}}");
        @endif
    </script>
@endsection

@section('content')
    @include('partials.manage.shipments.edit')
@endsection