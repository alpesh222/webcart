@extends('layouts.front')

@section('title')@lang('Invoice')-{{$order->getOrderId()}}-{{$order->created_at->format('dmY')}}@if(!empty(config('settings.site_logo_name')))-{{str_slug(config('settings.site_logo_name'))}}@endif - {{config('app.name')}}@endsection

@section('page-header-title')
    @lang('View Invoice')
@endsection

@section('page-header-description')
    @lang('View and Print Invoice')
@endsection

@section('content')
	<div class="container">
		@include('partials.invoice')
	</div>
@endsection