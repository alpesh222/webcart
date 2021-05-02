<div class="side-banner">
	@foreach($banners as $banner)
        <a href="{{$banner->link ? $banner->link : url()->current()}}">
            @if($banner->photo)
            <img class="img-banner img-responsive" src="{{route('imagecache', ['large', $banner->photo->getOriginal('name')])}}" alt="{{$banner->title ? $banner->title : __('Banner')}}"/>
            @endif
        </a><hr>
    @endforeach
</div>