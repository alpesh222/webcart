<ul>
    @foreach($childs as $child)
        <li>
            {{ $child->name . ' (ID: '.$child->id.')' }}
            @if(count($child->categories))
                @include('partials.manage.subcategories',['childs' => $child->categories])
            @endif
        </li>
    @endforeach
</ul>