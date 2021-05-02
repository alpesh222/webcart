<div class="row">

    <div class="col-xs-12 col-sm-8">

        @if(session()->has('delivery_location_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('delivery_location_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($delivery_location_data, ['method'=>'patch', 'action'=>['ManageDeliveryLocationController@update', $delivery_location_data->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
            <input type="hidden" name="edit_form" value="edit">
            <input type="hidden" name="delivery_location_id" value="{{$delivery_location_data->id}}">
            <div class="form-group{{ $errors->has('enable_delivery_location') ? ' has-error' : '' }}">
                {!! Form::label('enable_delivery_location', __('Delivery location Status:')) !!}
                {!! Form::select('enable_delivery_location', [true=>__('Active'), false=>__('Inactive')], $delivery_location_data->status, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
            </div>

            @include('partials.countries_field')

            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                {!! Form::label('state', __('State:')) !!}
                {!! Form::text('state', $delivery_location_data->state, ['class'=>'form-control', 'placeholder'=>__('Enter shipment state')])!!}
            </div>

            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                {!! Form::label('city', __('City:')) !!}
                {!! Form::text('city', $delivery_location_data->city, ['class'=>'form-control', 'placeholder'=>__('Enter shipment city')])!!}
            </div>

            <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                {!! Form::label('zip_code', __('Zip Code:')) !!}
                {!! Form::text('zip_code', $delivery_location_data->pincode, ['class'=>'form-control', 'placeholder'=>__('Enter Delivery Location zip code')])!!}
            </div>


        <div class="form-group">
            {!! Form::submit(__('Update Shipment'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>