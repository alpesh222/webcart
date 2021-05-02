<!-- ============================================== BRANDS CAROUSEL ============================================== -->
<div id="brands-carousel" class="logo-slider wow fadeInUp">
    <div class="logo-slider-inner">
        <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
            @foreach($brands as $brand)
                <div class="item m-t-15">
                    <a href="{{route('front.brand.show', [$brand->slug])}}" class="image">
                        @if($brand->photo)
                            @php
                                $image_url = \App\Helpers\Helper::check_image_avatar($brand->photo->name, 150);
                            @endphp
                            <img class="img-responsive" data-echo="{{$image_url}}"  src="{{asset(theme_url('/img/blank.gif'))}}" alt="{{$brand->name ? $brand->name : __('Brand')}}"  />
                        @else
                            <img class="img-responsive" data-echo="https://via.placeholder.com/150x150?text=No+Image" src="{{asset(theme_url('/img/blank.gif'))}}" alt="{{$brand->name ? $brand->name : __('Brand')}}"   />
                        @endif
                    </a>
                </div>
                <!--/.item-->
            @endforeach
        </div>
        <!-- /.owl-carousel #logo-slider -->
    </div>
    <!-- /.logo-slider-inner -->

</div>
<!-- /.logo-slider -->
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->