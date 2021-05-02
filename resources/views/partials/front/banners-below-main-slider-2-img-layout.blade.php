<br>
<div class="row text-center">
	<div class="col-md-12">
		<div class="banners-below-main-slider">
			@foreach($banners as $banner)
				<div class="col-md-6 col-sm-6 col-xs-12">
			        <a href="{{$banner->link ? $banner->link : url()->current()}}">
			            @if($banner->photo)
			            <img class="img-responsive" src="{{route('imagecache', ['original', $banner->photo->getOriginal('name')])}}" alt="{{$banner->title ? $banner->title : __('Banner')}}"/>
			            @endif
			        </a>
		        </div>
		    @endforeach
		</div>
	</div>
</div>