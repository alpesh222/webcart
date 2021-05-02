<div id='cssmenu'>
    <ul>
        @if(count($locations) > 1)
        <li class='active'><a href='#'><i class="fa fa-map-marker"></i> @lang('Store')<span class="label label-sm">{{session('location')}}</span></a>
            <ul>
                @foreach($locations as $location)
                <li><a href="{{route('front.index', [$location->slug])}}">{{$location->name}}</a></li>
                @endforeach
            </ul>
        </li>
        @endif
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