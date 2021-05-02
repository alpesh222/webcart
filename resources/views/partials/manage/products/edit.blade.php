<div class="row">
    <div class="col-xs-12 col-sm-8">

        @if(session()->has('product_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('product_updated')}}</strong> <a target="_blank" href="{{route('front.product.show', $product->slug)}}">@lang('View')</a>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:')
                <strong>
                    @if($product->location)
                        {{$product->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($product, ['method'=>'patch', 'action'=>['ManageProductsController@update', $product->id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        @if($product->photo)
                @if($product->photo->name)
                    @php
                        $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 150);
                    @endphp
                    <img src="{{$image_url}}" class="img-responsive product-feature-image" alt="{{$product->name}}"  />
                @else
                    <img src="https://via.placeholder.com/150x150?text=No+Image" class="img-responsive product-feature-image" alt="{{$product->name}}" />
                @endif
            <div class="form-group">
                <div class="has-error">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remove_photo') !!} <strong>@lang('Remove Featured Image')</strong>
                        </label>
                    </div>
                </div>
            </div>
        @endif

        @if(count($product->photos) > 0)
            <div class="row">
            <hr>
            @foreach($product->photos as $photo)
                <div class="col-md-3">
                    @if($photo->name)
                        @php
                            $image_url = \App\Helpers\Helper::check_image_avatar($photo->name, 80);
                        @endphp
                        <img src="{{$image_url}}" class="img-responsive" alt="{{$product->name}}" width=80 height=80  />
                    @else
                        <img src="https://via.placeholder.com/80x80?text=No+Image" class="img-responsive" width=80 height=80 alt="{{$product->name}}" />
                    @endif
                    <div class="checkbox">
                        <label>
                            <input name="remove_images[]" type="checkbox" value="{{$photo->id}}"> <strong>@lang('Remove')</strong>
                        </label>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
        <hr>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', __('Description:')) !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter description')]) !!}
        </div>

        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
            {!! Form::label('model', __('Model Name / Version:')) !!}
            {!! Form::text('model', null, ['class'=>'form-control', 'placeholder'=>__('Enter model number / version')])!!}
        </div>

        <div class="form-group{{ $errors->has('regular_price') ? ' has-error' : '' }}">
            {!! Form::label('regular_price', __('Regular Price:')) !!}
            {!! Form::number('regular_price', $product->old_price, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter regular price')]) !!}
        </div>

        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            {!! Form::label('price', __('Base Selling Price:')) !!}
            {!! Form::number('price', null, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter selling price'), 'required']) !!}
        </div>

        <div class="variants">
            <div class="variants-field">
            @if(count($variants))
                @foreach($variants as $key => $variant)
                        @php
                            $class = '';
                            $checked = 0;
                            if (isset($variant['c'])){
                                if(strtoupper($variant['c']) == '1'):
                                    $class = 'colorPickSelector';
                                    $checked = 1;
                                endif;
                            }
                        @endphp
                <div class="form-group variant-field-row well">
                    <label class="variant_name"><strong>@lang('Variant Name')</strong>
                    &nbsp;<span class="remove_variant text-danger" type="button">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </span>
                        <span class="custom_prod_var_span">
                            <input required class="form-control variant_name_value" type="text" name="variant[{{$key+1}}]" value="{{$variant['n']}}">
                            <label>
                                <input type="checkbox" onchange="checkColorVariation(this.id)" {{$checked == 1 ? 'checked' : '' }} id="variant_{{$key+1}}"> @lang('is this Color Variation')
                                <input type="hidden" name="is_color[{{$key+1}}]" value="{{$checked}}" id="is_color_variant_{{$key+1}}" >
                            </label>
                        </span>

                    </label>
                    <div class="variant-field-values">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Additional Cost')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variant['v'] as $value)
                                <tr>
                                    <td>
                                        <input class="form-control  {{$class}}" required placeholder="" name="variant_v[{{$key+1}}][]" type="text" value="{{$value['n']}}" autocomplete="off">
                                    </td>
                                    <td>
                                        <input class="form-control" required placeholder="" name="variant_p[{{$key+1}}][]" type="number" step="any" min="0" value="{{$value['p']}}">
                                    </td>
                                    <td>
                                        <button class="remove_variant_value btn btn-danger btn-xs" type="button">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <button class="add_variant_value btn btn-success btn-xs" type="button">
                                            @lang("Add More")
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            @endif
            </div>
            <button type="button" data-count="{{count($variants)}}" id="add-variant" class="btn btn-sm btn-primary">@lang('Add Variant')</button>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-inline form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                    {!! Form::label('sku', __('SKU:')) !!}<br>
                    {{$vendor_prefix ? __('Vendor Prefix:'). $vendor_prefix . "-" : ""}} {!! Form::text('sku', $sku, ['class'=>'form-control', 'placeholder'=>__('Enter sku')])!!}
                </div>
            </div>

            <div class="col-md-6 text-right">
                <div class="form-inline form-group{{ $errors->has('hsn') ? ' has-error' : '' }}">
                    {!! Form::label('hsn', 'HSN:') !!}<br>
                    {{$vendor_prefix ? __('Vendor Prefix:'). $vendor_prefix . "-" : ""}} {!! Form::text('hsn', $hsn, ['class'=>'form-control', 'placeholder'=>__('Enter hsn')])!!}
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('tax_rate') ? ' has-error' : '' }}">
            {!! Form::label('tax_rate', __('Tax Rate:')) !!}
            {!! Form::number('tax_rate', null, ['class'=>'form-control', 'step'=>'any', 'min'=>0, 'max'=>100, 'placeholder'=>__('Enter tax rate'), 'required']) !!}
        </div>

        <div class="brand_box form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
            {!! Form::label('brand', __('Brand:')) !!}
            {!! Form::select('brand', [''=>__('None')] + $brands, $product->brand_id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @if(count($root_categories) > 0)
            <hr>
            <div>@lang('Category:') @if(!$product->category) <span class="label label-lg label-primary">@lang('None')</span> @else <strong>{{ $product->category->name }} (@lang('ID:') {{ $product->category->id }})@endif</strong></div>
            <ul id="tree1">
                @foreach($root_categories as $category)
                    <li>
                        @if($product->category_id == $category->id)
                            {{ $category->name }} (@lang('ID:') {{ $category->id }}) <span class="glyphicon glyphicon-ok"></span><small><span class="text-muted"> (@lang('Root'))</span></small>
                        @else
                            {{ $category->name }} (@lang('ID:') {{ $category->id }})
                        @endif
                        @if(count($category->categories))
                            @include('partials.manage.product-edit-subcategories', ['childs' => $category->categories, 'product_category_id'=> $product->category_id])
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if($product->category)
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remove_category"> <strong class="text-danger">@lang('Remove Category')</strong>
                </label>
            </div>
        @endif

        <div class="category_box form-group{{ $errors->has('category') ? ' has-error' : '' }}">
            <label for="category">@lang('Change Category:')</label>
            <select id="category" name="category" class="form-control selectpicker" data-style='btn-default'>
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

        <div class="category_box form-group{{ $errors->has('comp_group') ? ' has-error' : '' }}">
            <label for="comp_group">@lang('Comparision Group:')</label>
            <select id="comp_group" name="comp_group" class="form-control selectpicker" data-style='btn-default'>
                <option value="">@lang('Choose Option')</option>
                @foreach($comparision_groups as $item)
                    <option value="{{$item->cg_id}}" {{$product->comp_group_id == $item->cg_id ? 'selected ' : ''}} >{{$item->title}} (@lang('ID:') {{$item->cg_id}})</option>
                @endforeach
            </select>
        </div>

        <div class="specification_types_box">
            <table id="specification_types_box" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Specification Type')</th>
                        <th>@lang('Value')</th>
                        <th>@lang('Unit')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="specification_types_rows">
                    @if(count($product->specificationTypes) > 0)
                    @foreach($product->specificationTypes as $product_specification_type)
                    <tr>
                        <td>
                            {!! Form::select('specification_type[]', $specification_types, $product_specification_type->id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </td>
                        <td>
                            {!! Form::text('specification_type_value[]', $product_specification_type->pivot->value, ['class'=>'form-control', 'placeholder'=>__('Example: 14, 3.5, red')])!!}
                        </td>
                        <td>
                            {!! Form::text('specification_type_unit[]', $product_specification_type->pivot->unit, ['class'=>'form-control', 'placeholder'=>__('kg, GHz (Leave blank if no unit)')])!!}
                        </td>
                        <td>
                            <button class="remove_row btn btn-danger btn-xs" type="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            {!! Form::select('specification_type[]', $specification_types, null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </td>
                        <td>
                            {!! Form::text('specification_type_value[]', null, ['class'=>'form-control', 'placeholder'=>__('Example: 14, 3.5')])!!}
                        </td>
                        <td>
                            {!! Form::text('specification_type_unit[]', null, ['class'=>'form-control', 'placeholder'=>__('Example: inch, kg')])!!}
                        </td>
                        <td>
                            <button class="remove_row btn btn-danger btn-xs" type="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="text-right">
                <button type="button" id="add-more-specification" class="btn btn-success btn-sm">@lang('Add More')</button>
            </div>
        </div>
        <br>

        <div class="custom_fields_box">
            <label for="custom_fields_box">@lang('Custom Fields:')</label>
            <table id="custom_fields_box" class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Value')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="custom_fields_rows">
                    @if(count($custom_fields = unserialize($product->custom_fields)) > 0 && is_array($custom_fields))
                    @foreach($custom_fields as $key => $field)
                    <tr>
                        <td>
                            {!! Form::text('custom_field_name[]', $key, ['class'=>'form-control', 'placeholder'=>__('Name')])!!}
                        </td>
                        <td>
                            {!! Form::text('custom_field_value[]', $field, ['class'=>'form-control', 'placeholder'=>__('Value')])!!}
                        </td>
                        <td>
                            <button class="remove_row btn btn-danger btn-xs" type="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            {!! Form::text('custom_field_name[]', null, ['class'=>'form-control', 'placeholder'=>__('Name')])!!}
                        </td>
                        <td>
                            {!! Form::text('custom_field_value[]', null, ['class'=>'form-control', 'placeholder'=>__('Value')])!!}
                        </td>
                        <td>
                            <button class="remove_row btn btn-danger btn-xs" type="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="text-right">
                <button type="button" id="add-more-field" class="btn btn-success btn-sm">@lang('Add More')</button>
            </div>
        </div>
        <br>

        <div class="checkbox row">
            <div class="col-md-4 col-xs-6">
                <label>
                    <input type="checkbox" name="downloadable" id="downloadable"
                    @if($product->downloadable)
                        checked
                    @endif
                    > <strong>@lang('Downloadable')</strong>
                </label>
            </div>
            <div class="col-md-4 col-xs-6">
                <label>
                    <input type="checkbox" name="virtual" id="virtual"
                    @if($product->virtual)
                        checked
                    @endif
                    > <strong>@lang('Virtual Product')</strong>
                </label>
            </div>
        </div>

        @if($product->file)
            <div>
                <a role="link" class="btn btn-link" href="{{route('manage.download', [$product->file->filename])}}">{{$product->file->original_filename}}</a>
            </div>
            <div class="form-group">
                <div class="has-error">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remove_file', null, null, ['id'=>'remove_file']) !!} <strong>@lang('Remove Current File / Choose New File')</strong>
                        </label>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group" id="downloadable-file">
            {!! Form::label('file', __('Choose File In Zip'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('file',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-name").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-name">@lang('No file chosen')</span>
        </div>

        <div class="product-quantity">
            <div class="form-group{{ $errors->has('in_stock') ? ' has-error' : '' }}">
                {!! Form::label('in_stock', __('Number in Stock:')) !!}
                {!! Form::number('in_stock', null, ['class'=>'form-control', 'placeholder'=>__('Enter number in stock')]) !!}
            </div>

            <div class="form-group{{ $errors->has('qty_per_order') ? ' has-error' : '' }}">
                {!! Form::label('qty_per_order', __('Maximum allowed Quantity per Order:')) !!}
                {!! Form::number('qty_per_order', null, ['class'=>'form-control', 'placeholder'=>__('Enter maximum allowed quantity per order')]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="product_box">
                <label for="product[]">@lang('Related Products:')</label>
                <select style="display:none" name="product[]" id="product[]" multiple>
                    @foreach($products as $related_product)
                        @if($product->related_products->contains($related_product->id))
                            <option selected value="{{$related_product->id}}">{{$related_product->name}} {{'(' . __('ID:') . ' '.$related_product->id.')'}}</option>
                        @else
                            <option value="{{$related_product->id}}">{{$related_product->name}} {{'(' . __('ID:') . ' '.$related_product->id.')'}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $product->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo', __('Choose Featured Image'), ['class'=>'btn btn-default btn-file']) !!}
            {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
            <span class='label label-info' id="upload-file-info">@lang('No image chosen')</span>
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>

<hr>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <label>@lang('Upload more images for this product')</label>
        {!! Form::model($product, ['method'=>'patch', 'action'=>['ManageProductsController@storeMoreImages', $product->id], 'class'=>'dropzone']) !!}
        {!! Form::close() !!}
    </div>
</div>
