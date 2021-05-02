<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

        @if(session()->has('brand_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('brand_updated')}}</strong> <a target="_blank" href="{{route('front.brand.show', $brand->slug)}}">@lang('View')</a>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($brand->location)
                        {{$brand->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($brand, ['method'=>'patch', 'action'=>['ManageBrandsController@update', $brand->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        @if($brand->photo)
            <img src="{{$brand->photo->name}}" class="img-responsive" alt="Brand">
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
            {!! Form::text('name', $brand->name, ['class'=>'form-control', 'placeholder'=>__('Enter brand name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_menu" @if($brand->show_in_menu) checked @endif> <strong>@lang('Show in Main Menu')</strong>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_footer" @if($brand->show_in_footer) checked @endif> <strong>@lang('Show in Footer Menu')</strong>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_slider" @if($brand->show_in_slider) checked @endif> <strong>@lang('Show in Brands Slider')</strong>
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $brand->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo', __('Choose photo'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-info">@lang('No photo chosen')</span>
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>