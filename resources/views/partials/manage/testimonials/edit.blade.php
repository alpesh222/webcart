<div class="row">
    <div class="col-xs-12 col-sm-8">

        @if(session()->has('testimonial_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('testimonial_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($testimonial, ['method'=>'patch', 'action'=>['ManageTestimonialsController@update', $testimonial->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        @if($testimonial->photo)
                @if($testimonial->photo->name)
                    @php
                        $image_url = \App\Helpers\Helper::check_image_avatar($testimonial->photo->name, 100);
                    @endphp
                    <img src="{{$image_url}}" class="img-responsive" alt="{{$testimonial->author}}"  />
                @else
                    <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-responsive" alt="{{$testimonial->author}}" />
                @endif
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

        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
            {!! Form::label('author', __('Author:')) !!}
            {!! Form::text('author', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's name"), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('designation') ? ' has-error' : '' }}">
            {!! Form::label('designation', __('Designation:')) !!}
            {!! Form::text('designation', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's designation")])!!}
        </div>

        <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
            {!! Form::label('review', __('Review:')) !!}
            {!! Form::textarea('review', null, ['class'=>'form-control', 'placeholder'=>__("Enter author's review"), 'required']) !!}
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $testimonial->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo', __('Choose photo'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-info">@lang('No photo chosen')</span>
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>