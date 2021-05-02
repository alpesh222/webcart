@if(Cart::count() > 0)
    <li>
        <div class="cart-item product-summary">
            @foreach(Cart::content() as $cartItem)
                <div class="row mb-10">
                    <div class="col-xs-4">
                        <div class="image">
                            <a href="{{route('front.product.show', [$cartItem->options->slug])}}" target="_blank">
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
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <h3 class="name">
                            <a href="{{route('front.product.show', [$cartItem->options->slug])}}" target="_blank" >{{$cartItem->name}}</a>
                        </h3>
                        <div class="price">{{currency_format($cartItem->options->unit_price)}}</div>
                    </div>
                    <div class="col-xs-1 action">
                        {!! Form::open(['method'=>'delete', 'route'=>['front.cart.destroy', $cartItem->rowId], 'onsubmit'=>'submit_button.disabled = true; submit_button.value =  "'. __('<i class="fa fa-trash"></i>') . '"; return true;']) !!}
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'submit', 'class'=>'btn btn-xs cart_modal_trash_btn', 'name'=>'submit_button']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /.cart-item -->
        <div class="clearfix"></div>
        <hr>
        <div class="clearfix cart-total">
            <div class="pull-right">
                <span class="text"> @lang('Sub Total') :</span>
                <span class='price'>{{currency_format(Cart::total())}}</span>
            </div>
            <div class="clearfix"></div>
            <a href="{{url('/checkout/shipping-details')}}" class="btn btn-upper btn-primary btn-block m-t-20"> @lang('Checkout') </a> </div>
        <!-- /.cart-total-->
    </li>
@else
    <li>
        <div class="cart-item product-summary">
            <div class="row text-center">
                <a href="{{url('/cart')}}" class="text-center">
                    @lang('No Item Found In Cart')
                </a>
            </div>
        </div>
    </li>
@endif