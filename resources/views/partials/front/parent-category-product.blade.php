@if($category->category)
    @include('partials.front.parent-category', ['category'=>$category->category])
@endif
<li><a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a></li>