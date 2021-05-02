@php
    $vendor_name        = !empty($vendor->user->name) ? $vendor->user->name: 'N/a';
    $vendor_username    = !empty($vendor->user->username) ? $vendor->user->username: 'N/a';
    $vendor_email       = !empty($vendor->user->email) ? $vendor->user->email: 'N/a';
    $vendor_verified    = !empty($vendor->user->verified) ? $vendor->user->verified: 0;
    $vendor_is_active   = !empty($vendor->user->is_active) ? $vendor->user->is_active: 0;
@endphp
<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8">

        @if(session()->has('vendor_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('vendor_updated')}}</strong>
            </div>
        @endif

        @if(session()->has('vendor_not_updated'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('vendor_not_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($vendor, ['method'=>'patch', 'action'=>['ManageVendorsController@update', $vendor->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <h4>User Details</h4>
        <br>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Name:')) !!}
            {!! Form::text('name', $vendor_name, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            {!! Form::label('username', __('Username:')) !!}
            {!! Form::text('username',$vendor_username, ['class'=>'form-control', 'placeholder'=>__('Enter username'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', __('Email:')) !!}
            {!! Form::email('email', $vendor->user->email, ['class'=>'form-control', 'placeholder'=>__('Enter email'), 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('verified', __('Email Status:')) !!}
            {!! Form::select('verified', [true=>__('verified'), false=>__('unverified')], $vendor_verified, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', __('Password:')) !!}
            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>__('Enter password')]) !!}
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password_confirmation', __('Confirm Password:')) !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>__('Enter password again')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $vendor_is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <hr>
        <h4>@lang('Vendor Details')</h4>
        <br>

        <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
            {!! Form::label('shop_name', __('Shop Name:')) !!}
            {!! Form::text('shop_name', $vendor->shop_name, ['class'=>'form-control', 'placeholder'=>__('Enter shop name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('shop_slug') ? ' has-error' : '' }}">
            {!! Form::label('shop_slug', __('Shop Slug:')) !!}
            {!! Form::text('shop_slug', $vendor->slug, ['class'=>'form-control', 'placeholder'=>__('Enter shop slug to be shown in URL'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
            {!! Form::label('company_name', __('Company Name:')) !!}
            {!! Form::text('company_name', $vendor->name, ['class'=>'form-control', 'placeholder'=>__('Enter company name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone-number', __('Phone:')) !!}
            {!! Form::text('phone-number', $vendor->phone, ['class'=>'form-control', 'placeholder'=>__('Enter phone number'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', __('Description:')) !!}
            {!! Form::textarea('description', $vendor->description, ['class'=>'form-control', 'placeholder'=>__('Enter description'), 'rows'=>'6'])!!}
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address', __('Address:')) !!}
            {!! Form::text('address', $vendor->address, ['class'=>'form-control', 'placeholder'=>__('Enter address')])!!}
        </div>

        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            {!! Form::label('city', __('City:')) !!}
            {!! Form::text('city', $vendor->city, ['class'=>'form-control', 'placeholder'=>__('Enter city')])!!}
        </div>

        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            {!! Form::label('state', __('State:')) !!}
            {!! Form::text('state', $vendor->state, ['class'=>'form-control', 'placeholder'=>__('Enter state')])!!}
        </div>

        <div class="form-group{{ $errors->has('amount_percentage_per_sale') ? ' has-error' : '' }}">
            {!! Form::label('amount_percentage_per_sale', __('Percentage of amount per sale that this vendor gets:')) !!}
            {!! Form::number('amount_percentage_per_sale', $vendor->amount_percentage, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter percentage of amount per sale that this vendor gets'), 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('profile_status', __('Profile Status:')) !!}
            {!! Form::select('profile_status', [0=>__('Incomplete'), 1=>__('Completed')], $vendor->profile_completed, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('account_status', __('Account Status:')) !!}
            {!! Form::select('account_status', [0=>__('Pending'), 1=>__('Approved')], $vendor->approved, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update Vendor'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>
