<section class="well margin-60">
    <div class="large-12 titel-columns">
        <div class="col-sm-12"><h2> <span> <a class="title-slider" href="{{route('front.products', ['discount'=>'true'])}}" data-toggle="tooltip" title="View all {{$titleSlider}}">{{$titleSlider}}</a> </span> </h2></div>
    </div>
    <div class="clearfix"></div>
        <div class="swiper-container swiper-2">
            <div class="swiper-wrapper">
                @foreach($productsDiscount as $product)
                <div class="swiper-slide thumbnail custom_slider_box">
                    <a href="{{route('front.product.show', [$product->slug])}}">
                        <img src="@if($product->photo) {{route('imagecache', ['normal', $product->photo->getOriginal('name')])}} @else https://via.placeholder.com/150x150?text=No+Image @endif" alt="{{$product->name}}">
                    </a>
                    <div class="caption">
                        <a href="{{route('front.product.show', [$product->slug])}}"><h3>{{$product->name}}</h3></a>
                        <p>
                            @if($product->price_with_discount() < $product->price)
                            <strong>{{currency_format($product->price_with_discount())}}</strong>
                            <del class="text-muted">{{currency_format($product->price)}}</del>
                            <span class="text-success">{{round($product->discount_percentage())}}@lang('% off')</span>
                            @else
                            @if($product->old_price && ($product->price < $product->old_price))
                            <strong>{{currency_format($product->price)}}</strong>
                            <del class="text-muted">{{currency_format($product->old_price)}}</del>
                            <span class="text-success">{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}@lang('% off')</span>
                            @else
                            <strong>{{currency_format($product->price)}}</strong>
                            @endif
                            @endif
                            <br>
                            @if($product->in_stock < 1)
                                <span class='text-danger'>@lang('Out of Stock!')</span>
                            @elseif($product->in_stock < 4)
                                <span class='text-danger'>@lang('Only') {{$product->in_stock}} @lang('left in Stock!')</span>
                            @endif
                        </p>
                        <div class="sub-caption">
                        {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $product->id], 'id'=>'cart-form']) !!}
                            @if($product->in_stock > 0)
                           <button class="" name="submit_button" type="submit"> <i class="fa fa-shopping-cart "> </i> </button>
							@endif
                          <a href="{{route('front.product.show', [$product->slug])}}" class=""> <i class="fa fa-eye"> </i> </a>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
</section>