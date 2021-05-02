@if(isset($payment_page) && $payment_page)
    @php $payment_page = true; @endphp
@else
    @php $payment_page = false; @endphp
@endif
<div class="table-responsive">
    <table class="table">
        <thead>
            @if(!$payment_page)
                <tr>
                <td colspan="7" class="imp-p-0">
                    <div>
                        <span>
                             <a href="#" class="btn btn-upper btn-danger pull-right outer-right-xs"
                                onclick="this.disabled = true; this.innerText ='Please Wait...'; window.location.href = '<?=url('/')?>/cart/empty'; return true;">
                                 <i class="fa fa-trash"></i> @lang('Empty Cart')
                             </a>
                        </span>
                    </div><!-- /.shopping-cart-btn -->
                </td>

            </tr>
            @endif
            <tr>
                @if(!$payment_page)
                    <th class="cart-remove item">@lang('Remove')</th>
                @endif
                <th class="cart-description item">@lang('Image')</th>
                <th class="cart-product-name item">@lang('Product Name')</th>
                <th class="cart-qty item">@lang('Quantity')</th>
                <th class="cart-sub-total item">@lang('Unit Price')</th>
                <th class="cart-unit-tax item">@lang('Unit Tax (%)')</th>
                <th class="cart-total last-item">@lang('Total')</th>
            </tr>
        </thead><!-- /thead -->
        <tbody>
            @foreach($cartItems as $product)
                @php $product_data = \App\Product::select('file_id','virtual','downloadable')->where('id',$product->id)->get()->first()->toArray(); @endphp
                <tr>
                    @if(!$payment_page)
                        <td class="remove-item">
                            {!! Form::open(['method'=>'delete', 'route'=>['front.cart.destroy', $product->rowId], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "X"; return true;']) !!}
                                <button type="submit" name="submit_button" title="cancel" class="icon">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    @endif
                    <td class="cart-image">
                        @if($product->options->has('photo'))
                            @if($product->options->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($product->options->photo, 75);
                                @endphp
                                <div class="img-box">
                                    <img class="product-image" width="75"  src="{{$image_url}}" alt="{{$product->name}}"  />
                                </div>
                            @else
                                <div class="img-box">
                                    <img src="https://via.placeholder.com/75x75?text=No+Image" class="product-image" width="75"  alt="{{$product->name}}" />
                                </div>
                            @endif
                        @endif
                    </td>
                    <td class="cart-product-name-info">
                        <h4 class='cart-product-description'>
                            <a href="{{route('front.product.show', [$product->options->slug])}}">{{$product->name}}</a>
                        </h4>
                        @if(is_array($product->options->spec) && count($product->options->spec))
                            <div class="cart-product-info">
                                @foreach($product->options->spec as $key => $spec)
                                    <span class="product-color">
                                        {{$spec['name']}} : <span> {{$spec['value']}} </span>
                                    </span>
                                    @if(!$loop->last)<br> @endif
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="cart-product-quantity">
                        <div class="quant-input">
                            @if($payment_page)
                                @if($product_data['virtual'] && $product_data['downloadable'] && $product_data['file_id'])
                                    <label class="form-control text-center"><strong>1</strong></label>
                                @else
                                    <label class="form-control text-center"><strong>{{$product->qty}}</strong></label>
                                @endif
                            @else
                                {!! Form::open(['method'=>'patch', 'route'=>['front.cart.update', $product->rowId, $product->qty], 'onsubmit'=>'this.disabled = true; return true;']) !!}
                                <div class="col-md-12">
                                    @if($product_data['virtual'] && $product_data['downloadable'] && $product_data['file_id'])
                                        <label class="form-control">
                                            <strong>1</strong>
                                        </label>
                                    @else
                                        <span class="input-group-btn">
                                            <button type="submit" {{$product->qty == 1 ? 'disabled' : ''}} class="btn btn-danger" value="decrease" name="submit">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                            <span>
                                                <input disabled type="number" value="{{$product->qty}}" class="form-control text-center" step="1" min="0">
                                            </span>

                                            <button type="submit" class="btn btn-success" value="increase" name="submit">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    @endif

                                </div>
                                {!! Form::close() !!}
                            @endif

                        </div>
                    </td>
                    <td class="cart-product-sub-total">
                        <span class="cart-sub-total-price">{{currency_format($product->options->unit_price)}}</span>
                    </td>
                    <td class="cart-product-unit-tax">
                        <span class="cart-sub-unit-tax">{{currency_format($product->options->unit_tax)}}%</span>
                    </td>
                    <td class="cart-product-grand-total">
                        <span class="cart-grand-total-price">{{currency_format($product->total)}}</span>
                    </td>
                </tr>
            @endforeach
        </tbody><!-- /tbody -->

    </table><!-- /table -->
</div>
