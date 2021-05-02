@foreach($reviews as $review)
    <div class="col-md-12">
        <div class="card-body">
            <div class="row custom-review-css">
                <div class="col-md-1 pr-0">
                    <img src="{{asset('img/icons/default-avatar.png')}}" class="img img-rounded img-responsive custom-default-img" />
                </div>
                <div class="col-md-11">
                    <p class="pt-5">
                        <a class="float-left" href="javascript:void(0)"><strong>{{$review->user->name}}</strong></a>
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
                                <a class="btn btn-primary edit-review custom-review-edit-btn" href="{{route('front.reviews.edit', ['id'=>$review->id])}}" >@lang('Edit Review')<i class="fa fa-edit"></i></a>
                            </span>
                            @endif
                        @endif
                        <br>
                        <p class="text-secondary text-left pt-0">{{$review->created_at->toFormattedDateString()}}</p>
                    </p>
                </div>

                <div class="col-md-12 ">
                    <div class="clearfix"></div>
                    <p class="pt-0">{{$review->comment}}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
