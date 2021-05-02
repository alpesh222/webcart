<div class="col-md-8">
    @if(session()->has('banner_created'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('banner_created')}}</strong>
        </div>
    @endif

    @include('includes.form_errors')

    {!! Form::open(['method'=>'post', 'action'=>'ManageBannersController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::label('title', __('Title / Alt Image Text:')) !!}
        {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>__('Enter banner title')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('photo', __('Choose Banner Image'), ['class'=>'btn btn-default btn-file']) !!}
        {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
        <span class='label label-info' id="upload-file-info">@lang('No image chosen')</span>
    </div>

    <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
        {!! Form::label('link', __('URL Link:')) !!}
        {!! Form::text('link', null, ['class'=>'form-control', 'placeholder'=>__('Enter URL link')]) !!}
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        {!! Form::label('description', __('Description:')) !!}
        {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter banner description')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('position', __('Show in Home Page:')) !!}
        {!! Form::select('position', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Right Side'=>__('Right Side'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
        {!! Form::label('brand', __('Show in Brand:')) !!}
        {!! Form::select('brand', [''=>__('None')] + $brands, null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('position_brand', __('Position in Brand Page:')) !!}
        {!! Form::select('position_brand', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout'), 'Below Filters'=>__('Below Filters')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
        <label for="category">@lang('Show in Category:')</label>
        <select id="category" name="category" class="form-control selectpicker" data-style='btn-default'>
            <option value="">@lang('None')</option>
            @foreach($root_categories as $category)
                @if(count($category->categories) > 0)
                    <option class="bolden" value="{{$category->id}}">{{$category->name}}</option>
                    @include('partials.manage.subcategories-select', ['childs' => $category->categories, 'space'=>1])
                @else
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {!! Form::label('position_category', __('Position in Category Page:')) !!}
        {!! Form::select('position_category', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout'), 'Below Filters'=>__('Below Filters')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
        {!! Form::label('priority', __('Priority:')) !!}
        {!! Form::number('priority', 1, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', __('Status:')) !!}
        {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit(__('Add Banner'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
    </div>

    {!! Form::close() !!}

</div>