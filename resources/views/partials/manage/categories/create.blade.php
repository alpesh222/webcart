<div class="col-md-6">
    @if(session()->has('category_created'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('category_created')}}</strong>
        </div>
    @endif

    @include('includes.form_errors')

    {!! Form::open(['method'=>'post', 'action'=>'ManageCategoriesController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
        {!! Form::label('name', __('Category Name:')) !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter category name'), 'required']) !!}
    </div>

    <div class="category_box form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
        <label for="parent">@lang('Parent Category:')</label>
        <select id="parent" name="parent" class="form-control selectpicker" data-style='btn-default'>
            <option value="0">@lang('None')</option>
            @foreach($root_categories as $category)
                @if(count($category->categories) > 0)
                    <option class="bolden" value="{{$category->id}}">{{$category->name}} (@lang('ID:') {{$category->id}})</option>
                    @include('partials.manage.subcategories-select', ['childs' => $category->categories, 'space'=>1])
                @else
                    <option value="{{$category->id}}">{{$category->name}} (@lang('ID:') {{$category->id}})</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <div class="specification_type_box">
            <label for="specification_type[]">@lang('Select Specifications:')</label>
            <select style="display:none" name="specification_type[]" id="specification_type[]" multiple>
                @foreach($specification_types as $specification_type)
                    <option value="{{$specification_type->id}}">{{$specification_type->name}}</option>
                @endforeach
            </select>
        </div>
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
            <input type="checkbox" name="show_in_slider"> <strong>@lang('Show in Categories Slider')</strong>
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
        {!! Form::submit(__('Add Category'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
    </div>

    {!! Form::close() !!}

</div>