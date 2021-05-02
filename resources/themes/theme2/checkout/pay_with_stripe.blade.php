@extends('layouts.front')

@section('title')
    @lang('Pay with Stripe')
@endsection

@section('content')
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('Pay with Stripe')</div>

                <div class="panel-body text-center">
                    <form action="{!!route('stripe.payment')!!}" method="POST">
                        {{ csrf_field() }}
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ Config::get('stripe.stripe_key') }}"
                        data-amount="{{$amount}}"
                        data-name="@lang('Total')"
                        data-description="@lang('Order Value:') {{$amount / 100}} USD"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                        data-locale="auto">
                    </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
@endsection
