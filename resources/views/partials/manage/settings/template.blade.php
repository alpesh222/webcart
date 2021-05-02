<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6">

        @if(session()->has('template_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('template_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')
            @if(session()->has('template_not_updated'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('template_not_updated')}}
                </div>
            @endif

        {!! Form::open(['method'=>'patch', 'action'=>['ManageAppSettingsController@updateTemplate'], 'files'=>true, 'id'=>'update-template-form', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

            <h2 class="text-primary">@lang('Please select data to import')</h2>
            <h4 class="text-danger">
                @lang('*Important Note :') @lang('Importing Demo data will override your old data !')
            </h4>

            <div class="form-group">
                {!! Form::radio('demo_template', 'default', ['class'=>'form-control'])!!}
                {!! Form::label('demo_template', __('Reset to default state') ) !!}
            </div>
            <div class="form-group">
                {!! Form::radio('demo_template', 'template_1', ['class'=>'form-control'])!!}
                {!! Form::label('demo_template', __('Demo Data') ) !!}
            </div>

            <div class="form-group">
                {!! Form::submit(__('Update Template'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button','onclick'=> 'updateTemplateConfirm()' ]) !!}
            </div>

        {!! Form::close() !!}

    </div>
</div>