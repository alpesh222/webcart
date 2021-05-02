<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6">

        @if(session()->has('language_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('language_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($user, ['method'=>'patch', 'action'=>['ManageSettingsController@updateProfile'], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update Language'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>