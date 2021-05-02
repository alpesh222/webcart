<ul>
    @foreach($childs as $child)
        <li>
            @if($child->id == $product_category_id)
                {{ $child->name }} (ID: {{ $child->id }}) <span class="glyphicon glyphicon-ok"></span>
            @else
                {{ $child->name }} (ID: {{ $child->id }})
            @endif
            @if(count($child->categories))
                @include('partials.manage.product-edit-subcategories',['childs' => $child->categories])
            @endif
        </li>
    @endforeach
</ul>