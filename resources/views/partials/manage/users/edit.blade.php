<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6">

        @if(session()->has('user_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('user_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($user->location)
                        {{$user->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($user, ['method'=>'patch', 'action'=>['ManageUsersController@update', $user->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

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

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', __('Email:')) !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter email'), 'required']) !!}
        </div>

        @if($user->id !== 1)
        <div class="form-group">
            {!! Form::label('role', __('Role:')) !!}
            {!! Form::select('role', ['0'=>__('None')] + $roles, $user->role_id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @if(!$user->role)
            <div class="checkbox">
                <label for="remove_staff"><input type="checkbox" name="remove_staff" id="remove_staff"><strong class="text-danger">@lang('Remove Staff')</strong></label>
            </div>
        @endif

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
            {!! Form::submit(__('Update User'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>