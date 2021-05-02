<div class="row">
    <div class="col-xs-12 col-sm-8">

        @if(session()->has('page_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('page_updated')}}</strong> <a target="_blank" href="{{route('front.page.show', $page->slug)}}">@lang('View Page')</a>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($page, ['method'=>'patch', 'action'=>['ManagePagesController@update', $page->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', __('Title:')) !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>__('Enter page title'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            {!! Form::label('content', __('Content:')) !!}
            {!! Form::textarea('content', null, ['class'=>'form-control', 'placeholder'=>__('Enter page content')]) !!}
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_menu" @if($page->show_in_menu) checked @endif> <strong>@lang('Show in Main Menu')</strong>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_footer" @if($page->show_in_footer) checked @endif> <strong>@lang('Show in Footer Menu')</strong>
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $page->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>