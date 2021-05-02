<!-- ============================================== BEST SELLER ============================================== -->
<div class="best-deal wow fadeInUp outer-bottom-xs">
    <h3 class="section-title">{{$titleSlider}}</h3>
    <div class="sidebar-widget-body outer-top-xs">
        <div class="owl-carousel best-seller custom-carousel owl-theme outer-top-xs">
            @php $products_array = $products->chunk(2); @endphp
            @foreach($products_array as $products_set)
                <div class="item">
                    <div class="products best-product">
                        @foreach($products_set as $product)
                            <div class="product best_selling_product">
                                <div class="product-micro">
                                    <div class="row product-micro-row">
                                        <div class="col col-xs-5">
                                            <div class="product-image">
                                                @include('includes.products.product-image-section')
                                                <!-- /.image -->
                                            </div>
                                            <!-- /.product-image -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col2 col-xs-7">
                                            @include('includes.products.product-info-price-section')
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.product-micro-row -->
                                </div>
                                <!-- /.product-micro -->
                            </div>
                         @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /.sidebar-widget-body -->
</div>
<!-- /.sidebar-widget -->
<!-- ============================================== BEST SELLER : END ============================================== -->