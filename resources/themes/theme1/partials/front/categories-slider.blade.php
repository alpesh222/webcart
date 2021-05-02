<section class="well margin-60">
    <div class="large-12 titel-columns">
        <div class="col-sm-12"><h2><span class="title-slider">{{$titleSlider}}</span></h2></div>
    </div>
    <div class="clearfix"></div>
    <div class="swiper-container swiper-3">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
            <div class="swiper-slide">
                    <a href="{{route('front.category.show', [$category->slug])}}">
                    <div class="thumbnail custom_brand_css">
                        @if($category->photo)
                            @php
                                $image_url = \App\Helpers\Helper::check_image_avatar($category->photo->name,150);
                            @endphp
                            <img src="{{$image_url}}" alt="{{$category->name}}"  class="custom_brand_image_css" />
                        @else
                            <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$category->name}}"  class="custom_brand_image_css" />
                        @endif
                        <div class="text-center caption">
                            <h3>{{$category->name}}</h3>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>