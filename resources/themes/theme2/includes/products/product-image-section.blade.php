<div class="image">
    <a href="{{route('front.product.show', [$product->slug])}}">
        @if($product->photo)
            @php
                $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name,150);
            @endphp
            <img src="{{$image_url}}" class="img-responsive" alt="{{$product->name}}"/>
        @else
            <img src="https://via.placeholder.com/150x150?text=No+Image" class="img-responsive" alt="{{$product->name}}"/>
        @endif
    </a>
</div>