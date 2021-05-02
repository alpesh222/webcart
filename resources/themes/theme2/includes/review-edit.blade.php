<div class="row">
    <div class="col-md-12 review-form-css">
        <h3>@lang('Edit a Review')</h3>

        {!! Form::model($review, ['method'=>'patch', 'action'=>['FrontReviewsController@update', $review->id], 'id'=>'review-form-update', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
            <span class="weight-title"> @lang('Your Rating') : </span>
            <br>
            <div class="rating">
                <div class="col-12 col-md-6 custom_add_rating_div">
                    <div id="halfstarsReview"></div>
                </div>
                <input type="hidden" name="stars" readonly id="halfstarsInput" value="{{$review->rating}}" class="form-control form-control-sm">

            </div>

            <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }} mt-10">
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
<script>
    var currentStars = $('#halfstarsInput').val();
    $("#halfstarsReview").rating({
        "value": currentStars,
        "click":function (e) {
            $('#halfstarsInput').val(e.stars);
        }
    });
</script>