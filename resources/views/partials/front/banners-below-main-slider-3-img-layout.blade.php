<div class="row text-center banners-below-main-slider">
	<div class="col-md-12">
		<div class="col-md-8">
	        <a href="{{$main_banner->link ? $main_banner->link : url()->current()}}">
				@if($main_banner->photo)
					@php
						$image_url = \App\Helpers\Helper::check_image_avatar($main_banner->photo->name, 200);
					@endphp
					<img src="{{$image_url}}" alt="{{$main_banner->title ? $main_banner->title : __('Banner')}}" />
				@else
					<img src="https://via.placeholder.com/200x200?text=No+Image" alt="{{$main_banner->title ? $main_banner->title : __('Banner')}}" />
				@endif
	        </a>
	    </div>
	    <div class="col-md-4">
			<div class="row">
			@foreach($secondary_banners as $banner)
				<div class="col-md-12">
			        <a href="{{$banner->link ? $banner->link : url()->current()}}">
						@if($banner->photo)
							@php
								$image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 200);
							@endphp
							<img src="{{$image_url}}" alt="{{$banner->title ? $banner->title : __('Banner')}}" class="img-responsive" />
						@else
							<img src="https://via.placeholder.com/200x200?text=No+Image" alt="{{$banner->title ? $banner->title : __('Banner')}}" class="img-responsive" />
						@endif
			        </a>
		        </div>
		    @endforeach
		    </div>
	    </div>
	</div>
</div>