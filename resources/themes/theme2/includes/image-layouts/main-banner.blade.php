<!-- ========================================== SECTION – HERO ========================================= -->
<div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @foreach($banners_main_slider as $banner)
            @if($banner->photo)
                @php
                    $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 1500, '', 500);
                @endphp
            @else
                @php
                    $image_url = "https://via.placeholder.com/1500x1500?text=No+Image";
                @endphp
            @endif
            <div class="item" style="background-image: url('{{$image_url}}')">
                <div class="container-fluid">
                    <div class="caption bg-color vertical-center text-left">
                        <div class="slider-header fadeInDown-1">Top Brands</div>
                        <div class="big-text fadeInDown-1">{{$banner->title ? $banner->title : __('Banner')}} </div>
                        <div class="excerpt fadeInDown-2 hidden-xs"> <span>{{$banner->description ? $banner->description : __('Banner Description')}}</span> </div>
                        <div class="button-holder fadeInDown-3">
                            <a href="{{$banner->link ? $banner->link : url()->current()}}" class="btn-lg btn btn-uppercase btn-primary shop-now-button">@lang('Shop Now')</a>
                        </div>
                    </div>
                    <!-- /.caption -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.item -->
        @endforeach
    </div>
    <!-- /.owl-carousel -->
</div>
<!-- ========================================= SECTION – HERO : END ========================================= -->