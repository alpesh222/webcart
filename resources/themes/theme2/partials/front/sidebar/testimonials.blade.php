<!-- ============================================== Testimonials============================================== -->
<div class="sidebar-widget  wow fadeInUp outer-top-vs ">
    <h3 class="section-title">@lang('Testimonials')</h3>
    <div id="advertisement" class="advertisement">
        @foreach($testimonials as $key=>$testimonial)
            <div class="item">
                <div class="avatar">
                    @if($testimonial->photo)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($testimonial->photo->name, 150, $default_photo);
                        @endphp
                        <img class="img-responsive" src="{{$image_url}}" alt="{{$testimonial->author}}"/>
                    @else
                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$testimonial->author}}" />
                    @endif
                </div>
                <div class="testimonials"><em>"</em> {{$testimonial->review}}<em>"</em></div>
                <div class="clients_author">{{$testimonial->author}} <span>{{$testimonial->designation ? ', ' .$testimonial->designation : ''}}</span> </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.item -->
        @endforeach
    </div>
    <!-- /.owl-carousel -->
</div>
<!-- ============================================== Testimonials: END ============================================== -->