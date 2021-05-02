<style>
    .alert a {
        color: #fff;
    }
</style>

<div class="col-md-12">
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
</div>

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