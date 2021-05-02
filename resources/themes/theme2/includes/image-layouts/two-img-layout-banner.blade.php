<!-- ============================================== WIDE PRODUCTS ============================================== -->
<div class="wide-banners wow fadeInUp outer-bottom-xs">
    <div class="row">
        @php $i = 0;  @endphp
        @foreach($banners as $banner)

            <div class="col-md-{{$i == 0 ? 7 : 5}} col-sm-{{$i == 0 ? 7 : 5}}">
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
                </div>
                <!-- /.wide-banner -->
            </div>
            <!-- /.col -->
            @php $i++;  @endphp
        @endforeach
    </div>
    <!-- /.row -->
</div>
<!-- /.wide-banners -->
<!-- ============================================== WIDE PRODUCTS : END ============================================== -->