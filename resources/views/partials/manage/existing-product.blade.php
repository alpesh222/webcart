<script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
@include('includes.tinymce')
<script>
    $('.product_box').dropdown({
        // options here
    });
    $('#add-more-specification').click(function() {
        $('.specification_types_rows > tr:first').clone().appendTo('.specification_types_rows');
    });
    $('#specification_types_box').on('click', '.remove_row', function() {
        var rowCount =  $('.specification_types_rows tr').length;
        if(rowCount > 1) {
            $(this).closest('tr').remove();
        }
    });

    $('#add-more-field').click(function() {
        $('.custom_fields_rows > tr:first').clone().appendTo('.custom_fields_rows');
    });
    $('#custom_fields_box').on('click', '.remove_row', function() {
        var rowCount =  $('.custom_fields_rows tr').length;
        if(rowCount > 1) {
            $(this).closest('tr').remove();
        }
    });

    var virtualProduct = $('#virtual');
    var productQuantity = $('.product-quantity');

    var downloadableProduct = $('#downloadable');
    var downloadableFile = $('#downloadable-file');

    if(!downloadableProduct.is(':checked')) {
        downloadableFile.hide();
    }

    if(virtualProduct.is(':checked')) {
        productQuantity.hide();
    }

    $(document).ready(function() {
        virtualProduct.on('change', function() {
            if(virtualProduct.is(':checked')) {
                productQuantity.fadeOut();
            } else {
                productQuantity.fadeIn();
            }  
        });

        downloadableProduct.on('change', function() {
            if(downloadableProduct.is(':checked')) {
                downloadableFile.fadeIn();
                downloadableFile.find('input[type=file]').filter(':first').attr('name', 'file');
            } else {
                downloadableFile.fadeOut();
                downloadableFile.find('input[type=file]').filter(':first').removeAttr('name');
            }
        });

        @if($product->category)
        $("#category").val("{{$product->category_id}}");
        @endif
    });

    var getSpecifications = $('#get-specifications');
    var category = $('#category');
    $(document).on('change', '#category', function() {
        category = this;
        if(this.value != 0) {
            getSpecifications.html('<button type="button" class="btn btn-xs btn-block" id="get-specifications-btn">Get Specifications for ' + $("#category option:selected").text() + '</button>');
        } else {
            getSpecifications.html("");
        }
    });

    $(document).on('click', '#get-specifications-btn', function() {
        $.get(APP_URL + '/manage/ajax/specifications/category/' + category.value, function(receivedData) {
            if(!receivedData.error) {
                if(receivedData.data.length != 0) {
                    
                    var specificationsHTML = '';

                    var options = '';
                    $.each(receivedData.more_specifications, function(key, value) {
                        options += '<option value="' +key+ '">'+value+'</option>';
                    })

                    receivedData.data.forEach(function(element) {
                        specificationsHTML += '<tr> <td> <select class="form-control selectpicker" data-style="btn-default" name="specification_type[]"><option value="' +element.id+ '">'+element.name+'</option>'+options+'</select> </td> <td> <input class="form-control" placeholder="Example: 14, 3.5, red" name="specification_type_value[]" type="text"> </td> <td> <input class="form-control" placeholder="kg, GHz (Leave blank if no unit)" name="specification_type_unit[]" type="text"> </td> <td> <button class="remove_row btn btn-danger btn-xs" type="button"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </button> </td> </tr>'
                    });
                    $('.specification_types_rows').html(specificationsHTML);
                } else {
                    $('<p class="text-danger">Specifications are not set for this category.</p>').insertAfter(getSpecifications).fadeOut(2500);
                }
            } else {
                $('<p class="text-danger">Error occured while fetching specifications for this category.</p>').insertAfter(getSpecifications).fadeOut(2500);
            }
        });
    });

    function moreImagesNames(files) {
        var fileNames = [];
        Object.keys(files).forEach(function(key) {
          var val = files[key]["name"];
          fileNames.push(val);
        });
        return fileNames.join(', ');
    }
