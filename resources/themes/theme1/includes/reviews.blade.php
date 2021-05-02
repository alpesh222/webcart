<script>
var page = 1;
</script>
@if(count($product->reviews) > 0)
@if(count($product->reviews->where('approved', 1)->where('rating', '!=', null)) > 0)
<div class="col-md-12 product-detail-Ratings">
    <div class="col-md-6 detail-ratings-strat">
        @if(count($product->reviews->where('approved', 1)) > 0)
        <div class="text-center">
            <h1>{{$product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></h1>
            <div>{{count($product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</div>
        </div>
        @endif
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 detail-reviews">
		<div class="col-md-8 col-md-offset-2">
        <h4>@lang('Reviews & Ratings')</h4>
		
        <div class="pull-left custom-review-star-css">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: {{(count($product->reviews->where('approved', 1)->where('rating', 5)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}%">
                    <span class="sr-only">{{(count($product->reviews->where('approved', 1)->where('rating', 5)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{count($product->reviews->where('approved', 1)->where('rating', 5))}}</div>
        </div>
        <div class="pull-left custom-review-star-css">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: {{(count($product->reviews->where('approved', 1)->where('rating', 4)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}%">
                    <span class="sr-only">{{(count($product->reviews->where('approved', 1)->where('rating', 4)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{count($product->reviews->where('approved', 1)->where('rating', 4))}}</div>
        </div>
        <div class="pull-left custom-review-star-css">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: {{(count($product->reviews->where('approved', 1)->where('rating', 3)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}%">
                    <span class="sr-only">{{(count($product->reviews->where('approved', 1)->where('rating', 3)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{count($product->reviews->where('approved', 1)->where('rating', 3))}}</div>
        </div>
        <div class="pull-left custom-review-star-css">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: {{(count($product->reviews->where('approved', 1)->where('rating', 2)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}%">
                    <span class="sr-only">{{(count($product->reviews->where('approved', 1)->where('rating', 2)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{count($product->reviews->where('approved', 1)->where('rating', 2))}}</div>
        </div>
        <div class="pull-left custom-review-star-css">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: {{(count($product->reviews->where('approved', 1)->where('rating', 1)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}%">
                    <span class="sr-only">{{(count($product->reviews->where('approved', 1)->where('rating', 1)) / count($product->reviews->where('approved', 1)->where('rating', '!=', null))) * 100}}% Complete (danger)</span>
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{count($product->reviews->where('approved', 1)->where('rating', 1))}}</div>
        </div>
    </div>
    </div>
</div>
@endif

<div id="approved_reviews" class=" cleafix col-md-12">
    @include('includes.approved_reviews', ['reviews' => $product->reviews()->where('approved', 1)->orderBy('id', 'desc')->paginate(5)])
</div>

<div class="text-center">
    <button class="btn btn-sm" id="load-more">@lang('Load More')</button>
</div>

@if(Auth::check())
@foreach($product->reviews->where('approved', 0)->where('user_id', Auth::user()->id) as $review)
    <hr>
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
                @if($review->user_id == Auth::user()->id)
                    <span class="pull-right">
                        <a class="btn btn-primary edit-review custom-review-edit-btn" href="{{route('front.reviews.edit', ['id'=>$review->id])}}" >@lang('Edit Review')<i class="fa fa-edit"></i></a>
                    </span>
                @endif
                <p class="text-secondary text-left pt-0">{{$review->created_at->toFormattedDateString()}}</p>
                <small class="text-danger"><strong>@lang('Pending for approval from administrators')</strong></small>
            </p>
        </div>

        <div class="col-md-12 ">
            <div class="clearfix"></div>
            <p class="pt-0">{{$review->comment}}</p>
        </div>
    </div>
@endforeach
@endif
@else
<div class="row">
    <div class="col-md-12 custom_no_review_div">
        <h4>@lang('There are no reviews.')</h4>
    </div>
</div>
@endif