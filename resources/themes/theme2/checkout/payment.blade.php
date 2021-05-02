@extends('layouts.front')

@section('meta-tags')
    <meta name="description" content="@lang('Order Payment And Details')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Order Payment') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Order Payment And Details')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('title')
    @lang('Order Payment')
@endsection

@section('styles')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Order Payment')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="col-md-8 order_payment_products">
        <div class="panel-group checkout-steps">
            @include('partials.front.cart-products-table',['payment_page' => true])
            <div class="col-md-5 col-sm-12 col-md-offset-7 cart-shopping-total">
                <table class="table">
                    @include('partials.front.checkout.checkout-order-calculation',['payment_page' => true])
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 order_payment_sidebar">
        <!-- checkout-progress-sidebar -->
        <div class="checkout-progress-sidebar ">
            <div class="panel-group">
                {{-- Shipping Address Panel  --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="unicase-checkout-title">@lang('Shipping Details:')</h4>
                    </div>
                    <div class="custom_payment_ui">
                        <ul class="nav nav-checkout-progress list-unstyled">
                            <li><strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong></li>
                            <li>{{$customer->address}}</li>
                            <li>{{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}</li>
                            <li>{{$customer->country}}</li>
                            <li><strong>@lang('Phone :')</strong> {{$customer->phone}}</li>
                            <li><strong>@lang('Email :')</strong> {{$customer->email}}</li>
                            <li></li>
                            <li class="mt-10">
                                {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@changeShippingAddress',
                                'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                                <button type="submit" name="submit_button" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i> @lang('Change Address')
                                </button>
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Coupon Code Panel --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="unicase-checkout-title">@lang('Discount Coupon Code')</h4>
                    </div>
                    <div class="custom_payment_ui">
                        @if(session()->has('coupon_invalid'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{session('coupon_invalid')}}
                            </div>
                        @endif

                        <ul class="nav nav-checkout-progress list-unstyled">
                            @if(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                                @if(session()->has('coupon_code'))
                                    <li class="text-success">
                                        <strong>@lang('Coupon Applied:')</strong>
                                        <span class="text-muted">{{session('coupon_code')}}</span>
                                    </li>
                                    <li class="text-success">
                                        <strong>@lang('Discount:')</strong>
                                        <span class="text-muted">{{currency_format(session('coupon_amount'))}}</span>
                                    </li>
                                @else
                                    <li class="text-success">
                                        <strong>@lang('Coupon Discount:')</strong>
                                        <span class="text-muted">{{currency_format(session('coupon_amount'))}}</span>
                                    </li>
                                @endif
                                <li class="text-success">
                                    <strong>@lang('Change Coupon?')</strong>
                                </li>
                            @else
                                <li class="text-success">
                                    <strong id="have-coupon">@lang('Have a Coupon?')</strong>
                                </li>
                            @endif
                            <li>
                                <div class="coupon-box">
                                    {!! Form::open(['method'=>'post', 'action'=>'FrontCouponsController@checkCoupon', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;', 'class'=>'form-inline']) !!}
                                    <div class="form-group">
                                        {!! Form::text('coupon', null, ['class'=>'form-control', 'placeholder'=>__('Enter Coupon'), 'required']) !!}
                                    </div>
                                    {!! Form::submit(__('Apply'), ['id'=>'coupon-btn', 'class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Payments Method Panel --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="unicase-checkout-title">@lang('Select Your Payment Method')</h4>
                    </div>
                    <div class="custom_payment_ui">
                        <ul class="nav nav-checkout-progress list-unstyled">
                            {!! Form::open(['method'=>'post', 'action'=>'CheckoutController@processPayment', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                                @if(config('cod.enable') || config('banktransfer.enable') || config('paypal.enable') || config('stripe.enable') || config('razorpay.enable') || config('instamojo.enable')
                                        || config('paytm.enable') || config('payu.enable') || config('paystack.enable') )
                                    @if(config('cod.enable'))
                                        <li>
                                            <input id="cod" type="radio" name="options" value="cod" checked>
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'cod.png'])}}" alt="@lang('Cash on Delivery')" class="img-responsive" />
                                            @lang('Cash on Delivery')
                                        </li>
                                    @endif
                                    @if(config('banktransfer.enable'))
                                        <li>
                                            <input @if($errors->has('bank_transfer_reference_id')) checked @endif id="banktransfer" type="radio" name="options" value="banktransfer">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'banktransfer.png'])}}" alt="@lang('Bank Transfer')" class="img-responsive" />
                                            @lang('Bank Transfer')
                                        </li>
                                    @endif
                                    @if(config('paypal.enable'))
                                        <li>
                                            <input id="paypal" type="radio" name="options" value="paypal">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'paypal.png'])}}" alt="@lang('Paypal')" class="img-responsive" />
                                            @lang('Paypal')
                                        </li>
                                    @endif
                                    @if(config('paystack.enable'))
                                        <li>
                                            <input id="paystack" type="radio" name="options" value="paystack">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'paystack.png'])}}" alt="@lang('Paystack')" class="img-responsive" />
                                            @lang('Paystack')
                                        </li>
                                    @endif
                                    @if(config('paytm.enable'))
                                        <li>
                                            <input id="paytm" type="radio" name="options" value="paytm">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'paytm.png'])}}" alt="@lang('Paytm')" class="img-responsive" />
                                            @lang('Paytm')
                                        </li>
                                    @endif
                                    @if(config('pesapal.enable'))
                                        <li>
                                            <input id="pesapal" type="radio" name="options" value="pesapal">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'pesapal.png'])}}" alt="@lang('Pesapal')" class="img-responsive" />
                                            @lang('Pesapal')
                                        </li>
                                    @endif
                                    @if(config('stripe.enable'))
                                        <li>
                                            <input id="stripe" type="radio" name="options" value="stripe">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'stripe.png'])}}" alt="@lang('Stripe')" class="img-responsive" />
                                            @lang('Stripe')
                                        </li>
                                    @endif
                                    @if(config('razorpay.enable'))
                                        <li>
                                            <input id="razorpay" type="radio" name="options" value="razorpay">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'razorpay.png'])}}" alt="@lang('Razorpay')" class="img-responsive" />
                                            @lang('Razorpay')
                                        </li>
                                    @endif
                                    @if(config('instamojo.enable'))
                                        <li>
                                            <input id="instamojo" type="radio" name="options" value="instamojo">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')" class="img-responsive" />
                                            @lang('Instamojo')
                                        </li>
                                    @endif
                                    @if(config('payu.enable'))
                                         @if(config('payu.default') == 'payumoney')
                                            <input id="payumoney" type="radio" name="options" value="payumoney">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'payumoney.png'])}}" alt="@lang('PayUmoney')" class="img-responsive" />
                                            @lang('PayUmoney')
                                         @elseif(config('payu.default') == 'payubiz')
                                            <input id="payubiz" type="radio" name="options" value="payubiz">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'payubiz.png'])}}" alt="@lang('PayUbiz')" class="img-responsive" />
                                            @lang('PayUbiz')
                                         @endif
                                        <li>
                                            <input id="instamojo" type="radio" name="options" value="instamojo">
                                            <img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')" class="img-responsive" />
                                            @lang('Instamojo')
                                        </li>
                                    @endif
                                    <li class="banktransfer-fields">
                                        @lang('Make a payment of amount <strong>:amount</strong> to this bank account and provide transaction reference ID.',
                                         ['amount' => currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)])
                                        <ul>
                                            <li>
                                                <strong>@lang('Account Number'):</strong> {{config('banktransfer.account_number')}}
                                            </li>
                                            <li>
                                                <strong>{{config('banktransfer.branch_code_label')}}:</strong> {{config('banktransfer.branch_code')}}
                                            </li>
                                            <li>
                                                <strong>@lang('Name'):</strong> {{config('banktransfer.name')}}
                                            </li>

                                            <li>
                                                <strong>@lang('Transaction Reference ID')</strong>
                                            </li>
                                            <li>
                                                <input type="text" name="bank_transfer_reference_id"
                                                       class="form-control{{ $errors->has('bank_transfer_reference_id') ? ' has-error' : '' }}"
                                                       id="bank_transfer_reference_id">
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="text-right mt-30 cart-checkout-btn">
                                        <button id="payment_button" class="btn btn-primary" type="submit" name="submit_button">
                                            @lang('Place Order') <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </li>
                                @else
                                    <li><strong>@lang('No payment methods available.')</li>
                                @endif
                            {!! Form::close() !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- checkout-progress-sidebar -->
    </div>
@endsection

@section('scripts')
    <script>
        $('document').ready(function() {
            var couponBox = $('.coupon-box');
            $('#have-coupon').on('click', function(e) {
                e.preventDefault();
            });

            var banktransferFields = $('.banktransfer-fields');

            var option = $('input[type=radio][name=options]:checked').val();
            if('banktransfer' === option) {
                banktransferFields.show();
            }else{
                banktransferFields.hide();
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

        function updateWalletUse(){
            $('#cover-spin').show(0);
            refreshCartPage();
            setTimeout(function(){ $('#cover-spin').hide(0); }, 1000);
        }
    </script>
@endsection
