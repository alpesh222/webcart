<!-- ================================== CATEGORIES TOP NAVIGATION ================================== -->
<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> @lang('Categories') </div>
    <nav class="yamm megamenu-horizontal">
        <ul class="nav">
            @if(count($root_categories) > 0)
                @foreach($root_categories as $category)
                    @if($category->is_active)
                        <li class="dropdown menu-item">
                            @if($category->categories()->where('show_in_menu', true)->count())
                                <a href="{{route('front.category.show', [$category->slug])}}" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon fa fa-shopping-bag" aria-hidden="true"></i>
                                    {{$category->name}}
                                </a>
                                @include('partials.front.sidebar.sub-categories-sidebar', ['child_categories' => $category->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get()])
                            @else
                                <a href="{{route('front.category.show', [$category->slug])}}"><i class="icon fa fa-futbol-o"></i> {{$category->name}}</a>
                            @endif
                            <!-- /.dropdown-menu -->
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
        <!-- /.nav -->
    </nav>
    <!-- /.megamenu-horizontal -->
</div>
<!-- /.side-menu -->
<!-- ================================== CATEGORIES TOP NAVIGATION : END ================================== -->