</script>

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Product Name:') !!}
    {!! Form::text('name', $product->name, ['class'=>'form-control', 'placeholder'=>'Enter name', 'required'])!!}
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description','Description:') !!}
    {!! Form::textarea('description', $product->description, ['class'=>'form-control', 'placeholder'=>'Enter description']) !!}
</div>

<div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
    {!! Form::label('model', 'Model Name / Version:') !!}
    {!! Form::text('model', $product->model, ['class'=>'form-control', 'placeholder'=>'Enter model number / version'])!!}
</div>

<div class="form-group{{ $errors->has('regular_price') ? ' has-error' : '' }}">
    {!! Form::label('regular_price', 'Regular Price:') !!}
    {!! Form::number('regular_price', $product->old_price, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>'Enter regular price']) !!}
</div>

<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    {!! Form::label('price', 'Selling Price:') !!}
    {!! Form::number('price', $product->price, ['class'=>'form-control', 'step'=>'any', 'placeholder'=>'Enter selling price', 'required']) !!}
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
                              <script>
                                    checkColorVariation("variant_{{$key+1}}");
                              </script>
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

<div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
    {!! Form::label('sku', 'SKU:') !!}
    {!! Form::text('sku', $sku, ['class'=>'form-control', 'placeholder'=>'Enter sku'])!!}
</div>

<div class="form-group{{ $errors->has('hsn') ? ' has-error' : '' }}">
    {!! Form::label('hsn', 'HSN:') !!}
    {!! Form::text('hsn', $hsn, ['class'=>'form-control', 'placeholder'=>'Enter hsn'])!!}
</div>

<div class="form-group{{ $errors->has('tax_rate') ? ' has-error' : '' }}">
    {!! Form::label('tax_rate', 'Tax Rate:') !!}
    {!! Form::number('tax_rate', $product->tax_rate ? $product->tax_rate : 0, ['class'=>'form-control', 'step'=>'any', 'min'=>0, 'max'=>100, 'placeholder'=>'Enter tax rate', 'required']) !!}
</div>

