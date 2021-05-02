@php $wishlist_page = false; @endphp
@if(isset($page))
    @if($page === 'wishlist')
        @php $wishlist_page = true; @endphp
    @endif
@endif
<div class="tab-pane active " id="grid-container">
    <div class="category-product">
        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 wow fadeInUp custom_product_div">
                    <div class="products">
                        <div class="product">
                            @include('includes.products.product-image-tag-section')
                            <!-- /.product-image -->
                            @if($wishlist_page)
                                <p class="text-muted"> ( @lang('Added') {{ $product->pivot->created_at->diffforHumans() }} )</p>
                            @endif
                            @include('includes.products.product-info-price-section')
                            <!-- /.product-info -->

                            @include('includes.animated-cart-wishlist-btn',['wishlist_page',$wishlist_page])
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->
                    </div>
                    <!-- /.products -->
                </div>
                <!-- /.item -->
            @endforeach
        <!-- /.item -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.category-product -->
</div>