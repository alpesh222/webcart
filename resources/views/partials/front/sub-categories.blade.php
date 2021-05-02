<ul>
    @foreach($childs as $child)
        @if($child->is_active)
        <li><a href="{{route('front.category.show', [$child->slug])}}">{{$child->name}}</a>
            @if($child->categories()->where('show_in_menu', true)->count())
                @include('partials.front.sub-categories',['childs' => $child->categories()->where('show_in_menu', true)->orderBy('priority', 'asc')->get()])
            @endif
        </li>
        @endif
    @endforeach
</ul>