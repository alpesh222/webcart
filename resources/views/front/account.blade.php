@extends('layouts.front')

@section('title')@lang('Account Overview') - {{config('app.name')}}@endsection

@section('sidebar')
    <div>
        @include('partials.front.sidebar')
    </div>
@endsection

@section('styles')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
    <style>
        #page-inner {
            background-color: #f5f5f5 !important;
        }
    </style>
@endsection

@section('content')
   <div id="page-wrapper">
        <div id="page-inner">
            <div class="page-title">
                <h2>@lang('Account Overview')</h2>
                <hr>
                <div class="content-panel">
                    <div class="col-md-4">
                    	<div class="well">
	                        <h4>@lang('Orders')</h4>
	                        <hr>
	                        <a href="{{route('front.orders.index')}}">@lang('Your Orders') <i class="fa fa-shopping-cart"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                    	<div class="well">
	                        <h4>@lang('Addresses')</h4>
	                        <hr>
	                        <a href="{{route('front.addresses.index')}}">@lang('Your Addresses') <i class="fa fa-truck"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                    	<div class="well">
	                        <h4>@lang('Profile')</h4>
	                        <hr>
	                        <a href="{{route('front.settings.profile')}}">@lang('Your Profile') <i class="fa fa-wrench"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
