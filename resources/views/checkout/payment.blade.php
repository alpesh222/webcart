@extends('layouts.front')

@section('title')
    @lang('Payment')
@endsection

@section('styles')
    <style>
        table a:not(.btn), .table a:not(.btn) {
            text-decoration: none;
        }
        .cart-header {
            font-size: 1.1em;
        }
        .img-box img{
            height: 80px;
            width: auto!important;
        }
        .product-image{
            width:100%!important;
        }
        input#coupon-btn {
            margin-top: 6px;
        }
        @media screen and (max-width: 767px) {
            input#coupon-btn {
                margin-top: 0px;
            }
        }
    </style>
    <style>
        table {
          border: 1px solid #ccc;
          border-collapse: collapse;
          margin: 0;
          padding: 0;
          width: 100%;
          table-layout: fixed;
        }
        table caption {
          font-size: 1.5em;
          margin: .5em 0 .75em;
        }
        table tr {
          background: #fff;
          border: 1px solid #ddd;
          padding: .35em;
        }
        table th,
        table td {
          padding: .625em;
          text-align: center;
        }
        table th {
          font-size: .85em;
          letter-spacing: .1em;
          text-transform: uppercase;
        }
        @media screen and (max-width: 600px) {
          table {
            border: 0;
          }
          table caption {
            font-size: 1.3em;
          }
          table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
          }
          table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
          }
          table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
          }
          table td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
          }
          table td:last-child {
            border-bottom: 0;
          }
        }
        .payment-logo {
            width: 100px;
        }
    </style>
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="col-md-12">

            @include('includes.form_errors')

            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <strong><span class="cart-header">@lang('Order Summary') <i class="fa fa-shopping-cart"></i></span></strong>
                </div>
                <div class="panel-body">
                    <table>
                    <thead>
                        <tr>
                            <th scope="col">@lang('Product')</th>
                            <th scope="col">@lang('Unit Price')</th>
                            <th scope="col">@lang('Quantity')</th>
                            <th scope="col">@lang('Unit Tax (%)')</th>
                            <th scope="col">@lang('Total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $cartItem)
                        <tr>
                            <td data-label="">
                                <a target="_blank" href="{{route('front.product.show', [$cartItem->options->slug])}}" class="thumbnail text-center">
                                    @if($cartItem->options->has('photo'))
                                        @if($cartItem->options->photo)
                                            <div class="img-box">
                                                <img class="product-image" width="120" src="{{$cartItem->options->photo}}" alt="{{$cartItem->name}}">
                                            </div>
                                        @endif
                                    @endif
                                    <h5>{{$cartItem->name}}</h5>
                                </a>
                            </td>
                        <td data-label="@lang('Unit Price')">{{currency_format($cartItem->options->unit_price)}}</td>
                            <td data-label="@lang('Quantity')">
                                {{$cartItem->qty}}
                            </td>
                            <td data-label="@lang('Unit Tax (%)')">{{$cartItem->options->unit_tax}}</td>
                            <td data-label="@lang('Total')">{{currency_format($cartItem->total)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Products')</th>
                                <th></th>
                                <th>{{Cart::count()}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Sub Total')</th>
                                <th></th>
                                <th>{{currency_format(Cart::total())}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Tax')</th>
                                <th></th>
                                <th>+ {{config('settings.tax_rate')}} %</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Shipping Cost')</th>
                                <th></th>
                                @if(config('settings.shipping_cost_valid_below') > Cart::total())
                                <th>{{currency_format(config('settings.shipping_cost'))}}
                                @else
                                <th>{{currency_format(0)}}
                                @endif
                                </th>
                            </tr>
                            @if(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Coupon Amount')</th>
                                <th></th>
                                <th>- {{currency_format(session('coupon_amount'))}}
                                </th>
                            </tr>
                            @endif
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Total')</th>
                                <th></th>
                                @if(config('settings.shipping_cost_valid_below') > Cart::total() && session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
            <th>{{currency_format(config('settings.shipping_cost') + Cart::total() - session('coupon_amount') + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @elseif(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
            <th>{{currency_format(Cart::total() - session('coupon_amount') + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @elseif(config('settings.shipping_cost_valid_below') > Cart::total())
            <th>{{currency_format(config('settings.shipping_cost') + Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @else
                                <th>{{currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <h4>@lang('Shipping Details:')</h4>
                    <strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong>,<br>
                    {{$customer->address}}<br>
                    {{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}<br>
                    {{$customer->country}}.<br>
                    <strong>@lang('Phone:')</strong> {{$customer->phone}}<br>
                    <strong>@lang('Email:')</strong> {{$customer->email}}
                    <hr>
                    {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@changeShippingAddress', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                        <input class="btn btn-xs btn-primary" type="submit" name="submit_button" value="Change Address">
                    {!! Form::close() !!}
                    <br>
                    @if(session()->has('coupon_invalid'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{session('coupon_invalid')}}
                        </div>
                    @endif
                    @if(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                        @if(session()->has('coupon_code'))
                            <h5 class="text-success">@lang('Coupon Applied'): <span class="text-muted">{{session('coupon_code')}}</span></h5>
                            <h5 class="text-success">@lang('Discount'): <span class="text-muted">{{currency_format(session('coupon_amount'))}}</span></h5>
                        @else
                            <h4>@lang('Coupon Discount'): {{currency_format(session('coupon_amount'))}}</h4>
                        @endif
                        <a id="have-coupon" href="">@lang('Change Coupon?')</a>
                    @else
                        <a id="have-coupon" href="">@lang('Have a Coupon?')</a>
                    @endif
                    <div class="coupon-box">
                        {!! Form::open(['method'=>'post', 'action'=>'FrontCouponsController@checkCoupon', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;', 'class'=>'form-inline']) !!}
                            <div class="form-group">
                            {!! Form::text('coupon', null, ['class'=>'form-control', 'placeholder'=>__('Enter Coupon'), 'required']) !!}
                            </div>
                            {!! Form::submit('Apply', ['id'=>'coupon-btn', 'class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-sm-5 text-right">
                    <h3>@lang('Select Your Payment Method')</h3>
                    <hr>

                    {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@processPayment', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}

                        <div class="radio">
                            <label>
                                <input id="cod" type="radio" name="options" value="cod" checked>
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'cod.png'])}}" alt="@lang('Cash on Delivery')" class="img-responsive" />
                                @lang('Cash on Delivery')
                            </label>
                            <hr>
                            @if(config('paypal.enable'))
                            <label>
                                <input id="paypal" type="radio" name="options" value="paypal">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'paypal.png'])}}" alt="@lang('Paypal')" class="img-responsive" />
                                @lang('Paypal')
                            </label>
                            <hr>
                            @endif
                            @if(config('stripe.enable'))
                            <label>
                                <input id="stripe" type="radio" name="options" value="stripe">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'stripe.png'])}}" alt="@lang('Stripe')" class="img-responsive" />
                                @lang('Stripe')
                            </label>
                            <hr>
                            @endif
                            @if(config('razorpay.enable'))
                            <label>
                                <input id="razorpay" type="radio" name="options" value="razorpay">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'razorpay.png'])}}" alt="@lang('Razorpay')" class="img-responsive" />
                                @lang('Razorpay')
                            </label>
                            <hr>
                            @endif
                            @if(config('instamojo.enable'))
                            <label>
                                <input id="instamojo" type="radio" name="options" value="instamojo">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')" class="img-responsive" />
                                @lang('Instamojo')
                            </label>
                            <hr>
                            @endif
                            @if(config('payu.enable'))
                            @if(config('payu.default') == 'payumoney')
                            <label>
                                <input id="payumoney" type="radio" name="options" value="payumoney">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'payumoney.png'])}}" alt="@lang('PayUmoney')" class="img-responsive" />
                                @lang('PayUmoney')
                            </label>
                            <hr>
                            @elseif(config('payu.default') == 'payubiz')
                            <label>
                                <input id="payubiz" type="radio" name="options" value="payubiz">
                                <img class="payment-logo" src="{{route('imagecache', ['original', 'payubiz.png'])}}" alt="@lang('PayUbiz')" class="img-responsive" />
                                @lang('PayUbiz')
                            </label>
                            <hr>
                            @endif
                            @endif
                        </div>
                        <input id="payment_button" class="btn btn-success" type="submit" name="submit_button" value="Place Order">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('document').ready(function() {
            var couponBox = $('.coupon-box');
            couponBox.hide();
            $('#have-coupon').on('click', function(e) {
                e.preventDefault();
                couponBox.fadeIn();
            });
        });
    </script>
@endsection