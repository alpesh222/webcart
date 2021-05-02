@extends('layouts.front')

@section('title')
    @lang('Shopping Cart') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('View your Shopping Cart')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Shopping Cart') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('View your Shopping Cart')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Shopping Cart')</li>
                </ul>
            </div>
        <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="shopping-cart">
        @if(Cart::count() > 0)
            <div class="shopping-cart-table ">
                @include('partials.front.cart-products-table')
            </div><!-- /.shopping-cart-table -->

            <div class="col-md-4 col-sm-12 estimate-ship-tax">
                <div class="shopping-cart-btn">
                    <span class="">
                        <a href="{{url('/')}}" class="btn btn-upper btn-primary outer-left-xs">@lang('Continue Shopping')</a>
                    </span>
                </div><!-- /.shopping-cart-btn -->
            </div><!-- /.estimate-ship-tax -->

            <div class="col-md-5 col-sm-12 col-md-offset-3 cart-shopping-total">
                <table class="table">
                    @include('partials.front.checkout.checkout-order-calculation')
                    <tbody>
                    <tr>
                        <td colspan="5">
                            <div class="cart-checkout-btn pull-right">
                                <button type="submit" onclick="window.location.href='{{route('checkout.shipping')}}'"
                                        class="btn btn-primary checkout-btn">@lang('PROCEED TO CHECKOUT')</button>
                            </div>
                        </td>
                    </tr>
                    </tbody><!-- /tbody -->
                </table><!-- /table -->
            </div><!-- /.cart-shopping-total -->
        @else
            <div class="row text-center">
                <div class="empty-bag">
                    <div class="empty-bag-icon">
                        <img src="{{asset('/img/icons/empty_bag.png')}}" class="img-responsive m-a" alt="@lang('Empty Cart')" width="200">
                    </div>
                    <h3 class="text-center text-muted">@lang('YOUR CART IS EMPTY')</h3>
                    <a href="{{url('/')}}" class="btn btn-primary">
                        <div class="continue-shopping-btn">@lang('Continue Shopping')</div>
                    </a>
                </div>
            </div>
        @endif

    </div><!-- /.shopping-cart -->
@endsection


@section('scripts')
@endsection