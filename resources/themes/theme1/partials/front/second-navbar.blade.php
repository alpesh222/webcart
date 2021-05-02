<div id='cssmenu'>
    <ul>
        @if(count($brands) > 0)
        <li class='active'><a href='#'><i class="fa fa-star"></i> @lang('Brands')</a>
            <ul>
                @foreach($brands as $brand)
                <li><a href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a></li>
                @endforeach
            </ul>
        </li>
        @endif

        @if(count($root_categories) > 0)
            @foreach($root_categories as $category)
                @if($category->is_active)
                <li><a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a>
                    @if($category->categories()->where('show_in_menu', true)->count())
                        @include('partials.front.sub-categories', ['childs' => $category->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get()])
                    @endif
                </li>
                @endif
            @endforeach
        @endif

        @if(count($deals) > 0)
            @foreach($deals as $deal)
            <li><a href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}</a></li>
            @endforeach
        @endif

        @if(count($pages) > 0)
            @foreach($pages as $page)
            <li><a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}</a></li>
            @endforeach
        @endif
    </ul>
</div>

<nav id="cssmenu-2" class="navbar navbar-default header-main-3">
  <div class="container-fluid">
    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav navbar-nav">
            @if(count($brands) > 0)
            <li class='dropdown dropdown-large vertical-menu'><a href='#' class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-star"></i> @lang('Brands') <b class="caret"></b></a>
                <ul class="dropdown-menu dropdown-menu-large row animate fadeIn faster">
                    @foreach($brands as $brand)
                    <li class="col-centered second-nav-item"><a href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            @endif
            @if(count($root_categories) > 0)
                @foreach($root_categories as $category)
                    @if($category->is_active)
            <li class="dropdown dropdown-large">
                    @if($category->categories()->where('show_in_menu', true)->count())
                <a href="{{route('front.category.show', [$category->slug])}}" class="dropdown-toggle" data-toggle="dropdown">{{$category->name}} <b class="caret"></b></a>
                <ul class="dropdown-menu dropdown-menu-large row animate zoomIn faster">
                    @if($category->photo)
                    <li class="col-centered custom_cat_li_css">
                        <div class="thumbnail">
                            <a href="{{route('front.category.show', [$category->slug])}}">
                            @if($category->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($category->photo->name, 200);
                                @endphp
                                <img src="{{$image_url}}" alt="{{$category->name}}" />
                            @else
                                <img src="https://via.placeholder.com/200x200?text=No+Image" alt="{{$category->name}}" />
                            @endif
                            </a>
                        </div>
                    </li>
                    @endif
                        @foreach($category->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get() as $sub_category)
                            @if($sub_category->is_active)
                    <li class="col-centered">
                        <ul class="">
                            <li class="dropdown-header"><a href="{{route('front.category.show', [$sub_category->slug])}}">{{$sub_category->name}}</a></li>
                                @if($sub_category->categories()->where('show_in_menu', true)->count())
                                    @foreach($sub_category->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get() as $sub_sub_category)
                                        @if($sub_sub_category->is_active)
                            <li><a href="{{route('front.category.show', [$sub_sub_category->slug])}}">{{$sub_sub_category->name}}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                        </ul>
                    </li>
                            @endif
                        @endforeach
                </ul>
                    @else
                <a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a>
                    @endif
            </li>
                    @endif
                @endforeach
            @endif
            @if(count($deals) > 0)
                @foreach($deals as $deal)
            <li><a href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}</a></li>
                @endforeach
            @endif
            @if(count($pages) > 0)
                @foreach($pages as $page)
            <li><a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}</a></li>
                @endforeach
            @endif
        </ul>
    </div><!-- /.nav-collapse -->
  </div>
</nav>