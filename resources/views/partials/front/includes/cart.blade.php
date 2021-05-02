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
    <h2 class="circle-icon-header"><span> <i class="fa fa-shopping-cart"></i> @lang('Shopping Cart')</span></h2>
    <div class="panel panel-primary">
        <table>
            <thead>
            <tr>
                <th scope="col">@lang('Product')</th>
                <th scope="col">@lang('Unit Price')</th>
                <th scope="col">@lang('Quantity')</th>
                <th scope="col">@lang('Unit Tax (%)')</th>
                <th scope="col">@lang('Total')</th>
                <th><button class="btn btn-danger" onclick="this.disabled = true; this.innerText ='Please Wait...'; window.location.href = '<?=url('/')?>/cart/empty'; return true;"><i class="fa fa-trash-o"></i> Empty Cart</button></th>
            </tr>
            </thead>
            <tbody>
            @foreach($cartItems as $cartItem)
                <?php $product_data = \App\Product::select('file_id','virtual','downloadable')->where('id',$cartItem->id)->get()->first()->toArray();?>
                <tr>
                    <td>
                        <a target="_blank" href="{{route('front.product.show', [$cartItem->options->slug])}}" class="thumbnail text-center">
                            @if($cartItem->options->has('photo'))
                                @if($cartItem->options->photo)
                                    @php
                                        $image_url = \App\Helpers\Helper::check_image_avatar($cartItem->options->photo, 150);
                                    @endphp
                                    <div class="img-box">
                                        <img class="product-image img-responsive" width="150"  src="{{$image_url}}" alt="{{$cartItem->name}}"  />
                                    </div>
                                @else
                                    <div class="img-box">
                                        <img src="https://via.placeholder.com/150x150?text=No+Image" class="product-image img-responsive" width="150"  alt="{{$cartItem->name}}" />
                                    </div>
                                @endif
                            @endif
                            <h5 class="custom_cart_h5"><strong>{{$cartItem->name}}</strong>
                                @if(is_array($cartItem->options->spec) && count($cartItem->options->spec))
                                    <br>
                                    @foreach($cartItem->options->spec as $key => $spec)
                                        <b>{{$spec['name']}}:</b> {{$spec['value']}}@if(!$loop->last)<br> @endif
                                    @endforeach
                                @endif
                            </h5>
                        </a>
                    </td>
                    <td data-label="@lang('Unit Price')">{{currency_format($cartItem->options->unit_price)}}</td>
                    <td data-label="@lang('Quantity')">
                        {!! Form::open(['method'=>'patch', 'route'=>['front.cart.update', $cartItem->rowId, $cartItem->qty], 'onsubmit'=>'this.disabled = true; return true;']) !!}
                        <div class="row">
                            <div class="input-group pull-right input-group-sm col-xs-6 col-sm-10 col-md-8">
                                @if($product_data['virtual'] && $product_data['downloadable'] && $product_data['file_id'])
                                    <label class="form-control">
                                        <strong>1</strong>
                                    </label>
                                @else
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
                                @endif

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </td>
                    <td data-label="@lang('Unit Tax (%)')">{{$cartItem->options->unit_tax}} %</td>
                    <td data-label="@lang('Total')">{{currency_format($cartItem->total)}}</td>
                    <td>
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
                <th class="ftr-cart-row" colspan="2"><span> @lang('Products') </span></th>
                <th class="ftr-cart-row" colspan="2"><span> {{Cart::count()}} </span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="ftr-cart-row" colspan="2"><span> @lang('Sub Total') </span></th>
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format(Cart::total())}} </span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="ftr-cart-row" colspan="2"><span> @lang('Tax') </span></th>
                <th class="ftr-cart-row" colspan="2"><span> + {{config('settings.tax_rate')}} % </span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="ftr-cart-row" colspan="2"><span> @lang('Shipping Cost') </span></th>
                @if(config('settings.shipping_cost_valid_below') > Cart::total())
                    <th class="ftr-cart-row" colspan="2"><span> {{currency_format(config('settings.shipping_cost'))}} </span></th>
                @else
                    <th class="ftr-cart-row" colspan="2"><span> {{currency_format(0)}} </span></th>
                @endif
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="ftr-cart-row" colspan="2"><span> @lang('Total') </span></th>
                @if(config('settings.shipping_cost_valid_below') > Cart::total())
                    <th class="ftr-cart-row" colspan="2"><span> {{currency_format(config('settings.shipping_cost') + Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
                @else
                    <th class="ftr-cart-row" colspan="2"><span> {{currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
                @endif
            </tr>
            </tfoot>
        </table>
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