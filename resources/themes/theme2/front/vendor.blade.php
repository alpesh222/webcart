@extends('layouts.front')

@section('title')
    {{$vendor->name. ' '. __('Products') . "  - " . config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="{{__('Products of Vendor:') .$vendor->name}}">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$vendor->name . " - " . config('app.name')}}" />
    <meta property="og:description" content="{{__('Products of Vendor:') .$vendor->name}}" />
@endsection

@section('sidebar')
    <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
        {{-- Sidebar Categories --}}
        @include('includes.categories-sidebar')

        {{-- Sidebar Newsletter Subscriber --}}
        @if(config('settings.enable_subscribers'))
            @include('includes.subscriber')
        @endif

        {{--  Sidebar Testimonials --}}
        @if(count($testimonials) > 0)
            @include('partials.front.sidebar.testimonials')
        @endif
    </div>
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-9">
        <div class="col-sm-12">
            <div class="vendor-profile-section text-left">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="col-xs-12">
                            <h2 class="custom-vendor-css">
                                <b><span class="glyphicon glyphicon-credit-card"></span>&nbsp;@lang('Vendor Details')</b>
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <p><strong><span class="glyphicon glyphicon-user"></span> @lang('Vendor Name:')&nbsp;</strong>{{$vendor->name}}</p>
                            <p><strong><span class="glyphicon glyphicon-home"></span> @lang('Shop Name:')&nbsp;</strong>{{$vendor->shop_name}}</p>

                        </div>
                        <div class="col-md-6">
                            <p><strong><span class="glyphicon glyphicon-briefcase"></span> @lang('Vendor Company:')&nbsp;</strong>{{$vendor->name}}</p>
                            <p><strong><span class="glyphicon glyphicon-map-marker"></span> @lang('Vendor Address:')&nbsp;</strong>{{$vendor->address .', ' .$vendor->city. ', ' .$vendor->state  }}</p>
                        </div>
                    </div><!--/col-->
                </div><!--/row-->
            </div>
            <hr>
        </div>
        @include('partials.front.products')
    </div>
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection