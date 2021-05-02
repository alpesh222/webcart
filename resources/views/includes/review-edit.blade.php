<div class="row">
    <div class="col-md-12 review-form-css">
        <h3>@lang('Edit a Review')</h3>

        {!! Form::model($review, ['method'=>'patch', 'action'=>['FrontReviewsController@update', $review->id], 'id'=>'review-form-update', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

            <div class="rating">
                <label>
                    <input {{($review->rating == 1) ? 'checked' : ''}} type="radio" name="stars" value="1" />
                    <span class="icon">★</span>
                </label>
                <label>
                    <input {{($review->rating == 2) ? 'checked' : ''}} type="radio" name="stars" value="2" />
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                </label>
                <label>
                    <input {{($review->rating == 3) ? 'checked' : ''}} type="radio" name="stars" value="3" />
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>   
                </label>
                <label>
                    <input {{($review->rating == 4) ? 'checked' : ''}} type="radio" name="stars" value="4" />
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                </label>
                <label>
                    <input {{($review->rating == 5) ? 'checked' : ''}} type="radio" name="stars" value="5" />
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                    <span class="icon">★</span>
                </label>
            </div>

            <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                {!! Form::textarea('review', $review->comment, ['rows'=>6, 'cols'=>4, 'class'=>'form-control', 'placeholder'=>__('Enter your review')]) !!}
            </div>

            <div class="form-group text-right">
                {!! Form::submit(__('Update Review'), ['class'=>'btn btn-primary', 'name'=>'submit_button']) !!}
            </div>

        {!! Form::close() !!}

        <br>
        @include('includes.form_errors')
    </div>
</div>