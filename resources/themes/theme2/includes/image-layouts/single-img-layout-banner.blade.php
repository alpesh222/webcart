<!-- ============================================== Single Banner ============================================== -->
<div class="wide-banners wow fadeInUp outer-bottom-xs">
    <div class="row">
        @foreach($banners as $banner)
            <div class="col-md-12">
                <div class="wide-banner cnt-strip">
                    <div class="image">
                        <a href="{{$banner->link ? $banner->link : url()->current()}}">
                            @if($banner->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 1500, '', 500);
                                @endphp
                                <img class="img-responsive"  src="{{$image_url}}" alt="{{$banner->title ? $banner->title : __('Banner')}}"  />
                            @else
                                <img class="img-responsive"  src="https://via.placeholder.com/1500x1500?text=No+Image" alt="{{$banner->title ? $banner->title : __('Banner')}}"   />
                            @endif
                        </a>
                    </div>
                    <div class="strip strip-text">
                        <div class="strip-inner">
                            <h2 class="text-right">{{$banner->title ? $banner->title : __('Banner')}}<br>
                                <span class="shopping-needs">{{$banner->description ? $banner->description : __('Banner Description')}}</span></h2>
                        </div>
                    </div>
                    <div class="new-label">
                        <div class="text">@lang('NEW')</div>
                    </div>
                    <!-- /.new-label -->
                </div>
                <!-- /.wide-banner -->
            </div>
            <!-- /.col -->
        @endforeach

    </div>
    <!-- /.row -->
</div>
<!-- /.single-banner -->
<!-- ============================================== Single Banner : END ============================================== -->