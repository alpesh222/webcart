<!-- ============================================== NAVBAR ============================================== -->
<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only"> @lang('Toggle navigation') </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                    <div class="nav-outer">
                        <ul class="nav navbar-nav">
                            <li class="{{Html::isActive([url('/')])}} dropdown yamm-fw">
                                <a href="{{url('/')}}" > @lang('Home') </a>
                            </li>
                            @if(count($brands) > 0)
                                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"> @lang('Brands') </a>
                                    <ul class="dropdown-menu pages">
                                        <li>
                                            <div class="yamm-content">
                                                <div class="row">
                                                    <div class="col-xs-12 col-menu">
                                                        <ul class="links">
                                                            @foreach($brands as $brand)
                                                                <li><a href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @if(count($root_categories) > 0)
                                @foreach($root_categories as $category)
                                    @if($category->is_active)
                                        <li class="dropdown yamm mega-menu">
                                            @if($category->categories()->where('show_in_menu', true)->count())
                                                <a href="{{route('front.category.show', [$category->slug])}}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{$category->name}}</a>
                                                @include('partials.front.sub-categories-navbar', [
                                                'child_categories' => $category->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get(),
                                                'category' => $category
                                                ])
                                            @else
                                                <a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            @if(count($deals) > 0)
                                @php $i = 0; @endphp
                                @foreach($deals as $deal)
                                    <li class="dropdown hidden-sm">
                                        <a href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}
                                            @if($i === 0)
                                                <span class="menu-label new-menu hidden-xs">new</span>
                                            @endif
                                        </a>
                                    </li>
                                    @php $i++ @endphp
                                @endforeach
                            @endif
                            @if(count($pages) > 0)
                                @foreach($pages as $page)
                                    <li class="dropdown hidden-sm">
                                        <a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <!-- /.navbar-nav -->
                        <div class="clearfix"></div>
                    </div>
                    <!-- /.nav-outer -->
                </div>
                <!-- /.navbar-collapse -->

            </div>
            <!-- /.nav-bg-class -->
        </div>
        <!-- /.navbar-default -->
    </div>
    <!-- /.container-class -->

</div>
<!-- /.header-nav -->
<!-- ============================================== NAVBAR : END ============================================== -->