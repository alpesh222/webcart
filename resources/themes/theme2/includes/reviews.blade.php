<script>
    var page = 1;
</script>
@if(count($product->reviews) > 0)
    @if(count($product->reviews->where('approved', 1)->where('rating', '!=', null)) > 0)
        <div class="col-md-12 product-detail-Ratings">
            <div class="col-md-4 detail-ratings-strat">
                @if(count($product->reviews->where('approved', 1)) > 0)
                    <div class="text-center">
                        <h1>{{$product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></h1>
                        <div>{{count($product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</div>
                    </div>
                @endif
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 detail-reviews">
                <div class="col-md-12">
                    <h4 class="mt-0">@lang('Reviews & Ratings')</h4>

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

    <div id="approved_reviews" class="clearfix col-md-12">
        <ul class="comment-list">
            @include('includes.approved_reviews', ['reviews' => $product->reviews()->where('approved', 1)->orderBy('id', 'desc')->paginate(5)])
        </ul>
    </div>

    @if($product->reviews()->where('approved', 1)->count() > 0 )
        <div class="text-center">
            <button class="btn btn-sm hover-color-light" id="load-more">@lang('Load More')</button>
        </div>
    @endif
    @if(Auth::check())
        <ul class="comment-list">
            {{-- Unapproved Products --}}
            @include('includes.approved_reviews', ['reviews' => $product->reviews->where('approved', 0)->where('user_id', Auth::user()->id)])
        </ul>
    @endif
@else
    <div class="row text-center">
        <div class="empty-bag">
            <div class="empty-bag-icon">
                <img src="{{asset('/img/icons/reviews.png')}}" class="img-responsive m-a" alt="@lang('No Reviews')" width="100">
            </div>
            <h3 class="text-center text-muted">@lang('NO REVIEWS FOUND')</h3>
        </div>
    </div>
@endif