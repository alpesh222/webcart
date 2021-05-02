@foreach($childs as $child)
    @if(count($child->categories) > 0)
        @if(!in_array($child->id, $ignore_ids))
            <option {{$id == $child->id ? "selected" : ""}} class="bolden" value="{{$child->id}}">{{str_repeat('&emsp;', $space)}}{{$child->name}} (ID: {{$child->id}})</option>
            @include('partials.manage.subcategories-edit-select', ['childs' => $child->categories, 'space'=>$space+1, 'ignore_ids'=>$ignore_ids, 'id'=>$id])
        @endif
    @else
        @if(!in_array($child->id, $ignore_ids))
            <option {{$id == $child->id ? "selected" : ""}} value="{{$child->id}}">{{str_repeat('&emsp;', $space)}}{{$child->name}} (ID: {{$child->id}})</option>
        @endif
    @endif
@endforeach
