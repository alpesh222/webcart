@extends('layouts.front')

@section('title')@lang('Track Orders') - {{config('app.name')}}@endsection

@section('sidebar')
    <div>
        @include('partials.front.sidebar')
    </div>
@endsection

@section('styles')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
    @include('includes.order_tracker_style')
    <style>
        .order-box{
            border: 1px solid #ccc;
            padding: 15px 30px;
            margin-bottom: 30px;
        }
        .orders-details-inner>h3 {
            padding: 6px!important;
            margin: 0px!important;
            font-size: 18px;
            border-bottom: 1px solid #eee;
        }
        .orders-details-inner>ul>li {
            float: left;
            list-style: none;
            margin-bottom: 20px;
            padding: 10px!important;
            border-right: 1px solid #eee;
        }
        .orders-details-inner ul li a {
            color: #333;
            font-size: 16px;
        }
        .orders-details {
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 15px;
        }
        .bar1, .bar2, .bar3 {
            width: 22px;
            height: 3px;
            background-color: #333;
            margin: 4px 0;
            transition: 0.4s;
        }
        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-7px, 3px) ;
            transform: rotate(-45deg) translate(-7px, 3px) ;
        }
        .change .bar2 {opacity: 0;}
        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-7px, -3px) ;
            transform: rotate(45deg) translate(-7px, -3px) ;
        }
        .btn-toggle-close a{
            margin-top:20px!important;
            display:block;
        }
        .orders-details-inner-sub-2{
            margin-top:15px;
        }
        .orders-details-inner-sub-2 img{
            width:60px;
            float:left;
            margin-right:15px;
        }
        .orders-details-inner-sub-2 h4 a{
            color:#888;
        }
        .orders-details-inner-sub-2 p{
            padding-top:0px;
            font-size:14px;
            color:#333;
        }
        @media(max-width: 767px){
            .orders-details-inner-sub-2 {
                height: 100%;
                display: block;
                margin: 40px auto;
            }
        }
        .panel-body-row {
            text-align: left;
        }
        .img-box {
            text-align: center;
        }
        .img-box .product-img{
            height: 80px;
            width: auto!important;
        }
        .product-img{
            width:100%!important;
        }
        .grand-total p {
            text-align: left;
            padding: 0px;
        }
        .panel-heading, .panel-body {
            border: 1px solid #e5e5e5;
        }
        .panel-heading {
            border-bottom: none;
        }
        .orders-details {
            border: 1px solid #158cba;
            border-radius: 5px;
        }
        .media-body {
            text-align: center;
        }
        .order_detail_item_name {
            color: #444;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>
@endsection

@section('content')
   <div id="page-wrapper">
        <div id="page-inner">
            <div class="page-title">
                <h2>@lang('Your Orders')</h2>
                <hr>

                <div class="content-panel">

                    <div class="col-md-12 panel-heading">
                        <div class="col-md-1 device-none">
                            <h4> </h4>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <h4> @lang('Order No.')  </h4>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <h4> @lang('Products') </h4>
                        </div>
                        <div class="col-md-2 col-xs-6 device-none">
                            <h4> @lang('Payment Status') </h4>
                        </div>
                          <div class="col-md-2 device-none">
                            <h4>@lang('Total') </h4>
                        </div>
                        <div class="col-md-2 device-none">
                            <h4> @lang('Order Date') </h4>
                        </div>
                        <div class="col-md-1 col-xs-2 ">
                        </div>
                    </div>

                    @foreach($orders as $key => $order)
                    <div class="col-md-12 panel-body">
                        <div class="panel-body-row">
                            <div class="col-md-1 device-none">
                                <h4> {{$key+1}} </h4>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <h4>
                                    <a class="" onclick="myFunction(this)" class="btn-toggle-close" data-toggle="collapse" href="#multiCollapseExample{{$key+1}}" aria-expanded="false" aria-controls="multiCollapseExample{{$key+1}}">
                                        #{{$order->getOrderId()}}
                                    </a>
                                </h4>
                            </div>

                            <div class="col-md-2 col-xs-6">
                                <a target="_blank" href="{{route('front.product.show', [$order->products->first()->slug])}}">
                                    <div class="img-box">
                                        <img src="{{ $order->products->first()->photo ? route('imagecache', ['tiny', $order->products->first()->photo->getOriginal('name')]) : ''}}" class="product-img">
                                    </div>
                                    <p class="text-center order_detail_item_name"> {{ $order->products->first()->name }} </p>
                                </a>
                            </div>
                            
                            <div class="col-md-2 col-xs-6 device-none">
                                <h4>
                                    @if($order->payment_method != 'Cash on Delivery' && $order->paid == 0)
                                        <strong class="text-warning">@lang('Failed')</strong>
                                    @else
                                        @if($order->paid)
                                            <strong class="text-success">@lang('Paid')</strong>
                                        @else
                                            <strong class="text-danger">@lang('Unpaid')</strong>
                                        @endif
                                    @endif
                                </h4>
                            </div>
                             <div class="col-md-2 device-none">
                                <h4> {{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}} </h4>
                            </div>
                            <div class="col-md-2 device-none">
                                <h4> {{$order->created_at->toFormattedDateString()}} </h4>
                            </div>
                            

                            <div class="col-md-1 col-xs-2 btn-toggle-close">
                    
                                <a class="" onclick="myFunction(this)" class="btn-toggle-close" data-toggle="collapse" href="#multiCollapseExample{{$key+1}}" aria-expanded="false" aria-controls="multiCollapseExample{{$key+1}}">
                                  <div class="bar1"></div>
                                  <div class="bar2"></div>
                                  <div class="bar3"></div>
                                </a>
                                @if($order->payment_method != 'Cash on Delivery' && $order->paid == 0)
                                {!! Form::model($order, ['method'=>'patch', 'action'=>['FrontOrdersController@hide', $order->id], 'id'=> 'hide-form-'.$order->id, 'style'=>'display: none;']) !!}
                                {!! Form::close() !!}
                                <a href="" class='btn btn-xs btn-danger pull-left'
                                    onclick="
                                            if(confirm('{{__('Are you sure you want to delete this?')}}')) {
                                            event.preventDefault();
                                            $('#hide-form-{{$order->id}}').submit();
                                            } else {
                                            event.preventDefault();
                                            }
                                            "
                                    ><i class="fa fa-trash"> </i></a>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix "> </div>

                        <div class="col-md-12 multi-collapse collapse" id="multiCollapseExample{{$key+1}}" aria-expanded="false" style="height: 0px;">
                            <div class="orders-details">
                                <div class="orders-details-inner">
                                    <h3> <strong> @lang('Order') #{{$order->getOrderId()}} </strong></h3>
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
                                    @foreach($order->products as $product)
                                    <div class="orders-details-inner-sub-2">
                                        <div class="media text-right">
                                            <a href="{{route('front.product.show', [$product->slug])}}"><div class="img-box"><img class="img-responsive product-img" src="{{ $product->photo ? route('imagecache', ['medium', $product->photo->getOriginal('name')]) : ''}}"></div></a>
                                            <div class="media-body">
                                                <div class="col-md-8">
                                                    <h4> <a target="_blank" href="{{route('front.product.show', [$product->slug])}}">{{$product->name}}</a> </h4>
                                                    <p><strong>@lang('Qty:') </strong>{{$product->pivot->quantity}}</p>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <h4> {{currency_format($product->pivot->total, $order->currency)}} </h4>
                                                    @if($product->file)
                                                    <div>
                                                        {!! Form::open(['method'=>'post', 'action'=>'FrontOrdersController@download']) !!}
                                                            {{ Form::hidden('filename', $product->file->filename) }}
                                                            {{ Form::hidden('order_id', $order->id) }}
                                                            {!! Form::submit($product->file->original_filename, ['class'=>'btn btn-link', 'role'=>'link']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <hr>
                                    @endforeach

                                </div>
                                <div class="clearfix"> </div>

                                 <div class="col-md-4 grand-total">
                                    <p> <strong>@lang('Payment Status:')</strong>
                                        @if($order->payment_method != 'Cash on Delivery' && $order->paid == 0)
                                            <strong class="text-warning">@lang('Failed')</strong>
                                        @else
                                            @if($order->paid)
                                                <strong class="text-success">@lang('Paid')</strong>
                                            @else
                                                <strong class="text-danger">@lang('Unpaid')</strong>
                                            @endif
                                        @endif
                                    </p>
                                    <hr>
                                   @if($order->payment_date)
                                   <p> <strong>@lang('Payment Date:')</strong> {{$order->payment_date}} </p>
                                   @endif
                                    <p> <strong>@lang('Payment Method:')</strong> {{$order->payment_method}} </p>
                                    <p> <strong>@lang('Order Status:')</strong>
                                        <strong>
                                        @if($order->is_processed)
                                            <span class="text-success">@lang('Delivered')</span>
                                        @else
                                            @if($order->stock_regained)
                                                <span class="text-primary">@lang('Cancelled')</span>
                                            @elseif($order->payment_method != 'Cash on Delivery' && $order->paid == 0)
                                                <strong class="text-warning">@lang('Failed')</strong>
                                            @else
                                                <strong class="text-danger">@lang('Pending')</strong>
                                            @endif
                                        @endif
                                        </strong>
                                    </p>
                                    @if(!($order->is_processed || $order->stock_regained || ($order->payment_method != 'Cash on Delivery' && $order->paid == 0)))
                                       <p> <strong>@lang('Current Status:')</strong> {{$order->status}} </p>
                                    @endif
                                    @if($order->is_processed == 1)
                                        <p> <strong>@lang('Delivered on:')</strong> {{$order->processed_date}} </p>
                                       <strong><a target="_blank" href="{{route('front.orders.show', ['id'=>$order->id])}}">@lang('View Invoice')</a></strong>
                                    @endif
                                   <hr>
                                </div>

                                 <div class="grand-total shipping-address col-md-4 text-center">
                                    <p><strong>@lang('Shipping Address')</strong></p>
                                    <hr>
                                    <div class="text-center">
                                        <p> <strong>{{$order->address->first_name}} {{$order->address->last_name}}</strong></p>
                                        <p> {{$order->address->address}}<br>
                                            {{$order->address->city}}, {{$order->address->state}} - {{$order->address->zip}}<br>
                                            {{$order->address->country}}.<br>
                                        </p>
                                        <hr>
                                    </div>
                                 </div>

                                <div class="col-md-4 grand-total">
                                    <div class="pull-right">
                                        <p><strong>@lang('Order Total')</strong></p>
                                        <hr>
                                        <p> <strong>@lang('Sub Total:')</strong> {{currency_format($order->total, $order->currency)}} </p>
                                        <p> <strong>@lang('Tax:')</strong> {{$order->tax}} % </p>
                                        <p> <strong>@lang('Shipping Cost:')</strong> {{isset($order->shipping_cost) ? currency_format($order->shipping_cost, $order->currency) : currency_format(0, $order->currency)}} </p>
                                        @if($order->coupon_amount && $order->coupon_amount > 0)
                                        <p> <strong>@lang('Coupon Discount:')</strong> {{ currency_format($order->coupon_amount, $order->currency) }} </p>
                                        @endif
                                        @if($order->wallet_amount && $order->wallet_amount > 0)
                                            <p> <strong>@lang('Wallet Used:')</strong> {{ currency_format($order->wallet_amount, $order->currency) }} </p>
                                        @endif
                                        <p> <strong>@lang('Order Total:')</strong> {{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}} </p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="clearfix"> </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
@endsection
