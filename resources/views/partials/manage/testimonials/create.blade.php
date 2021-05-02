<div class="row">

    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageTestimonialsController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
            {!! Form::label('author', __('Author:')) !!}
            {!! Form::text('author', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's name"), 'required']) !!}
        </div>

        <div class="form-group{{ $errors->has('designation') ? ' has-error' : '' }}">
            {!! Form::label('designation', __('Designation:')) !!}
            {!! Form::text('designation', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's designation")]) !!}
        </div>

        <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
            {!! Form::label('review', __('Review:')) !!}
            {!! Form::textarea('review', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's review"), 'required']) !!}
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', 1, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo', __('Choose photo'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-info">@lang('No photo chosen')</span>
        </div>

        <div class="form-group">
            {!! Form::submit(__('Add Testimonial'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>