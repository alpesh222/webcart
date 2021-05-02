<div class="row">

    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManagePagesController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', __('Page Title:')) !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>__('Enter page title'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            {!! Form::label('content', __('Content:')) !!}
            {!! Form::textarea('content', null, ['class'=>'form-control', 'placeholder'=>__('Enter page content')]) !!}
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

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Add Page'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>