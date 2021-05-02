@extends('layouts.front')

@section('title'){{$vendor->name . " - " . config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{__('Products of Vendor:') .$vendor->name}}">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$vendor->name . " - " . config('app.name')}}" />
    <meta property="og:description" content="{{__('Products of Vendor:') .$vendor->name}}" />
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection

@section('content')
<div class="wrapper2">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm text-center">
                <h4>@lang('Products by') <span class="text-primary">{{$vendor->shop_name}}</span></h4>
            </div>
            <hr>
        </div>
    </div>
    @include('partials.front.products')

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <h4>@lang('Vendor Details:')</h4>
            <div class="well">
                <ul class="list-group list-unstyled">
                    <li>
                        <strong>@lang('Shop:')</strong>&nbsp;{{$vendor->shop_name}}
                    </li>
                    <li>
                        <strong>@lang('Company:')</strong>&nbsp;{{$vendor->name}}
                    </li>
                    @if($vendor->address)
                    <li>
                        <strong>@lang('Address:')</strong>&nbsp;{{$vendor->address}}
                    </li>
                    @endif
                    @if($vendor->city)
                    <li>
                        <strong>@lang('City:')</strong>&nbsp;{{$vendor->city}}
                    </li>
                    @endif
                    @if($vendor->state)
                    <li>
                        <strong>@lang('State:')</strong>&nbsp;{{$vendor->state}}
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
