<div class="product-tabs inner-bottom-xs  wow fadeInUp">
    <div class="row">
        <div class="col-sm-3">
            <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
                <li class="active"><a data-toggle="tab" href="#description">@lang('DESCRIPTION')</a></li>
                <li><a data-toggle="tab" href="#specification">@lang('SPECIFICATION')</a></li>
                <li><a data-toggle="tab" href="#review">@lang('REVIEWS')</a></li>
            </ul><!-- /.nav-tabs #product-tabs -->
        </div>
        <div class="col-sm-9">
            <div class="tab-content">
                <div id="description" class="tab-pane in active">
                    <div class="product-description">
                        <h4 class="title">@lang('Product Description')</h4>
                        <p class="text top-10">
                            {!! $product->description !!}
                        </p>
                    </div>
                </div><!-- /.tab-pane -->

                <div id="specification" class="tab-pane">
                    <div class="product-tag">
                        <h4 class="title">@lang('Product Specifications')</h4>
                        @if(count($product->specificationTypes) > 0)
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <th>@lang('PROPERTY')</th>
                                        <th>@lang('VALUE')</th>
                                    </tr>
                                    @foreach($product->specificationTypes as $specification)
                                        @if(isset($specification->pivot->value))
                                            <tr>
                                                <th width="40%">{{$specification->name}}</th>
                                                <td>{{$specification->pivot->value}} {{$specification->pivot->unit}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div><!-- /.product-tab -->
                </div><!-- /.tab-pane -->

                <div id="review" class="tab-pane">
                    <div class="product-tab" id="reviews">
                        <div class="product-reviews">
                            <h4 class="title">@lang('Customer Reviews')</h4>
                            <div class="reviews">
                                @include('includes.reviews')
                            </div><!-- /.reviews -->
                        </div><!-- /.product-reviews -->
                        @if(Auth::check())
                            @if(!$product->reviews->contains('user_id', Auth::user()->id))
                                <div class="product-add-review">
                                    <h4 class="title">@lang('Write your own review')</h4>

                                    {!! Form::open(['method'=>'post', 'action'=>'FrontReviewsController@store', 'id'=>'review-form', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                                    {!! Form::hidden('product', $product ? $product->id : 0) !!}
                                    <span class="weight-title"> @lang('Your Rating') : </span>
                                    <div class="rating">
                                        <div class="row">
                                            <div class="col-12 col-md-6 custom_add_rating_div">
                                                <div id="halfstarsReview"></div>
                                            </div>
                                            <input type="hidden" name="stars" readonly id="halfstarsInput" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                                        {!! Form::textarea('review', null, ['rows'=>6, 'cols'=>4, 'id'=>'front_review_form', 'class'=>'form-control', 'placeholder'=>__('Enter your review')]) !!}
                                    </div>

                                    <div class="form-group text-right">
                                        {!! Form::submit(__('Submit Review'), ['class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
                                    </div>

                                    {!! Form::close() !!}

                                </div><!-- /.product-add-review -->
                            @endif
                        @endif
                    </div><!-- /.product-tab -->
                </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.product-tabs -->
