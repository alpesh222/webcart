@foreach($reviews as $review)
    <hr>
    <div class="row">
        <div class="review-box">
            <strong>{{$review->user->name}}</strong><br>
            @for($i=1; $i <= 5; $i++)
                <span class="glyphicon glyphicon-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
            @endfor
            <span class="pull-right">{{$review->created_at->toFormattedDateString()}}</span>
            @if(Auth::check())
                @if($review->user_id == Auth::user()->id)
                    <div class="text-right"><a class="edit-review" href="{{route('front.reviews.edit', ['id'=>$review->id])}}">@lang('Edit Review')</a></div>
                @endif
            @endif
            <p>{{$review->comment}}</p>
        </div>
    </div>
@endforeach