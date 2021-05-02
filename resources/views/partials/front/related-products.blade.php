@if(($product->related_products()->where('is_active', 1)->count() > 0) || count($related_products_category_brand) > 0)
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-primary">Related Products:</h3><hr>
        </div>
    </div>
@endif

@if(($product->related_products()->where('is_active', 1)->count() > 0))
<div class="products">
    <div class="row" id="products-list">
        <ul class="rig columns-3">
            @foreach($product->related_products()->where('is_active', 1)->get() as $related_product)
                <li class="product-box text-center">
                    <a href="{{route('front.product.show', [$related_product->slug])}}">
                    @if($related_product->photo)
                    <img src="{{route('imagecache', ['large', $related_product->photo->getOriginal('name')])}}" alt="{{$related_product->name}}" />
                    @else
                    <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$related_product->name}}" />
                    @endif
                    </a>
                    <div class="caption">
                        <span class="product-name"><a href="{{route('front.product.show', [$related_product->slug])}}">{{$related_product->name}} </a></span>
                        <p>Price: 
                            @if($related_product->price_with_discount() < $related_product->price)
                            <strong>{{currency_format($related_product->price_with_discount())}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($related_product->price)}}</del>
                                <span class="text-success">{{round($related_product->discount_percentage())}}% @lang('off')</span>
                            </div>
                            @else
                            @if($related_product->old_price && ($related_product->price < $related_product->old_price))
                            <strong>{{currency_format($related_product->price)}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($related_product->old_price)}}</del>
                                <span class="text-success">{{round(100 * ($related_product->old_price - $related_product->price) / $related_product->old_price)}}% @lang('off')</span>
                            </div>
                            @else
                            <strong>{{currency_format($related_product->price)}}</strong>
                            @endif
                            @endif
                        </p>

                        @if($related_product->in_stock < 1)
                        <p><span class='text-danger'>@lang('Out of Stock!')</span></p>
                        @elseif($related_product->in_stock < 4)
                        <p><span class='text-danger'>@lang('Only') {{$related_product->in_stock}} @lang('left in Stock!')</span></p>
                        @endif

                        @if(count($related_product->reviews->where('approved', 1)) > 0)
                        <p><a target="_blank" href="{{route('front.product.show', [$related_product->slug])}}#reviews"><span class="label label-primary label-sm">{{$related_product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span><small>
                            {{count($related_product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($related_product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</small></a>
                        </p>
                        @endif
                        <div class="row">
                            {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $related_product->id], 'id'=>'cart-form']) !!}
                            <div class="form-group">
                                <div class="col-xs-6 btn-padding-cv">
                                    @if($related_product->in_stock > 0)
                                    {!! Form::submit(__('Add To Cart'), ['class'=>'btn btn-xs btn-success', 'name'=>'submit_button']) !!}
                                    @endif
                                </div>
                                <div class="col-xs-6 btn-padding-cv">
                                    <a href="{{route('front.product.show', [$related_product->slug])}}" class="btn btn-xs btn-primary" role="button">@lang('View Details')</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</ul>
@else
    @if(count($related_products_category_brand) > 0)
<div class="products">
    <div class="row" id="products-list">
        <ul class="rig columns-3">
            @foreach($related_products_category_brand as $related_product)
                <li class="product-box text-center">
                    <a href="{{route('front.product.show', [$related_product->slug])}}">
                    @if($related_product->photo)
                    <img src="{{route('imagecache', ['large', $related_product->photo->getOriginal('name')])}}" alt="{{$related_product->name}}" />
                    @else
                    <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$related_product->name}}" />
                    @endif
                    </a>
                    <div class="caption">
                        <span class="product-name"><a href="{{route('front.product.show', [$related_product->slug])}}">{{$related_product->name}} </a></span>
                        <p>@lang('Price:') 
                            @if($related_product->price_with_discount() < $related_product->price)
                            <strong>{{currency_format($related_product->price_with_discount())}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($related_product->price)}}</del>
                                <span class="text-success">{{round($related_product->discount_percentage())}}% @lang('off')</span>
                            </div>
                            @else
                            @if($related_product->old_price && ($related_product->price < $related_product->old_price))
                            <strong>{{currency_format($related_product->price)}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($related_product->old_price)}}</del>
                                <span class="text-success">{{round(100 * ($related_product->old_price - $related_product->price) / $related_product->old_price)}}% @lang('off')</span>
                            </div>
                            @else
                            <strong>{{currency_format($related_product->price)}}</strong>
                            @endif
                            @endif
                        </p>

                        @if($related_product->in_stock < 1)
                        <p><span class='text-danger'>@lang('Out of Stock!')</span></p>
                        @elseif($related_product->in_stock < 4)
                        <p><span class='text-danger'>@lang('Only') {{$related_product->in_stock}} @lang('left in Stock!')</span></p>
                        @endif

                        @if(count($related_product->reviews->where('approved', 1)) > 0)
                        <p><a target="_blank" href="{{route('front.product.show', [$related_product->slug])}}#reviews"><span class="label label-primary label-sm">{{$related_product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span><small>
                            {{count($related_product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($related_product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</small></a>
                        </p>
                        @endif
                        <div class="row">
                            {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $related_product->id], 'id'=>'cart-form']) !!}
                            <div class="form-group">
                                <div class="col-xs-6 btn-padding-cv">
                                    @if($related_product->in_stock > 0)
                                    {!! Form::submit(__('Add To Cart'), ['class'=>'btn btn-xs btn-success', 'name'=>'submit_button']) !!}
                                    @endif
                                </div>
                                <div class="col-xs-6 btn-padding-cv">
                                    <a href="{{route('front.product.show', [$related_product->slug])}}" class="btn btn-xs btn-primary" role="button">@lang('View Details')</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
    @endif
@endif