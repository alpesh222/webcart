<!-- ============================================== MEGA MENU SUBCATEGORIES ============================================== -->
<ul class="dropdown-menu container">
    <li>
        <div class="yamm-content ">
            <div class="row">
                <div class="col-md-8">
                @foreach($child_categories as $child)
                    @if($child->is_active)
                        <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                            <h2 class="title"><a href="{{route('front.category.show', [$child->slug])}}">{{$child->name}}</a></h2>
                            <ul class="links sub-cat-container">
                                @if($child->categories()->where('show_in_menu', true)->count())
                                    @foreach($child->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get() as $child_sub_category)
                                        @if($child_sub_category->is_active)
                                            <li>
                                                <a href="{{route('front.category.show', [$child_sub_category->slug])}}">{{$child_sub_category->name}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                @endforeach
                </div>
                @if($category->photo)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                        <a href="{{route('front.category.show', [$category->slug])}}">
                            @if($category->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($category->photo->name, 200);
                                @endphp
                                <img class="img-responsive" src="{{$image_url}}" alt="{{$category->name}}" />
                            @else
                                <img class="img-responsive" src="https://via.placeholder.com/200x200?text=No+Image" alt="{{$category->name}}" />
                            @endif
                        </a>
                    </div>
                @endif
                <!-- /.yamm-content -->
            </div>
        </div>
    </li>
</ul>


<!-- /.header-nav -->
<!-- ============================================== MEGA MENU SUBCATEGORIES : END ============================================== -->