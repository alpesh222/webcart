<div class="col-md-8">
    @if(session()->has('section_created'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('section_created')}}</strong>
        </div>
    @endif

    @include('includes.form_errors')

    {!! Form::open(['method'=>'post', 'action'=>'ManageSectionsController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        {!! Form::label('content', __('Content:')) !!}
        {!! Form::textarea('content', null, ['class'=>'form-control', 'rows'=>12, 'placeholder'=>__('Enter section content')]) !!}
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox"
                name="full_width"
                checked
            >
                <strong>@lang('Full Width Content')</strong>
        </label>
    </div>

    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
        {!! Form::label('priority', __('Priority:')) !!}
        {!! Form::number('priority', 1, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('position', __('Show in Home Page:')) !!}
        {!! Form::select('position', [
            null=>__('None'),
            'Above Main Slider'=>__('Above Main Slider'),
            'Below Main Slider'=>__('Below Main Slider'),
            'Above Deal Slider'=>__('Above Deal Slider'),
            'Below Deal Slider'=>__('Below Deal Slider'),
            'Above Footer'=>__('Above Footer'),
            'Above Side Banners'=>__('Above Side Banners'),
            'Below Side Banners'=>__('Below Side Banners')
        ], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
        {!! Form::label('brand', __('Show in Brand:')) !!}
        {!! Form::select('brand', [''=>__('None')] + $brands, null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('position_brand', __('Position in Brand Page:')) !!}
        {!! Form::select('position_brand', [
            null=>'None',
            'Above Main Slider'=>__('Above Main Slider'),
            'Below Main Slider'=>__('Below Main Slider'),
            'Above Side Banners'=>__('Above Side Banners'),
            'Below Side Banners'=>__('Below Side Banners'),
            'Above Footer'=>__('Above Footer')
        ], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
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
        {!! Form::select('position_category', [
            null=>'None',
            'Above Main Slider'=>__('Above Main Slider'),
            'Below Main Slider'=>__('Below Main Slider'),
            'Above Side Banners'=>__('Above Side Banners'),
            'Below Side Banners'=>__('Below Side Banners'),
            'Above Footer'=>__('Above Footer')
        ], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', __('Status:')) !!}
        {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit(__('Add Section'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
    </div>

    {!! Form::close() !!}

</div>