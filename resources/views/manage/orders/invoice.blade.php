@extends('layouts.manage')

@section('title')@lang('Invoice')-{{$order->getOrderId()}}-{{$order->created_at->format('dmY')}}@if(!empty(config('settings.site_logo_name')))-{{str_slug(config('settings.site_logo_name'))}}@endif - {{config('app.name')}}@endsection

@section('page-header-title')
	@lang('View Invoice')
@endsection

@section('page-header-description')
    @lang('View and Print Invoice')
@endsection

@section('styles')
@include('includes.order_tracker_style')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if($order->receiver_detail)
			<div class="label label-primary"><strong>@lang('Receiver Detail:')</strong></div>
			<div class="well">{{$order->receiver_detail}}</div>
			@endif
	        @if(count($order->shipments) > 0)
	        <div class="row bs-wizard" style="border-bottom:0;">
	        @foreach($order->shipments as $shipment)
	            @if($order->shipments->contains($shipment->id))
	            <div class="col-xs-3 bs-wizard-step complete">
	              <div class="text-center bs-wizard-stepnum">{{$shipment->name}}</div>
	              <div class="progress"><div class="progress-bar"></div></div>
	              <a href="#" class="bs-wizard-dot"></a>
	              <div class="bs-wizard-info text-center">{{$shipment->address. ', ' .$shipment->city. ', ' .$shipment->state. ' - ' .$shipment->zip. ' ' .$shipment->country}}
	              <br>
	              {{$shipment->created_at->toCookieString()}}
	              </div>
	            </div>
	            @endif
	        @endforeach
            @if($order->is_processed == 1)
                <div class="col-xs-3 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">@lang('Delivered')</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">
          			{{Carbon\Carbon::parse($order->processed_date)->toCookieString()}}
                  </div>
                </div>
            @endif
	        </div>
	        <hr>
	        @endif
		</div>
	</div>
	@include('partials.invoice')
@endsection