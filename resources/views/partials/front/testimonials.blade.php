<div class="row">
	<div class="col-md-8 col-center m-auto">
		<h2 class="title-testimonial">@lang('What our Customers say')</h2>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Carousel indicators -->
			<ol class="carousel-indicators">
				@foreach($testimonials as $key=>$testimonial)
					<li data-target="#myCarousel" data-slide-to="{{$key}}" @if($key == 0) class="active" @endif></li>
				@endforeach
			</ol>
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				@foreach($testimonials as $key=>$testimonial)
				<div class="item carousel-item @if($key == 0) active @endif">
					<div class="img-box"><img src="@if($testimonial->photo) {{route('imagecache', ['medium', $testimonial->photo->getOriginal('name')])}} @else {{$default_photo}} @endif" alt="{{$testimonial->author}}"></div>
					<p class="testimonial">{{$testimonial->review}}</p>
					<p class="overview"><b>{{$testimonial->author}}</b>{{$testimonial->designation ? ', ' .$testimonial->designation : ''}}</p>
				</div>
				@endforeach
			</div>
			<!-- Carousel controls -->
			<a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
	</div>
</div>