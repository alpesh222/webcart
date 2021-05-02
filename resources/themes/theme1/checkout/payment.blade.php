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
        @if(!$errors->has('bank_transfer_reference_id'))
        .banktransfer-fields {
            display: none;
        }
        @endif
        #bank_transfer_reference_id {
            margin-bottom: 5px;
        }
        .banktransfer-fields ul {
            list-style-type: none;
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
        @media (max-width:768px) {
            .cart-container table tr {
               display: table-row-group;
            }
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        	<ul class="breadcrumb">
        		<li><a href="{{url('/')}}">@lang('Home')</a></li>
        		<li>@lang('Checkout')</li>
        	</ul>
        </div>
    </div>
</div>
<div class="">
    <div class="col-md-12 cart-container">
        @include('includes.form_errors')
        <div class="custom_checkout col-md-offset-1 col-md-7">
            @include('partials.front.includes.checkout')
        </div>
        <div class="row shipping_details-p col-md-3">
            <div class="col-sm-12 custom_shipping_css">
                <h3>@lang('Shipping Details:')</h3>
                <strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong>,<br>
                {{$customer->address}}<br>
                {{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}<br>
                {{$customer->country}}.<br>
                <strong>@lang('Phone:')</strong> {{$customer->phone}}<br>
                <strong>@lang('Email:')</strong> {{$customer->email}}
                <hr>
                {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@changeShippingAddress', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                    <button type="submit" name="submit_button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> @lang('Change Address')</button>
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
                        <h5 class="text-success">@lang('Coupon Applied:') <span class="text-muted">{{session('coupon_code')}}</span></h5>
                        <h5 class="text-success">@lang('Discount:') <span class="text-muted">{{currency_format(session('coupon_amount'))}}</span></h5>
                    @else
                        <h4>@lang('Coupon Discount:') {{currency_format(session('coupon_amount'))}}</h4>
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
                        {!! Form::submit(__('Apply'), ['id'=>'coupon-btn', 'class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-sm-12 text-left">
                <h3>@lang('Select Your Payment Method')</h3>
                <hr>

                {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@processPayment', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}

                    @php
                    $payment_methods_count = 0;
                    @endphp
                    <div class="radio">
                        @if(config('cod.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="cod" type="radio" name="options" value="cod" checked>
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'cod.png'])}}" alt="@lang('Cash on Delivery')" class="img-responsive" />
                            @lang('Cash on Delivery')
                        </label>
                        <hr>
                        @endif
                        @if(config('banktransfer.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input @if($errors->has('bank_transfer_reference_id')) checked @endif id="banktransfer" type="radio" name="options" value="banktransfer">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'banktransfer.png'])}}" alt="@lang('Bank Transfer')" class="img-responsive" />
                            @lang('Bank Transfer')
                        </label>
                        <hr>
                        @endif
                        @if(config('paypal.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="paypal" type="radio" name="options" value="paypal">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'paypal.png'])}}" alt="@lang('Paypal')" class="img-responsive" />
                            @lang('Paypal')
                        </label>
                        <hr>
                        @endif

{{--                            Paystack Payment Gateway Starts--}}
                        @if(config('paystack.enable'))
                                @php
                                    $payment_methods_count++;
                                @endphp
                                <label>
                                    <input id="paystack" type="radio" name="options" value="paystack">
                                    <img class="payment-logo" src="{{route('imagecache', ['original', 'paystack.png'])}}" alt="@lang('Paystack')" class="img-responsive" />
                                    @lang('Paystack')
                                </label>
                                <hr>
                            @endif
{{--                            Paystack Payment Gateway Ends--}}

{{--                            Paytm Payment Gateway Starts --}}
                        @if(config('paytm.enable'))
                                @php
                                    $payment_methods_count++;
                                @endphp
                                <label>
                                    <input id="paytm" type="radio" name="options" value="paytm">
                                    <img class="payment-logo" src="{{route('imagecache', ['original', 'paytm.png'])}}" alt="@lang('Paytm')" class="img-responsive" />
                                    @lang('Paytm')
                        </label>
                        <hr>
                        @endif
{{--                            Paytm Payment Gateway Ends--}}
{{--                            Pesapal Payment Gateway Starts --}}
                        @if(config('pesapal.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="pesapal" type="radio" name="options" value="pesapal">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'pesapal.png'])}}" alt="@lang('Pesapal')" class="img-responsive" />
                            @lang('Pesapal')
                                </label>
                                <hr>
                            @endif
{{--                            Paytm Payment Gateway Ends--}}

                        @if(config('stripe.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="stripe" type="radio" name="options" value="stripe">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'stripe.png'])}}" alt="@lang('Stripe')" class="img-responsive" />
                            @lang('Stripe')
                        </label>
                        <hr>
                        @endif
                        @if(config('razorpay.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="razorpay" type="radio" name="options" value="razorpay">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'razorpay.png'])}}" alt="@lang('Razorpay')" class="img-responsive" />
                            @lang('Razorpay')
                        </label>
                        <hr>
                        @endif
                        @if(config('instamojo.enable'))
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="instamojo" type="radio" name="options" value="instamojo">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')" class="img-responsive" />
                            @lang('Instamojo')
                        </label>
                        <hr>
                        @endif
                        @if(config('payu.enable'))
                        @if(config('payu.default') == 'payumoney')
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="payumoney" type="radio" name="options" value="payumoney">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'payumoney.png'])}}" alt="@lang('PayUmoney')" class="img-responsive" />
                            @lang('PayUmoney')
                        </label>
                        <hr>
                        @elseif(config('payu.default') == 'payubiz')
                        @php
                        $payment_methods_count++;
                        @endphp
                        <label>
                            <input id="payubiz" type="radio" name="options" value="payubiz">
                            <img class="payment-logo" src="{{route('imagecache', ['original', 'payubiz.png'])}}" alt="@lang('PayUbiz')" class="img-responsive" />
                            @lang('PayUbiz')
                        </label>
                        <hr>
                        @endif
                        @endif
                    </div>
                    @if($payment_methods_count > 0)
                    <div class="banktransfer-fields">
                        <p class="banktransfer-make-payment-msg">
                            @lang('Make a payment of amount <strong>:amount</strong> to this bank account and provide transaction reference ID.', ['amount' => currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)])
                        </p>
                        <ul class="list-group list-group-flush">
                            <li>
                                <strong>@lang('Account Number'):</strong> {{config('banktransfer.account_number')}}
                            </li>
                            <li>
                                <strong>{{config('banktransfer.branch_code_label')}}:</strong> {{config('banktransfer.branch_code')}}
                            </li>
                            <li>
                                <strong>@lang('Name'):</strong> {{config('banktransfer.name')}}
                            </li>
                        </ul>

                        <div class="form-group">
                            <label for="bank_transfer_reference_id">
                                <strong>@lang('Transaction Reference ID')</strong>
                            </label><br>
                            <input type="text" name="bank_transfer_reference_id" class="form-control{{ $errors->has('bank_transfer_reference_id') ? ' has-error' : '' }}" id="bank_transfer_reference_id">
                        </div>
                    </div>
                    <button id="payment_button" class="btn btn-primary" type="submit" name="submit_button">@lang('Place Order') <i class="fa fa-shopping-cart"></i></button>
                    @else
                    <div class="text-danger">@lang('No payment methods available.')</div>
                    @endif
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
            // couponBox.hide();
            $('#have-coupon').on('click', function(e) {
                e.preventDefault();
                // couponBox.fadeIn();
            });

            var banktransferFields = $('.banktransfer-fields');

            var option = $('input[type=radio][name=options]:checked').val();
            if('banktransfer' === option) {
                banktransferFields.show();
            }

            $(document).on('change', 'input[type=radio][name=options]', function(e) {
                var option = this.value;
                if('banktransfer' === option) {
                    banktransferFields.fadeIn();
                } else {
                    banktransferFields.hide();
                }
            });
        });
    </script>
    <script>
        function updateWalletUse(){
            $('#cover-spin').show(0);
            refreshCartPage();
            setTimeout(function(){ $('#cover-spin').hide(0); }, 1000);
        }

    </script>
@endsection
