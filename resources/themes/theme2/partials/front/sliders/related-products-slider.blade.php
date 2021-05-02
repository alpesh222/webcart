
<!-- ============================================== RELATED PRODUCTS ============================================== -->
@if(($product->related_products()->where('is_active', 1)->count() > 0) || count($related_products_category_brand) > 0)
    <section class="section featured-product wow fadeInUp">
        <div class="custom_product_slider">
            <h3 class="section-title">@lang('Related Products:')</h3>
            <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
                @if(($product->related_products()->where('is_active', 1)->count() > 0))
                    @foreach($product->related_products()->where('is_active', 1)->get() as $product)
                        <div class="item item-carousel">
                            <div class="products">
                                <div class="product">
                                @include('includes.products.product-image-tag-section')
                                <!-- /.product-image -->
                                @include('includes.products.product-info-price-section')
                                <!-- /.product-info -->
                                @include('includes.animated-cart-wishlist-btn')
                                <!-- /.cart -->
                                </div><!-- /.product -->
                            </div><!-- /.products -->
                        </div><!-- /.item -->
                    @endforeach
                @else
                    @if(count($related_products_category_brand) > 0)
                        @foreach($related_products_category_brand as $product)
                            <div class="item item-carousel">
                                <div class="products">
                                    <div class="product">
                                    @include('includes.products.product-image-tag-section')
                                    <!-- /.product-image -->
                                    @include('includes.products.product-info-price-section')
                                    <!-- /.product-info -->
                                    @include('includes.animated-cart-wishlist-btn')
                                    <!-- /.cart -->
                                    </div><!-- /.product -->
                                </div><!-- /.products -->
                            </div><!-- /.item -->
                        @endforeach
                    @endif
                @endif

            </div><!-- /.home-owl-carousel -->
        </div>
    </section><!-- /.section -->
@endif
<!-- ============================================== RELATED PRODUCTS : END ============================================== -->