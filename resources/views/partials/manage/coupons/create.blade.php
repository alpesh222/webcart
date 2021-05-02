<div class="row">

    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageCouponsController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Coupon Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter coupon name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', __('Coupon Code:')) !!}
            {!! Form::text('code', null, ['class'=>'form-control', 'placeholder'=>__('Enter coupon code'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', __('Description:')) !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter description')]) !!}
        </div>

        <div class="form-group{{ $errors->has('discount_amount') ? ' has-error' : '' }}">
            {!! Form::label('discount_amount', __('Discount Amount:')) !!}
            {!! Form::number('discount_amount', null, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter discount amount'), 'required', 'min'=>0]) !!}
        </div>

        <div class="form-group{{ $errors->has('starts_at') ? ' has-error' : '' }}">
            {!! Form::label('starts_at', __('Starting Date and Time:')) !!}
            {!! Form::text('starts_at', null, ['class'=>'form-control', 'placeholder'=>__('Select starting date and time'), 'required', 'id' =>'datetimepicker_start'])!!}
        </div>

        <div class="form-group{{ $errors->has('expires_at') ? ' has-error' : '' }}">
            {!! Form::label('expires_at', __('Ending Date and Time:')) !!}
            {!! Form::text('expires_at', null, ['class'=>'form-control', 'placeholder'=>__('Select ending date and time'), 'required', 'id' =>'datetimepicker_end'])!!}
        </div>

        <div class="form-group{{ $errors->has('max_uses_user') ? ' has-error' : '' }}">
            {!! Form::label('valid_above_amount', __('Amount above which Coupon is Valid:')) !!}
            {!! Form::number('valid_above_amount', null, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter amount above which coupon is valid'), 'min'=>0]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Add Coupon'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>