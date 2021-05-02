<br>
<div class="row text-center">
	<div class="col-md-12">
		<div class="banners-below-main-slider">
			@foreach($banners as $banner)
				<div class="col-md-4 col-sm-6">
			        <a href="{{$banner->link ? $banner->link : url()->current()}}">
						@if($banner->photo)
							@php
								$image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 200);
							@endphp
							<img src="{{$image_url}}" alt="{{$banner->title ? $banner->title : __('Banner')}}"  class="img-responsive"  />
						@else
							<img src="https://via.placeholder.com/200x200?text=No+Image" alt="{{$banner->title ? $banner->title : __('Banner')}}"  class="img-responsive" />
						@endif
			        </a>
		        </div>
		    @endforeach
		</div>
	</div>
</div>