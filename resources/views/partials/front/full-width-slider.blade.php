@if(config('settings.main_slider_enable'))
<div class="swiper-container home-slider">
    <div class="swiper-wrapper">
        @foreach($banners_main_slider as $banner)
        <div class="swiper-slide">
            <a href="{{$banner->link ? $banner->link : url()->current()}}">
                @if($banner->photo)
                    @php
                        $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 1500, '', 500);
                    @endphp
                    <img src="{{$image_url}}" alt="{{$banner->title ? $banner->title : __('Banner')}}"  class="banner-main-image" />
                @else
                    <img src="https://via.placeholder.com/1500x1500?text=No+Image" alt="{{$banner->title ? $banner->title : __('Banner')}}"  class="banner-main-image"  />
                @endif
            </a>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-next swiper-button-next-cont swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-prev-cont swiper-button-white"></div>
</div>
@endif