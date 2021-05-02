<div class="product-item-holder size-big single-product-gallery small-gallery">
    <div id="owl-single-product">
        @if($product->photo)
            @php
                $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 500);
            @endphp
            <div class="single-product-gallery-item" id="slide1">
                <a data-lightbox="image-1" data-title="Gallery" href="{{$image_url}}">
                    <img class="img-responsive" alt="{{$product->name}}" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="{{$image_url}}" />
                </a>
            </div><!-- /.single-product-gallery-item -->
        @else
            <div class="single-product-gallery-item" id="slide1">
                <a data-lightbox="image-1" data-title="Gallery" href="https://via.placeholder.com/500x500?text=No+Image">
                    <img class="img-responsive" alt="{{$product->name}}" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="https://via.placeholder.com/500x500?text=No+Image" />
                </a>
            </div><!-- /.single-product-gallery-item -->
        @endif

        @if(count($product->photos) > 0)
            @php $i = 2; @endphp
            @foreach($product->photos as $key=>$photo)
                @if($photo)
                    @php
                        $image_url = \App\Helpers\Helper::check_image_avatar($photo->name, 500);
                    @endphp
                    <div class="single-product-gallery-item" id="slide{{$i}}">
                        <a data-lightbox="image-1" data-title="Gallery" href="{{$image_url}}">
                            <img class="img-responsive" alt="{{$product->name}}" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="{{$image_url}}"  />
                        </a>
                    </div><!-- /.single-product-gallery-item -->
                @else
                    <div class="single-product-gallery-item" id="slide{{$i}}">
                        <a data-lightbox="image-1" data-title="Gallery" href="https://via.placeholder.com/80x80?text=No+Image">
                            <img class="img-responsive" alt="{{$product->name}}" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="https://via.placeholder.com/80x80?text=No+Image"  />
                        </a>
                    </div><!-- /.single-product-gallery-item -->
                @endif
                @php $i++; @endphp
            @endforeach
        @endif
    </div><!-- /.single-product-slider -->


    <div class="single-product-gallery-thumbs gallery-thumbs">
        <div id="owl-single-product-thumbnails">
            @if($product->photo)
                @php
                    $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 85);
                @endphp
                <div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
                        <img class="img-responsive" width="85" alt="" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="{{$image_url}}" />
                    </a>
                </div>
            @else
                <div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
                        <img class="img-responsive" width="85" alt="" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="https://via.placeholder.com/85x85?text=No+Image" />
                    </a>
                </div>
            @endif

            @if(count($product->photos) > 0)
                @php $i = 2; @endphp
                @foreach($product->photos as $key=>$photo)
                    @if($photo)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($photo->name, 65);
                        @endphp
                        <div class="item">
                            <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="{{$i}}" href="#slide{{$i}}">
                                <img class="img-responsive" width="85" alt="" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="{{$image_url}}"/>
                            </a>
                        </div>
                    @else
                        <div class="item">
                            <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="{{$i}}" href="#slide{{$i}}">
                                <img class="img-responsive" width="85" alt="" src="{{asset(theme_url('/img/blank.gif'))}}" data-echo="https://via.placeholder.com/65x65?text=No+Image"/>
                            </a>
                        </div>
                    @endif
                    @php $i++; @endphp
                @endforeach
            @endif
        </div><!-- /#owl-single-product-thumbnails -->

    </div><!-- /.gallery-thumbs -->

</div><!-- /.single-product-gallery -->