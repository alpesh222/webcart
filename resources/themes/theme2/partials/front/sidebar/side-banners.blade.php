@if(count($banners) > 0)
<!-- ============================================== Sidebar banners ============================================== -->
<div class="sidebar-widget wow fadeInUp outer-top-vs mb-20">
    <h3 class="section-title">@lang('Side Banners')</h3>
    <div id="advertisement1" class="advertisement">
        @foreach($banners as $banner)
                <div class="home-banner sidebar-banner">
                    <a href="{{$banner->link ? $banner->link : url()->current()}}">
                    @if($banner->photo)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 300);
                        @endphp
                        <img class="img-responsive" src="{{$image_url}}" alt="{{$banner->title ? $banner->title : __('Side Banner')}}"/>
                    @else
                        <img class="img-responsive" src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$banner->title ? $banner->title : __('Side Banner')}}" />
                    @endif
                    </a>
                        <div class="clients_author"> {{$banner->title ? $banner->title : __('Side Banner')}} </div>
                        <div class="testimonials">{{$banner->description ? $banner->description : __('Banner Description')}}</div>
                </div>
                <!-- /.container-fluid -->
            <!-- /.item -->
        @endforeach
    </div>
    <!-- /.owl-carousel -->
</div>
@endif
<!-- ============================================== Sidebar banners: END ============================================== -->