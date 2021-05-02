<div class="product-info text-left">
    <h3 class="name"><a href="{{route('front.product.show', [$product->slug])}}">{{$product->name}}</a></h3>
    @include('includes.products.product-rating-section')
    <div class="description"></div>
    <div class="product-price">
        @if($product->price_with_discount() < $product->price)
            <span class="price"> {{ currency_format($product->price_with_discount()) }} </span>
            <span class="price-before-discount">{{ currency_format($product->price) }} </span>
        @else
            @if($product->old_price && ($product->price < $product->old_price))
                <span class="price"> {{ currency_format($product->price) }} </span>
                <span class="price-before-discount">{{ currency_format($product->old_price) }} </span>
            @else
                <span class="price"> {{ currency_format($product->price) }} </span>
            @endif
        @endif
    </div>
    <!-- /.product-price -->
</div>