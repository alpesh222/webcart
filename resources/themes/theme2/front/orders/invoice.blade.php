@extends('layouts.front')

@section('title')
	@lang('Invoice')-{{$order->getOrderId()}}-{{$order->created_at->format('dmY')}}
	@if(!empty(config('settings.site_logo_name')))-{{str_slug(config('settings.site_logo_name'))}}@endif - {{config('app.name')}}
@endsection

@section('meta-tags')
	<meta name="description" content="@lang('View and Print Invoice')">
@endsection

@section('meta-tags-og')
	<meta property="og:url" content="{{url()->current()}}" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="@lang('View Invoice') - {{config('app.name')}}" />
	<meta property="og:description" content="@lang('View and Print Invoice')" />
	<meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('content')
	<div class="container">
		@include('partials.invoice')
	</div>
@endsection