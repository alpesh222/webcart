<!-- ============================================== SPECIAL DEALS ============================================== -->
<div class="sidebar-widget outer-bottom-small wow fadeInUp">
    <h3 class="section-title">
        <a href="{{route('front.deal.show', $dealSlug)}}" data-toggle="tooltip" title="View all {{$titleSlider}}">
            {{$titleSlider}}
        </a>
    </h3>
    <div class="sidebar-widget-body outer-top-xs">
        <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">
            @php $products_array = $products->chunk(3); @endphp
            @foreach($products_array as $products_set)
                <div class="item">
                <div class="products special-product">
                    @foreach($products_set as $product)
                    <div class="product">
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
                                <div class="col col-xs-7">
                                    @include('includes.products.product-info-price-section')
                                    <!-- /.product-price -->
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
<!-- ============================================== SPECIAL DEALS : END ============================================== -->