<div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
    {!! Form::label('brand', 'Brand:') !!}
    {!! Form::select('brand', [''=>__('Choose Option')] + $brands, $product->brand_id, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
</div>

<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
    <label for="category">Category:</label>
    <select id="category" name="category" class="form-control selectpicker" data-style='btn-default'>
        <option value="">Choose Option</option>
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

<div id="get-specifications"></div>

<div class="specification_types_box">
    <table id="specification_types_box" class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>Specification Type</th>
                <th>Value</th>
                <th>Unit</th>
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
                    {!! Form::text('specification_type_value[]', $product_specification_type->pivot->value, ['class'=>'form-control', 'placeholder'=>'Example: 14, 3.5, red'])!!}
                </td>
                <td>
                    {!! Form::text('specification_type_unit[]', $product_specification_type->pivot->unit, ['class'=>'form-control', 'placeholder'=>'kg, GHz (Leave blank if no unit)'])!!}
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
                    {!! Form::text('specification_type_value[]', null, ['class'=>'form-control', 'placeholder'=>'Example: 14, 3.5'])!!}
                </td>
                <td>
                    {!! Form::text('specification_type_unit[]', null, ['class'=>'form-control', 'placeholder'=>'Example: inch, kg'])!!}
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
        <button type="button" id="add-more-specification" class="btn btn-success btn-sm">Add More</button>
    </div>
</div>
<br>

<div class="custom_fields_box">
    <label for="custom_fields_box">Custom Fields:</label>
    <table id="custom_fields_box" class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="custom_fields_rows">
            @if(count($custom_fields = unserialize($product->custom_fields)) > 0 && is_array($custom_fields))
            @foreach($custom_fields as $key => $field)
            <tr>
                <td>
                    {!! Form::text('custom_field_name[]', $key, ['class'=>'form-control', 'placeholder'=>'Name'])!!}
                </td>
                <td>
                    {!! Form::text('custom_field_value[]', $field, ['class'=>'form-control', 'placeholder'=>'Value'])!!}
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
                    {!! Form::text('custom_field_name[]', null, ['class'=>'form-control', 'placeholder'=>'Name'])!!}
                </td>
                <td>
                    {!! Form::text('custom_field_value[]', null, ['class'=>'form-control', 'placeholder'=>'Value'])!!}
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
        <button type="button" id="add-more-field" class="btn btn-success btn-sm">Add More</button>
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
            > <strong>Downloadable</strong>
        </label>
    </div>
    <div class="col-md-4 col-xs-6">
        <label>
            <input type="checkbox" name="virtual" id="virtual"
            @if($product->virtual)
                checked
            @endif
            > <strong>Virtual Product</strong>
        </label>
    </div>
</div>

<div class="form-group" id="downloadable-file">
    {!! Form::label('file', 'Choose File In Zip', ['class'=>'btn btn-default btn-file']) !!}
    {!! Form::file('file',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-name").html(files[0].name)']) !!}
    <span class='label label-info' id="upload-file-name">No file chosen</span>
</div>

<div class="product-quantity">
    <div class="form-group{{ $errors->has('in_stock') ? ' has-error' : '' }}">
        {!! Form::label('in_stock','Number in Stock:') !!}
        {!! Form::number('in_stock', $product->in_stock, ['class'=>'form-control', 'placeholder'=>'Enter number in stock']) !!}
    </div>

    <div class="form-group{{ $errors->has('qty_per_order') ? ' has-error' : '' }}">
        {!! Form::label('qty_per_order','Maximum allowed Quantity per Order:') !!}
        {!! Form::number('qty_per_order', $product->qty_per_order, ['class'=>'form-control', 'placeholder'=>'Enter maximum allowed quantity per order']) !!}
    </div>
</div>

<div class="form-group">
    <div class="product_box">
        <label for="product[]">Related Products:</label>
        <select style="display:none" name="product[]" id="product[]" multiple>
            @foreach($products as $related_product)
                @if($product->related_products->contains($related_product->id))
                    <option selected value="{{$related_product->id}}">{{$related_product->name}} {{'(ID: '.$related_product->id.')'}}</option>
                @else
                    <option value="{{$related_product->id}}">{{$related_product->name}} {{'(ID: '.$related_product->id.')'}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $product->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
</div>

<div class="form-group">
    {!! Form::label('photo', 'Choose Featured Image', ['class'=>'btn btn-default btn-file']) !!}
    {!! Form::file('photo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
    <span class='label label-info' id="upload-file-info">No image chosen</span>
</div>

<div class="form-group">
    {!! Form::label('photos[]', 'Choose More Images', ['class'=>'btn btn-default btn-file']) !!}
    {!! Form::file('photos[]',['class'=>'form-control', 'multiple', 'style'=>'display: none;','onchange'=>'$("#upload-files-info").html(moreImagesNames(files))']) !!}
    <span class='label label-info' id="upload-files-info">No image chosen</span>
    <strong>(Hold Ctrl to select multiple images)</strong>
</div>

<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <a data-toggle="collapse" href="#collapse1">
                <div><strong>SEO</strong></div>
            </a>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
                    {!! Form::label('meta_title','Meta Title:') !!}
                    {!! Form::text('meta_title', $product->meta_title, ['class'=>'form-control', 'placeholder'=>'Enter meta title']) !!}
                </div>

                <div class="form-group{{ $errors->has('meta_desc') ? ' has-error' : '' }}">
                    {!! Form::label('meta_desc','Meta Description:') !!}
                    {!! Form::text('meta_desc', $product->meta_desc, ['class'=>'form-control', 'placeholder'=>'Enter meta description']) !!}
                </div>

                <div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
                    {!! Form::label('meta_keywords','Meta Keywords:') !!}
                    {!! Form::text('meta_keywords', $product->meta_keywords, ['class'=>'form-control', 'placeholder'=>'Enter meta keywords']) !!}
                </div>
            </div>
        </div>
    </div>
</div>