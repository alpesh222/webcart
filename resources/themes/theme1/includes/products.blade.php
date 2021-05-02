<div class="products">
    <div class="col-md-12">
    @if(count($products) > 0)
        @include('includes.form_errors')
        <div class="row" id="products-list">
            <ul class="rig columns-3">
                @foreach($products as $product)

                <li class="product-box text-center">
                    <a href="{{route('front.product.show', [$product->slug])}}">
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
                        <div class="title-caption">
                            <ul class="rating custom_prod_rating">
                                @if(count($product->reviews) > 0)
                                    @if(count($product->reviews->where('approved', 1)->where('rating', '!=', null)) > 0)
                                        @if(count($product->reviews->where('approved', 1)) > 0)
                                            @php $product_review_count = $product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating') @endphp
                                            @for($i = 0 ; $i < 5 ; $i++)
                                                @if($i >= $product_review_count)
                                                    <span class="text-primary glyphicon glyphicon-star-empty"></span>
                                                @else
                                                    <span class="text-primary glyphicon glyphicon-star"></span>
                                                @endif

                                            @endfor
                                        @endif
                                    @endif
                                @else
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif

                            </ul>
                            <span class="product-name"><a href="{{route('front.product.show', [$product->slug])}}">{{$product->name}} </a></span>
                            <p>@lang('Price:')
                                @if($product->price_with_discount() < $product->price)
                                <strong>{{currency_format($product->price_with_discount())}}</strong>
                                <div class="old_price">
                                    <del class="text-muted">{{currency_format($product->price)}}</del>
                                    <span class="text-success">{{round($product->discount_percentage())}}@lang('% off')</span>
                                </div>
                                @else
                                @if($product->old_price && ($product->price < $product->old_price))
                                <strong>{{currency_format($product->price)}}</strong>
                                <div class="old_price">
                                    <del class="text-muted">{{currency_format($product->old_price)}}</del>
                                    <span class="text-success">{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}@lang('% off')</span>
                                </div>
                                @else
                                <strong>{{currency_format($product->price)}}</strong>
                                @endif
                                @endif
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        </div>
        <div class="row text-center">
            <ul class="pagination">
                {{$products->links('vendor.pagination.custom')}}
            </ul>
        </div>
    @endif
</div>