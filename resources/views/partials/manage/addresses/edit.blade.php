<div class="row">
    <div class="col-xs-12 col-md-6">
        @if(session()->has('address_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('address_updated')}}</strong>
            </div>
        @endif
        @include('includes.form_errors')
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <strong><span class="cart-header">@lang('Shipping Address') <i class="fa fa-truck"></i></span></strong>
                </div>
                <div class="panel-body">

                    {!! Form::model($customer, ['method'=>'patch', 'action'=>['ManageAddressesController@update', $customer->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}

                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        {!! Form::label('first_name', __('First Name:')) !!}
                        {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder'=>__('Enter first name'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        {!! Form::label('last_name', __('Last Name:')) !!}
                        {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder'=>__('Enter last name'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', __('Address:')) !!}
                        {!! Form::textarea('address', null, ['class'=>'form-control', 'placeholder'=>__('Enter address'), 'rows'=>'6', 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        {!! Form::label('city', __('City:')) !!}
                        {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter city'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                        {!! Form::label('state', __('State:')) !!}
                        {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter state'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                        {!! Form::label('zip', __('Zip:')) !!}
                        {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder'=>__('Enter zip'), 'required'])!!}
                    </div>

                    @include('partials.countries_field')

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        {!! Form::label('phone-number', __('Phone:')) !!}
                        {!! Form::text('phone-number', $customer->phone, ['class'=>'form-control', 'placeholder'=>__('Enter your phone number'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', __('Email:')) !!}
                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter your email address'), 'required'])!!}
                    </div>

                </div>
                <div class="panel-footer text-right">
                    <div class="form-group">
                        {!! Form::submit(__('Update Address'), ['class'=>'btn btn-success', 'name'=>'submit_button']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>