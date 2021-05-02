
    @foreach($reviews as $review)
        <li class="review li-comment">
        <div id="comment" class="comment_container row">
            <div class="col-md-2 col-sm-2">
                <img alt='@lang('User Image')' src='{{asset('img/icons/default-avatar.png')}}' srcset='{{asset('img/icons/default-avatar.png')}} 2x'
                     class='avatar avatar-100 photo img-rounded img-responsive mt-0' height='100' width='100' />
            </div>
            <div class="col-md-10 col-sm-10 outer-bottom-xs">
                <div class="inner-bottom-xs">
                    <div class="star-rating" role="img" >
                        @php
                            $empty_stars = 5 - $review->rating;
                        @endphp
                        @for($i=1; $i <= $review->rating; $i++)
                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        @endfor
                        @for($i=1; $i <= $empty_stars; $i++)
                            <span class="float-right"><i class="text-warning fa fa-star-o"></i></span>
                        @endfor
                        @if(Auth::check())
                            @if($review->user_id == Auth::user()->id)
                                <span class="pull-right">
                                <a class="btn btn-primary edit-review custom-review-edit-btn" href="{{route('front.reviews.edit', ['id'=>$review->id])}}" >
                                    @lang('Edit Review') <i class="fa fa-edit"></i>
                                </a>
                            </span>
                            @endif
                        @endif
                    </div>
                    <p class="meta pt-0">
                        <strong class="author">{{$review->user->name}} </strong>
                        <span class="dash">&ndash;</span>
                        <time class="published-date" datetime="{{$review->created_at}}">{{$review->created_at->toFormattedDateString()}}</time>
                        @if($review->approved == 0)
                            <small class="text-danger d-block">
                                <strong>
                                    @lang('Pending for approval from administrators')
                                </strong>
                            </small>
                        @endif
                    </p>
                    <div class="description">
                        <p class="pt-0">{{strlen($review->comment) > 150 ? substr($review->comment,0,150)."..." : $review->comment}}</p>
                    </div>
                </div>
            </div>
        </div>
    </li><!-- #comment-## -->
    @endforeach
