@if(session()->has('subscribed'))
    <div class="alert text-center alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
        <strong>&nbsp;@lang('Success!')</strong> {{session('subscribed')}}
    </div>
@endif

@if(session()->has('already_subscribed'))
    <div class="alert text-center alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
        &nbsp; {{session('already_subscribed')}}
    </div>
@endif

@if(session()->has('subscribe_failed'))
    <div class="alert text-center alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        &nbsp; {{session('subscribe_failed')}}
    </div>
@endif

@if(session()->has('success'))
    <div class="text-center alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
        &nbsp;{{ session('success') }}
    </div>
@endif

@if(session()->has('email_activation'))
    <div class="text-center alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('email_activation')}}
    </div>
@endif

@if(session()->has('payment_success'))
    <div class="text-center alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
        <strong>&nbsp;@lang('Success!')</strong> {{session('payment_success')}}
    </div>
@endif

@if(session()->has('payment_fail'))
    <div class="text-center alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>&nbsp;@lang('Error:')</strong> {{session('payment_fail')}}
    </div>
@endif

@include('includes.form_errors')
@if(session()->has('product_not_added'))
    <hr>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>&nbsp;@lang('Error:')</strong> {{session('product_not_added')}}
    </div>
@endif

@if(session()->has('product_added'))
    <br>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{session('product_added')}}
    </div>
    <a href="{{route('front.cart.index')}}">
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @lang('Click here to view your Shopping Cart')
        </div>
    </a>
    <hr>
@endif

@if(isset($cart_count))
    <div class="cart-count">
        {{$cart_count}}
    </div>
@endif

@if(isset($product_added))
    <div class="product-added">
        {{$product_added}}
    </div>
@endif