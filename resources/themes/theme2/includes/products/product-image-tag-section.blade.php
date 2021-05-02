<div class="product-image">
    @include('includes.products.product-image-section')
    <!-- /.image -->
    @if($product->price_with_discount() < $product->price)
        <div class="tag sale">
            <span>{{round($product->discount_percentage())}}% @lang('off')</span>
        </div>
    @else
        @if($product->old_price && ($product->price < $product->old_price))
            <div class="tag sale">
                <span>{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}% @lang('off')</span>
            </div>
        @endif
    @endif
</div>