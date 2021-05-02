<div class="row">
    <div class="col-md-10">

        @if(session()->has('banner_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('banner_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:')
                <strong>
                    @if($banner->location)
                        {{$banner->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($banner, ['method'=>'patch', 'action'=>['ManageBannersController@update', $banner->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        @if($banner->photo)
            @if($banner->photo->name)
                @php
                    $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 200, '' , 150);
                @endphp
                <img src="{{$image_url}}" class="img-responsive" alt="{{$banner->title}}"  />
            @else
                <img src="https://via.placeholder.com/200x150?text=No+Image" class="img-responsive" alt="{{$banner->title}}" />
            @endif
            <div class="form-group">
                <div class="has-error">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remove_photo') !!} <strong>@lang('Remove Banner Image')</strong>
                        </label>
                    </div>
                </div>
            </div>
        @endif

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
            {!! Form::select('position', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Right Side'=>__('Right Side'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout')], $banner->position, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
            {!! Form::label('brand', __('Show in Brand:')) !!}
            {!! Form::select('brand', [''=>__('None')] + $brands, $banner->brand_id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('position_brand', __('Position in Brand Page:')) !!}
            {!! Form::select('position_brand', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout'), 'Below Filters'=>__('Below Filters')], $banner->position_brand, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @if(count($categories) > 0)
            <div>@lang('Show in Category:') @if($banner->category_id == 0) <span class="label label-lg label-primary">@lang('None')</span>@endif</div>
            <ul id="tree1">
                @foreach($categories as $category)
                    <li>
                        @if($banner->category_id == $category->id)
                            {{ $category->name }} <span class="glyphicon glyphicon-ok"></span><small><span class="text-muted"> (@lang('Root'))</span></small>
                        @else
                            {{ $category->name }}
                        @endif
                        @if(count($category->categories))
                            @include('partials.manage.product-edit-subcategories', ['childs' => $category->categories, 'product_category_id'=> $banner->category_id])
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if($banner->category)
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
            {!! Form::select('position_category', [null=>__('None'), 'Main Slider'=>__('Main Slider'), 'Below Main Slider'=>__('Below Main Slider - Three Images per row'), 'Below Main Slider - Two Images per row'=>__('Below Main Slider - Two Images per row'), 'Below Main Slider - Three Images Layout'=>__('Below Main Slider - Three Images Layout'), 'Below Filters'=>__('Below Filters')], $banner->position_category, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $banner->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>