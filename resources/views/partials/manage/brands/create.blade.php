<div class="col-md-4">
    @if(session()->has('brand_created'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('brand_created')}}</strong>
        </div>
    @endif

    @include('includes.form_errors')

    {!! Form::open(['method'=>'post', 'action'=>'ManageBrandsController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name', __('Name:')) !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter brand name'), 'required']) !!}
    </div>

    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
        {!! Form::label('priority', __('Priority:')) !!}
        {!! Form::number('priority', 1, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="show_in_menu"> <strong>@lang('Show in Main Menu')</strong>
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="show_in_footer"> <strong>@lang('Show in Footer Menu')</strong>
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="show_in_slider"> <strong>@lang('Show in Brands Slider')</strong>
        </label>
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', __('Status:')) !!}
        {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('photo', __('Choose photo'), ['class'=>'btn btn-default btn-file']) !!}
        {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
        <span class='label label-info' id="upload-file-info">@lang('No photo chosen')</span>
    </div>

    @include('partials.manage.meta-fields')

    <div class="form-group">
        {!! Form::submit(__('Add Brand'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
    </div>

    {!! Form::close() !!}

</div>