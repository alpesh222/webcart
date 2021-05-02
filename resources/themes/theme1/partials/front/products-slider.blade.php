<section class="well margin-60">
    <div class="large-12 titel-columns">
        <div class="col-sm-12"><h2> <span> <a class="title-slider" href="{{route('front.products')}}" data-toggle="tooltip" title="View all {{$titleSlider}}">{{$titleSlider}}</a> </span> </h2></div>
    </div>
    <div class="clearfix"></div>
        <div class="swiper-container swiper-2">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div class="swiper-slide thumbnail custom_slider_box">
                        <span>
                                <a href="{{route('front.product.show', [$product->slug])}}" >
                                @if($product->photo)
                                    @php
                                        $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name,150);
                                    @endphp
                                    <img src="{{$image_url}}" alt="{{$product->name}}" />
                                @else
                                    <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$product->name}}" />
                                @endif
                        </a>
                        <div class="caption">
                            <ul class="rating custom_prod_rating">
                                @if(count($product->reviews) > 0)
                                    @if(count($product->reviews->where('approved', 1)->where('rating', '!=', null)) > 0)
                                        @if(count($product->reviews->where('approved', 1)) > 0)
                                            @php $product_review_count = $product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating') @endphp
                                            @for($i = 0 ; $i < 5 ; $i++)
                                                @if($i >= $product_review_count)
                                                    <li class="text-primary glyphicon glyphicon-star-empty"></li>
                                                @else
                                                    <li class="text-primary glyphicon glyphicon-star"></li>
                                                @endif
                                            @endfor
                                        @endif
                                    @endif
                                @else
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                @endif

                            </ul>
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
                            </p>
                        </div>
                    </span>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
</section>
