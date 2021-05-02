<div class="row">
    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageProductsController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group existing_product_box">
            {!! Form::label('existing_product', __('From Existing Product:')) !!}
            <select class="form-control selectpicker" data-style="btn-default" name="existing_product" id="existing_product">
                <option value="">@lang('Choose Product')</option>
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}} ( @lang('ID:') {{$product->id}})</option>
                @endforeach
            </select>
        </div>
        <div id="existing_product_message"></div>
        <hr>

        <div id="fetch_existing_product">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', __('Product Name:')) !!}
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
                {!! Form::number('regular_price', null, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter regular price')]) !!}
            </div>

            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', __('Base Selling Price:')) !!}
                {!! Form::number('price', null, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>__('Enter selling price'), 'required']) !!}
            </div>

            <div class="variants">
                <div class="variants-field"></div>
                <button type="button" id="add-variant" class="btn btn-sm btn-primary">@lang('Add Variant')</button>
            </div>

            <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                {!! Form::label('sku', __('SKU:')) !!}
                {!! Form::text('sku', null, ['class'=>'form-control', 'placeholder'=>__('Enter sku')])!!}
            </div>

            <div class="form-group{{ $errors->has('hsn') ? ' has-error' : '' }}">
                {!! Form::label('hsn', __('HSN:')) !!}
                {!! Form::text('hsn', null, ['class'=>'form-control', 'placeholder'=>__('Enter hsn')])!!}
            </div>

            <div class="form-group{{ $errors->has('tax_rate') ? ' has-error' : '' }}">
                {!! Form::label('tax_rate', __('Tax Rate:')) !!}
                {!! Form::number('tax_rate', 0, ['class'=>'form-control', 'step'=>'any', 'min'=>0, 'max'=>100, 'placeholder'=>__('Enter tax rate'), 'required']) !!}
            </div>
            <input type="hidden" class="colorPickSelector" style="display: none;">
            <div class="brand_box form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
                {!! Form::label('brand', __('Brand:')) !!}
                {!! Form::select('brand', [''=>__('Choose Option')] + $brands, null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
            </div>

            @if(count($root_categories) > 0)
                <hr>
                <strong>@lang('Categories Tree:')</strong>
                <ul id="tree1">
                    @foreach($root_categories as $category)
                        <li>
                            {{ $category->name . ' (' . __('ID:') . ' '.$category->id.')' }}
                            @if(count($category->categories))
                                @include('partials.manage.subcategories', ['childs' => $category->categories])
                            @endif
                        </li>
                    @endforeach
                </ul>
                <br>
            @endif

            <div class="category_box form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                <label for="category">@lang('Category:')</label>
                <select id="category" name="category" class="form-control selectpicker" data-style='btn-default'>
                    <option value="">@lang('Choose Option')</option>
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
                            <option value="{{$item->cg_id}}">{{$item->title}} (@lang('ID:') {{$item->cg_id}})</option>
                    @endforeach
                </select>
            </div>

            <div id="get-specifications"></div>

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
                        <tr>
                            <td>
                                {!! Form::select('specification_type[]', $specification_types, null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                            </td>
                            <td>
                                {!! Form::text('specification_type_value[]', null, ['class'=>'form-control', 'placeholder'=>__('Example: 14, 3.5, red')])!!}
                            </td>
                            <td>
                                {!! Form::text('specification_type_unit[]', null, ['class'=>'form-control', 'placeholder'=>__('kg, GHz (Leave blank if no unit)')])!!}
                            </td>
                            <td>
                                <button class="remove_row btn btn-danger btn-xs" type="button">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                            </td>
                        </tr>
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
                        @if(old('downloadable'))
                            checked
                        @endif
                        > <strong>@lang('Downloadable')</strong>
                    </label>
                </div>
                <div class="col-md-4 col-xs-6">
                    <label>
                        <input type="checkbox" name="virtual" id="virtual" 
                        @if(old('virtual'))
                            checked
                        @endif
                        > <strong>@lang('Virtual Product')</strong>
                    </label>
                </div>
            </div>

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
                            <option value="{{$related_product->id}}">{{$related_product->name}} {{'(' . __('ID:') . ' '.$related_product->id.')'}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('status', __('Status:')) !!}
                {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('photo', __('Choose Featured Image'), ['class'=>'btn btn-default btn-file']) !!}
                {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
                <span class='label label-info' id="upload-file-info">@lang('No image chosen')</span>
            </div>

            <div class="form-group">
                {!! Form::label('photos[]', __('Choose More Images'), ['class'=>'btn btn-default btn-file']) !!}
                {!! Form::file('photos[]',['class'=>'form-control', 'multiple', 'style'=>'display: none;','onchange'=>'$("#upload-files-info").html(moreImagesNames(files))']) !!}
                <span class='label label-info' id="upload-files-info">@lang('No image chosen')</span>
                <strong>(@lang('Hold Ctrl to select multiple images'))</strong>
            </div>

            @include('partials.manage.meta-fields')

        </div>

        <div class="form-group">
            {!! Form::submit(__('Add Product'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>