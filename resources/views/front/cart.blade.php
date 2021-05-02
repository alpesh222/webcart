@extends('layouts.front')

@section('title')@lang('Shopping Cart') - {{config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('View your Shopping Cart')">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Shopping Cart - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('View your Shopping Cart')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('styles')
    <style>
        table a:not(.btn), .table a:not(.btn) {
            text-decoration: none;
        }
        .cart-header {
            font-size: 1.1em;
        }
        .btn-square {
            width: 24px;
            height: 24px;
        }
        @media(max-width: 991px) {
            .big-col {
                min-width:250px
            }
        }
        .img-box img{
            height: 80px;
            width: auto!important;
        }
        .product-image{
            width:100%!important;
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
		.input-group.pull-right.input-group-sm {
		    z-index: 0;
		}
        .cart-container {
            margin-bottom: 120px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('payment_fail'))
            toastr.error("{{session('payment_fail')}}");
        @endif
    </script>
@endsection

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12 cart-container">
            @if(session()->has('payment_fail'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <strong>&nbsp;@lang('Error:')</strong> {{session('payment_fail')}}
                </div>
            @endif
            @if(session()->has('product_not_added'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <strong>&nbsp;@lang('Error:')</strong> {{session('product_not_added')}}
                </div>
            @endif

            @if(Cart::count() > 0)
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <strong><span class="cart-header">@lang('Shopping Cart') <i class="fa fa-shopping-cart"></i></span></strong>
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
                            <th></th>
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
                                {!! Form::open(['method'=>'patch', 'route'=>['front.cart.update', $cartItem->rowId, $cartItem->qty], 'onsubmit'=>'this.disabled = true; return true;']) !!}
                                    <div class="row">

                                        <div class="input-group pull-right input-group-sm col-xs-6 col-sm-10 col-md-8">
                                            <span class="input-group-btn">
                                                <button type="submit" {{$cartItem->qty == 1 ? 'disabled' : ''}} class="btn btn-danger" value="decrease" name="submit">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input disabled type="number" value="{{$cartItem->qty}}" class="form-control" step="1" min="0">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-success" value="increase" name="submit">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>

                                    </div>
                                {!! Form::close() !!}
                            </td>
                            <td data-label="@lang('Unit Tax (%)')">{{$cartItem->options->unit_tax}}</td>
                            <td data-label="@lang('Total')">{{currency_format($cartItem->total)}}</td>
                            <td data-label="">
                                {!! Form::open(['method'=>'delete', 'route'=>['front.cart.destroy', $cartItem->rowId], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "X"; return true;']) !!}
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            {!! Form::submit('X', ['class'=>'btn btn-square btn-xs btn-danger', 'name'=>'submit_button']) !!}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Products')</th>
                                <th></th>
                                <th colspan="2">{{Cart::count()}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Sub Total')</th>
                                <th></th>
                                <th colspan="2">{{currency_format(Cart::total())}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Tax</th>
                                <th></th>
                                <th colspan="2">+ {{config('settings.tax_rate')}} %</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Shipping Cost')</th>
                                <th></th>
                                @if(config('settings.shipping_cost_valid_below') > Cart::total())
                                <th colspan="2">{{currency_format(config('settings.shipping_cost'))}}
                                @else
                                <th colspan="2">{{currency_format(0)}}
                                @endif
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>@lang('Total')</th>
                                <th></th>
                                @if(config('settings.shipping_cost_valid_below') > Cart::total())
            <th colspan="2">{{currency_format(config('settings.shipping_cost') + Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @else
                                <th colspan="2">{{currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <a href="{{url('/')}}" class="pull-left btn btn-primary">@lang('Continue Shopping')</a>
                    <a href="{{route('checkout.shipping')}}" class="btn btn-success">@lang('Checkout')</a>
                </div>
            </div>
            @else
				<br>
                <div class="jumbotron">
                    <h2 class="text-center text-muted">@lang('The cart is empty.')
                        <a href="{{url('/')}}" class="btn btn-primary">@lang('Go to Shop')</a>
                    </h2>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
