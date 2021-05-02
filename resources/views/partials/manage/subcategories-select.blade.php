@foreach($childs as $child)
    @if(count($child->categories) > 0)
        <option class="bolden" value="{{$child->id}}">{{str_repeat('&emsp;', $space)}}{{$child->name}} (ID: {{$child->id}})</option>
        @include('partials.manage.subcategories-select', ['childs' => $child->categories, 'space'=>$space+1])
    @else
        <option value="{{$child->id}}">{{str_repeat('&emsp;', $space)}}{{$child->name}} (ID: {{$child->id}})</option>
    @endif
@endforeach
