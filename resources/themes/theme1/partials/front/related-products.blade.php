@if(($product->related_products()->where('is_active', 1)->count() > 0) || count($related_products_category_brand) > 0)
   
<div class="clearfix">  </div>

	<div class=" related-products col-md-12">
		<h3 class="text-primary"> <span> @lang('Related Products:') </span></h3>
    </div>
@endif

@if(($product->related_products()->where('is_active', 1)->count() > 0))
<div class="products">
    <div class="" id="products-list">
        <ul class="rig columns-3">
            @foreach($product->related_products()->where('is_active', 1)->get() as $related_product)
                <li class="product-box text-center">
                    <a class="product_img" href="{{route('front.product.show', [$related_product->slug])}}">
                    @if($related_product->photo)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($related_product->photo->name, 150);
                        @endphp
                        <img src="{{$image_url}}" alt="{{$related_product->name}}"  />
                    @else
                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$related_product->name}}" />
                    @endif
                    </a>
				   <div class="caption custom_related_title">
                       <div class="title-caption">
    						<span class="product-name"><a href="{{route('front.product.show', [$related_product->slug])}}">{{$related_product->name}} </a></span>
                            <p>@lang('Price:') 
                                @if($related_product->price_with_discount() < $related_product->price)
                                <strong>{{currency_format($related_product->price_with_discount())}}</strong>
                                <div class="old_price">
                                    <del class="text-muted">{{currency_format($related_product->price)}}</del>
                                    <span class="text-success">{{round($related_product->discount_percentage())}}@lang('% off')</span>
                                </div>
                                @else
                                    @if($related_product->old_price && ($related_product->price < $related_product->old_price))
                                    <strong>{{currency_format($related_product->price)}}</strong>
                                    <div class="old_price">
                                        <del class="text-muted">{{currency_format($related_product->old_price)}}</del>
                                        <span class="text-success">{{round(100 * ($related_product->old_price - $related_product->price) / $related_product->old_price)}}@lang('% off')</span>
                                    </div>
                                    @else
                                    <strong>{{currency_format($related_product->price)}}</strong>
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
@else
    @if(count($related_products_category_brand) > 0)
<div class="products">
    <div class="" id="products-list">
        <ul class="rig columns-3">
            @foreach($related_products_category_brand as $related_product)
                <li class="product-box text-center">
                    <a class="product_img" href="{{route('front.product.show', [$related_product->slug])}}">
                    @if($related_product->photo)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($related_product->photo->name, 150);
                        @endphp
                        <img src="{{$image_url}}" alt="{{$related_product->name}}"  />
                    @else
                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$related_product->name}}" />
                    @endif
                    </a>
					<div class="caption custom_related_title">
        				<div class="title-caption">
        					 <span class="product-name"><a href="{{route('front.product.show', [$related_product->slug])}}">{{$related_product->name}} </a></span>
                            <p>@lang('Price:') 
                                @if($related_product->price_with_discount() < $related_product->price)
                                <strong>{{currency_format($related_product->price_with_discount())}}</strong>
                                <div class="old_price">
                                    <del class="text-muted">{{currency_format($related_product->price)}}</del>
                                    <span class="text-success">{{round($related_product->discount_percentage())}}@lang('% off')</span>
                                </div>
                                @else
                                    @if($related_product->old_price && ($related_product->price < $related_product->old_price))
                                    <strong>{{currency_format($related_product->price)}}</strong>
                                    <div class="old_price">
                                        <del class="text-muted">{{currency_format($related_product->old_price)}}</del>
                                        <span class="text-success">{{round(100 * ($related_product->old_price - $related_product->price) / $related_product->old_price)}}@lang('% off')</span>
                                    </div>
                                    @else
                                    <strong>{{currency_format($related_product->price)}}</strong>
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
    @endif
@endif
