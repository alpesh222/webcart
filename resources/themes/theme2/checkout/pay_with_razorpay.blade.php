@extends('layouts.front')

@section('title')
    @lang('Pay with Razorpay')
@endsection

@section('styles')
    <style>
        .razorpay-payment-button {
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }
        .razorpay-payment-button:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('Purchase with Razorpay')</div>

                <div class="panel-body text-center">
                    <form action="{!!route('razorpay.payment')!!}" method="POST" >
                        {{ csrf_field() }}
                        <!-- Note that the amount is in paise = 50 INR -->
                        <!--amount need to be in paisa-->
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ Config::get('razorpay.razor_key') }}"
                                data-amount="{{$amount}}"
                                data-buttontext="Pay {{$amount / 100}} INR"
                                data-name="Total"
                                data-description="Order Value: {{$amount / 100}} INR"
                                data-image="{{url('/img/'.config('settings.site_logo'))}}"
                                data-prefill.name="{{Auth::user()->name}}"
                                data-prefill.email="{{Auth::user()->email}}"
                                data-theme.color="#ff7529">
                        </script>
                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
@endsection
