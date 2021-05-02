@if(Cart::count() > 0)
    @foreach(Cart::content() as $cartItem)
        <a class="menu-button menu-item-cart" target="_blank" href="{{route('front.product.show', [$cartItem->options->slug])}}">
                            <span class="item">
                                <span class="item-left">
                                    @if($cartItem->options->has('photo'))
                                        @if($cartItem->options->photo)
                                            @php
                                                $image_url = \App\Helpers\Helper::check_image_avatar($cartItem->options->photo, 80);
                                            @endphp
                                            <div class="cart-image">
                                                <img class="img-responsive" src="{{$image_url}}" alt="{{$cartItem->name}}"  />
                                            </div>
                                        @else
                                            <div class="cart-image">
                                                <img src="https://via.placeholder.com/80x80?text=No+Image" class="img-responsive" alt="{{$cartItem->name}}" />
                                            </div>
                                        @endif
                                    @endif
                                    <span class="item-info text-left">
                                        <span><strong class="custom_info_strg">{{$cartItem->name}}</strong></span>
                                        <div><span class="text-muted">Price : {{currency_format($cartItem->options->unit_price)}}</span></div>
                                    </span>
                                </span>
                                <span class="item-right pull-right">
                                    {!! Form::open(['method'=>'delete', 'route'=>['front.cart.destroy', $cartItem->rowId], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "X"; return true;']) !!}
                                    {!! Form::submit('X', ['class'=>'btn btn-square btn-xs btn-danger', 'name'=>'submit_button']) !!}
                                    {!! Form::close() !!}
                                </span>
                            </span>
        </a>
    @endforeach
    <div class="btn-cart-drop">
        <a class="btn-cart-check" href="{{url('/cart')}}">@lang('View Cart')</a>
        <a class="btn-cart-check" href="{{url('/checkout/shipping-details')}}">@lang('Checkout')</a>
    </div>

@else
    <a class="text-center menu-button" href="{{url('/cart')}}">@lang('The cart is empty.')</a>
@endif