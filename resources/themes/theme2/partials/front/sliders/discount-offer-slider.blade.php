<!-- ============================================== HOT DEALS ============================================== -->
<div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs">
    <h3 class="section-title">{{ $discounted_products->name }}</h3>
    <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">
        @foreach($discounted_products->products as $product)
        <div class="item">
            <div class="products">
                <div class="hot-deal-wrapper">
                    @include('includes.products.product-image-section')
                    <div class="sale-offer-tag"><span>{{ (int)$discounted_products->discount_amount }}%<br>
                    @lang('off')</span></div>
                    <div class="timing-wrapper">
                        @php
                            $expire_date = $discounted_products->expires_at;
                            $left_seconds = \Illuminate\Support\Carbon::now()->diffInSeconds($expire_date);
                        @endphp
                        <input type="hidden" class="deal_left_seconds" data-value="{{$product->id}}" value="{{$left_seconds}}">
                        <div class="box-wrapper">
                            <div class="date box"> <span class="key" id="deal_days_{{$product->id}}">00</span> <span class="value">@lang('DAYS')</span> </div>
                        </div>
                        <div class="box-wrapper">
                            <div class="hour box"> <span class="key" id="deal_hrs_{{$product->id}}">00</span> <span class="value">@lang('HRS')</span> </div>
                        </div>
                        <div class="box-wrapper">
                            <div class="minutes box"> <span class="key" id="deal_min_{{$product->id}}">00</span> <span class="value">@lang('MINS')</span> </div>
                        </div>
                        <div class="box-wrapper hidden-md">
                            <div class="seconds box"> <span class="key" id="deal_sec_{{$product->id}}">00</span> <span class="value">@lang('SEC')</span> </div>
                        </div>
                    </div>
                </div>
                <!-- /.hot-deal-wrapper -->
                @include('includes.products.product-info-price-section')
                <!-- /.product-info -->

                <div class="cart clearfix animate-effect">
                    <div class="action">
                        <div class="add-cart-button btn-group">
                            <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                <i class="fa fa-eye"></i>
                                <button class="btn btn-primary cart-btn" onclick="window.location.href = '{{route('front.product.show', [$product->slug])}}'" type="button"> @lang('View Details') </button>
                            </button>
                        </div>
                    </div>
                    <!-- /.action -->
                </div>
                <!-- /.cart -->
            </div>
        </div>
        @endforeach
    </div>
    <!-- /.sidebar-widget -->
</div>
<!-- ============================================== HOT DEALS: END ============================================== -->