<div class="row">
	<div class="col-md-8 col-center m-auto">
		<h2 class="title-testimonial">@lang('What our Customers say')</h2>
		<div class="swiper-container tstm">
	   		<div class="swiper-wrapper testimonial">
			   @foreach($testimonials as $key=>$testimonial)
				<div class="swiper-slide">
					<div class="testimonial-swiper">
						@if($testimonial->photo)
							@php
								$image_url = \App\Helpers\Helper::check_image_avatar($testimonial->photo->name, 150, $default_photo);
							@endphp
							<div class="img-box">
								<img src="{{$image_url}}" alt="{{$testimonial->author}}"/>
							</div>
						@else
							<div class="img-box">
								<img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$testimonial->author}}" />
							</div>
						@endif
						<div class="testimonial-cont">
							<p class="testimonial">{{$testimonial->review}}</p>
							<h3 class="overview"><b>{{$testimonial->author}}</b>{{$testimonial->designation ? ', ' .$testimonial->designation : ''}}</h3>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>
</div>

