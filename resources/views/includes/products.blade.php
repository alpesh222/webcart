<div class="products">
    <div class="row">
        <div class="col-md-12 text-left">
        	<div class="text-muted showing-products-number">
            @lang('Showing') {{ $products->firstItem() }} - {{ $products->lastItem() }} @lang('products of') {{ $products->total() }} @lang('products')
            </div>
        </div>
    </div>
    <div class="cart-message">
        @include('partials.front.cart-message')
    </div>
    @if(count($products) > 0)
        @include('includes.form_errors')
        <div class="row" id="products-list">
			<ul class="rig columns-3">
				@foreach($products as $product)
				<li class="product-box text-center">
					<a href="{{route('front.product.show', [$product->slug])}}">
					@if($product->photo)
					<img src="{{route('imagecache', ['large', $product->photo->getOriginal('name')])}}" alt="{{$product->name}}" />
					@else
                    <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$product->name}}" />
					@endif
					</a>
                    <div class="caption">
                        <span class="product-name"><a href="{{route('front.product.show', [$product->slug])}}">{{$product->name}} </a></span>
                        <p>@lang('Price:') 
                            @if($product->price_with_discount() < $product->price)
                            <strong>{{currency_format($product->price_with_discount())}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($product->price)}}</del>
                                <span class="text-success">{{round($product->discount_percentage())}}% @lang('off')</span>
                            </div>
                            @else
                            @if($product->old_price && ($product->price < $product->old_price))
                            <strong>{{currency_format($product->price)}}</strong>
                            <div class="old_price">
                                <del class="text-muted">{{currency_format($product->old_price)}}</del>
                                <span class="text-success">{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}% @lang('off')</span>
                            </div>
                            @else
                            <strong>{{currency_format($product->price)}}</strong>
                            @endif
                            @endif
                        </p>

                        @if($product->in_stock < 1)
                        <p><span class='text-danger'>@lang('Out of Stock!')</span></p>
                        @elseif($product->in_stock < 4)
                        <p><span class='text-danger'>@lang('Only') {{$product->in_stock}} @lang('left in Stock!')</span></p>
                        @endif

                        @if(count($product->reviews->where('approved', 1)) > 0)
                        <p><a target="_blank" href="{{route('front.product.show', [$product->slug])}}#reviews"><span class="label label-primary label-sm">{{$product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span><small>
                            {{count($product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</small></a>
                        </p>
                        @endif
                        <div class="row">
                            {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $product->id], 'id'=>'cart-form']) !!}
                            <div class="form-group">
                                <div class="col-xs-6 btn-padding-cv">
                                    @if($product->in_stock > 0)
                                    {!! Form::submit(__('Add To Cart'), ['class'=>'btn btn-xs btn-success', 'name'=>'submit_button']) !!}
                                    @endif
                                </div>
                                <div class="col-xs-6 btn-padding-cv">
                                    <a href="{{route('front.product.show', [$product->slug])}}" class="btn btn-xs btn-primary" role="button">@lang('View Details')</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
				</li>
				@endforeach
			</ul>
        </div>
        <div class="row text-center">
	        <ul class="pagination">
	            {{$products->links('vendor.pagination.custom')}}
	        </ul>
        </div>
    @endif
</div>