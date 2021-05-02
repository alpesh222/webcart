<!-- ============================================== SCROLL TABS ============================================== -->
<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
    <div class="more-info-tab clearfix ">
        <h3 class="new-product-title pull-left">{{$titleSlider}}</h3>
{{--        <span class="pull-right custom_prod_slider_span">--}}
{{--            <a href="{{route('front.products')}}" data-toggle="tooltip" title="View all {{$titleSlider}}">--}}
{{--                @lang('View all') {{$titleSlider}}--}}
{{--            </a>--}}
{{--        </span>--}}
        <!-- /.nav-tabs -->
    </div>
    <div class="tab-content outer-top-xs">
        <div class="tab-pane in active" id="all">
            <div class="product-slider custom_product_slider">
                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                    @foreach($products as $product)
                        <div class="item item-carousel">
                            <div class="products">
                                <div class="product">
                                    @include('includes.products.product-image-tag-section')
                                    <!-- /.product-image -->
                                    @include('includes.products.product-info-price-section')

                                    <!-- /.product-info -->
                                    @include('includes.animated-cart-wishlist-btn')
                                    <!-- /.cart -->
                                </div>
                                <!-- /.product -->

                            </div>
                            <!-- /.products -->
                        </div>
                        <!-- /.item -->
                    @endforeach
                </div>
                <!-- /.home-owl-carousel -->
            </div>
            <!-- /.product-slider -->
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<!-- /.scroll-tabs -->
<!-- ============================================== SCROLL TABS : END ============================================== -->