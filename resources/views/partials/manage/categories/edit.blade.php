<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

        @if(session()->has('category_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('category_updated')}}</strong> <a target="_blank" href="{{route('front.category.show', $category->slug)}}">@lang('View')</a>
            </div>
        @endif

        @include('includes.form_errors')
        
        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($category->location)
                        {{$category->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($category, ['method'=>'patch', 'action'=>['ManageCategoriesController@update', $category->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

            @if($category->photo)
                <img src="{{$category->photo->name}}" class="img-responsive" alt="Category">
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

            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                {!! Form::label('name', __('Category Name:')) !!}
                {!! Form::text('name', $category->name, ['class'=>'form-control', 'placeholder'=>__('Enter category name'), 'required'])!!}
            </div>

            <div class="category_box form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                <label for="parent">@lang('Parent Category:')</label>
                <select id="parent" name="parent" class="form-control selectpicker" data-style='btn-default'>
                    <option value="0">@lang('None')</option>
                    @foreach($root_categories as $parent)
                        @if(count($parent->categories) > 0)
                            @if(!in_array($parent->id, $ignore_ids))
                                <option {{$category->category_id == $parent->id ? "selected" : ""}} class="bolden" value="{{$parent->id}}">{{$parent->name}} (@lang('ID:') {{$parent->id}})</option>
                            @endif
                            @include('partials.manage.subcategories-edit-select', ['childs' => $parent->categories, 'space'=>1, 'ignore_ids'=>$ignore_ids, 'id'=>$category->category_id])
                        @else
                            @if(!in_array($parent->id, $ignore_ids))
                                <option {{$category->category_id == $parent->id ? "selected" : ""}} value="{{$parent->id}}">{{$parent->name}} (@lang('ID:') {{$parent->id}})</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="specification_type_box">
                    <label for="specification_type[]">@lang('Select Specifications:')</label>
                    <select style="display:none" name="specification_type[]" id="specification_type[]" multiple>
                        @foreach($specification_types as $specification_type)
                            @if($category->specificationTypes->contains($specification_type->id))
                                <option selected value="{{$specification_type->id}}">{{$specification_type->name}}</option>
                            @else                        
                                <option value="{{$specification_type->id}}">{{$specification_type->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                {!! Form::label('priority', __('Priority:')) !!}
                {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="show_in_menu" @if($category->show_in_menu) checked @endif> <strong>@lang('Show in Main Menu')</strong>
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="show_in_footer" @if($category->show_in_footer) checked @endif> <strong>@lang('Show in Footer Menu')</strong>
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="show_in_slider" @if($category->show_in_slider) checked @endif> <strong>@lang('Show in Categories Slider')</strong>
                </label>
            </div>

            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                {!! Form::label('status', __('Status:')) !!}
                {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $category->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
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