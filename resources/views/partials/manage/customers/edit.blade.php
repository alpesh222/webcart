<div class="row">
    <div class="col-xs-12 col-md-6">

        @if(session()->has('user_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('user_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($user, ['method'=>'patch', 'action'=>['ManageCustomersController@update', $user->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        @if($user->photo)
            <div class="form-group">
                <div class="has-error">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remove_photo') !!} <strong>@lang('Remove Photo')</strong>
                        </label>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            {!! Form::label('username', __('Username:')) !!}
            {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>__('Enter username'), 'required'])!!}
        </div>

        @if(config('settings.phone_otp_verification'))
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone-number',__('Phone:')) !!}
            @if($user->mobile)
                @if($user->mobile->verified)
                <strong class="text-success">@lang('verified')</strong>
                @else
                <strong class="text-danger">@lang('unverified')</strong>
                @endif
            @endif
            {!! Form::text('phone-number', $user->mobile ? $user->mobile->number : null, ['class'=>'form-control', 'placeholder'=>__('Enter phone number')]) !!}
        </div>

        <div class="checkbox">
            <label>{!! Form::checkbox('phone_verified', 1, ($user->mobile && $user->mobile->verified) ? $user->mobile->verified : false, ['id'=>'phone_verified']); !!} <strong>@lang('Phone Verified?')</strong></label>
        </div>

        @if($user->mobile)
        <div class="checkbox">
            <label>{!! Form::checkbox('remove_phone', 1, false, ['id'=>'remove_phone']); !!} <strong class="text-danger">@lang('Remove Phone Number?')</strong></label>
        </div>
        @endif
        <hr>
        @endif

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email',__('Email:')) !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter email'), 'required']) !!}
        </div>

        @if($user->id !== 1)
        @can('update', App\User::class)
        @if(!$user->location || $user->location->id == Auth::user()->location_id)
            @php
                $user_role = \App\Helpers\Helper::get_user_role($user);
            @endphp
        <div class="form-group">
            {!! Form::label('role', __('Role:')) !!}
            {!! Form::select('role', ['0'=>__('None')] + $roles, $user_role['role_id'], ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>
        @endif
        @endcan

        <div class="form-group">
            {!! Form::label('verified', __('Email Status:')) !!}
            {!! Form::select('verified', [true=>__('verified'), false=>__('unverified')], $user->verified, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $user->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>
        @endif

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', __('Password:')) !!}
            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>__('Enter password')]) !!}
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password_confirmation', __('Confirm Password:')) !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>__('Enter password again')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo', __('Choose photo'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-info">@lang('No photo chosen')</span>
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update Customer'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>

    <div class="col-xs-12 col-md-6">
        <h3 class="text-center">@lang('Shipping Addresses')</h3>
        <hr>
        @if(session()->has('address_deleted'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('address_deleted')}}</strong>
        </div>
        @endif
        @foreach($customers as $key => $customer)
            <div class="col-md-12">
                <div class="shipping-address">
                    <h4>{{$key+1}}. @lang('Shipping Address')</h4>
                    <strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong>,<br>
                    {{$customer->address}}<br>
                    {{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}<br>
                    {{$customer->country}}.<br>
                    <strong>@lang('Phone:')</strong> {{$customer->phone}}<br>
                    <strong>@lang('Email:')</strong> {{$customer->email}}<br>
                    <div class="btn-area">
                        <a class="btn btn-primary btn-xs pull-left" href="{{route('manage.customer-address.edit', $customer->id)}}">@lang('Edit')</a>
                        {!! Form::model($customer, ['method'=>'delete', 'action'=>['ManageAddressesController@destroy', $customer->id], 'id'=> 'delete-form-'.$customer->id, 'style'=>'display: none;']) !!}
                        {!! Form::close() !!}
                        &nbsp;&nbsp;
                        <a href="" class='btn btn-xs btn-danger'
                            onclick="
                                    if(confirm('@lang('Are you sure you want to delete this?')')) {
                                    event.preventDefault();
                                    $('#delete-form-{{$customer->id}}').submit();
                                    } else {
                                    event.preventDefault();
                                    }
                                    "
                            >@lang('Remove')</a>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>