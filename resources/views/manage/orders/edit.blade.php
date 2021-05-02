@extends('layouts.manage')

@section('title')
    @lang('Edit Order')
@endsection

@section('page-header-title')
    @lang('Edit Order') <a class="btn btn-info btn-sm" href="{{route('manage.orders.index')}}">@lang('View Orders')</a>
@endsection

@section('page-header-description')
    @lang('Edit Order') <a href="{{route('manage.orders.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
    @include('includes.order_tracker_style')
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('order_updated'))
            toastr.success("{{session('order_updated')}}");
        @endif
        @if(session()->has('order_not_updated'))
            toastr.error("{{session('order_not_updated')}}");
        @endif
    </script>
    @endif
    <script>
        $('.shipment_box').dropdown({
            // options here
        });

        var delivered = $('#delivered');
        var deliveredBox = $('#delivered-box');
        var notDelivered = $('#not-delivered');
        var notDeliveredBox = $('#not-delivered-box');
        var shipmentBox = $('#shipment_box');
        var receiverDetail = $('#receiver_detail_box');
        receiverDetail.hide();
        $(document).on('change', '#delivered', function() {
            if(delivered.is(':checked')) {
                shipmentBox.hide();
                notDeliveredBox.hide();
                receiverDetail.fadeIn();
            } else {
                receiverDetail.hide();
                notDeliveredBox.fadeIn();
                shipmentBox.fadeIn();
            }
        });
        $(document).on('change', '#not-delivered', function() {
            if(notDelivered.is(':checked')) {
                deliveredBox.hide();
            } else {
                deliveredBox.fadeIn();
            }
        });
    </script>
@endsection

@section('content')
    @include('partials.manage.orders.edit')
@endsection