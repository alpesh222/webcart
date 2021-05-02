<div class="row">
    <div class="col-md-12">
        <ul id="nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#description"
                    aria-controls="description"
                    role="tab"
                    data-toggle="tab"
                >@lang('Description')</a>
            </li>
            <li role="presentation">
                <a href="#specifications"
                aria-controls="specifications"
                role="tab"
                data-toggle="tab"
                >@lang('Specifications')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="description">
                <p class="top-10">
                    {!! $product->description !!}
                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="specifications">
                @if(count($product->specificationTypes) > 0)
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            @foreach($product->specificationTypes as $specification)
                                @if(isset($specification->pivot->value))
                                <tr>
                                    <th>{{$specification->name}}</th>
                                    <td>{{$specification->pivot->value}} {{$specification->pivot->unit}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div id="reviews">
            @include('includes.reviews')
            @if(Auth::check())
                @if(!$product->reviews->contains('user_id', Auth::user()->id))
                <div class="row">
                    <div class="col-md-10">
                        <h3>@lang('Leave a Review')</h3>

                        {!! Form::open(['method'=>'post', 'action'=>'FrontReviewsController@store', 'id'=>'review-form', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                            {!! Form::hidden('product', $product ? $product->id : 0) !!}

                            <div class="rating">
                                <label>
                                    <input required type="radio" name="stars" value="1" />
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" value="2" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" value="3" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>   
                                </label>
                                <label>
                                    <input type="radio" name="stars" value="4" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" value="5" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                            </div>

                            <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                                {!! Form::textarea('review', null, ['rows'=>6, 'cols'=>4, 'class'=>'form-control', 'placeholder'=>__('Enter your review')]) !!}
                            </div>

                            <div class="form-group text-right">
                                {!! Form::submit('Submit Review', ['class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
                            </div>

                        {!! Form::close() !!}

                        <br>
                        @include('includes.form_errors')
                    </div>
                </div>
                @endif
            @endif
        </div>
        
    </div>
</div>