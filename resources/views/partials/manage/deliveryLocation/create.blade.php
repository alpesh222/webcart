<div class="row">

    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageDeliveryLocationController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('enable_delivery_location') ? ' has-error' : '' }}">
            {!! Form::label('enable_delivery_location', __('Delivery location Status:')) !!}
            {!! Form::select('enable_delivery_location', [true=>__('Active'), false=>__('Inactive')], true, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @include('partials.countries_field')

        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            {!! Form::label('state', __('State:')) !!}
            {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment state')])!!}
        </div>

        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            {!! Form::label('city', __('City:')) !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment city')])!!}
        </div>

        <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
            {!! Form::label('zip_code', __('Zip Code:')) !!}
            {!! Form::text('zip_code', null, ['class'=>'form-control', 'placeholder'=>__('Enter Delivery Location zip code')])!!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Add Delivery Location'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>