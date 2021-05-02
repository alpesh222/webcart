<div class="row">
    <div class="col-md-10">

        @if(session()->has('section_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('section_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($section->location)
                        {{$section->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        <a href="{{route('manage.settings.css')}}">@lang('Apply CSS to this section')</a>
        <div class="text-muted">@lang('CSS Selector:') <span class="text-primary">@lang('#section-id-'){{$section->id}}</span></div>
        <hr>
        

        {!! Form::model($section, ['method'=>'patch', 'action'=>['ManageSectionsController@update', $section->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            {!! Form::label('content', __('Content:')) !!}
            {!! Form::textarea('content', null, ['class'=>'form-control', 'rows'=>12, 'placeholder'=>__('Enter section content')]) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox"
                    name="full_width"
                    @if($section->full_width)
                        checked
                    @endif
                >
                    <strong>@lang('Full Width Content')</strong>
            </label>
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('position', __('Show in Home Page:')) !!}
            {!! Form::select('position', [
                null=>'None',
                'Above Main Slider'=>__('Above Main Slider'),
                'Below Main Slider'=>__('Below Main Slider'),
                'Above Deal Slider'=>__('Above Deal Slider'),
                'Below Deal Slider'=>__('Below Deal Slider'),
                'Above Footer'=>__('Above Footer'),
                'Above Side Banners'=>__('Above Side Banners'),
                'Below Side Banners'=>__('Below Side Banners')
            ], $section->position, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
            {!! Form::label('brand', __('Show in Brand:')) !!}
            {!! Form::select('brand', [''=>__('None')] + $brands, $section->brand_id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('position_brand', __('Position in Brand Page:')) !!}
            {!! Form::select('position_brand', [
                null=>__('None'),
                'Above Main Slider'=>__('Above Main Slider'),
                'Below Main Slider'=>__('Below Main Slider'),
                'Above Side Banners'=>__('Above Side Banners'),
                'Below Side Banners'=>__('Below Side Banners'),
                'Above Footer'=>__('Above Footer')
            ], $section->position_brand, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @if(count($categories) > 0)
            <div>@lang('Show in Category:') @if($section->category_id == 0) <span class="label label-lg label-primary">@lang('None')</span>@endif</div>
            <ul id="tree1">
                @foreach($categories as $category)
                    <li>
                        @if($section->category_id == $category->id)
                            {{ $category->name }} <span class="glyphicon glyphicon-ok"></span><small><span class="text-muted"> (@lang('Root')</span></small>
                        @else
                            {{ $category->name }}
                        @endif
                        @if(count($category->categories))
                            @include('partials.manage.product-edit-subcategories', ['childs' => $category->categories, 'product_category_id'=> $section->category_id])
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if($section->category)
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remove_category"> @lang('Remove Category')
                </label>
            </div>
        @endif

        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
            <label for="category">@lang('Change Category:')</label>
            <select id="category" name="category" class="form-control selectpicker" data-style='btn-default'>
                <option value="0">@lang('None')</option>
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
            ], $section->position_category, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $section->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>