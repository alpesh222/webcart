@extends('layouts.manage')

@section('title')
    @lang('Add Product')
@endsection

@section('page-header-title')
    @lang('Add Product') <a class="btn btn-info btn-sm" href="{{route('manage.products.index')}}">@lang('View Products')</a>
@endsection

@section('page-header-description')
    @lang('Add New Product') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
    @include('partials.manage.categories-tree-style')
    <style>
        .bolden {
            font-family: "Arial Black";
        }
        .variants {
            margin-bottom: 1.2rem;
        }
        .remove_variant {
            cursor: pointer;
        }
        .variant_name > strong {
            display: inline-block;
            margin-bottom: .5rem;
        }
        .custom_prod_var_span{
            display: flex;
        }
        .custom_prod_var_span>input{
            margin-right: 5px;
        }
    </style>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{asset('js/colorpick/colorPick.css')}}">
    <!-- The following line applies the dark theme -->
    <link rel="stylesheet" href="{{asset('js/colorpick/colorPick.dark.theme.css')}}">

    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    @include('includes.tinymce')
    @include('partials.manage.categories-tree-script');
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.brand_box').dropdown({
            // options here
        });
        $('.category_box').dropdown({
            // options here
        });
        $('.product_box').dropdown({
            // options here
        });
        var fetchExistingProduct = $('#fetch_existing_product');
        var existingProductMessage = $('#existing_product_message');
        var loadingMessage = '<span class="text-primary">@lang('Loading...')</span>';
        var errorMessage = '<span class="text-danger">@lang('Loading...')</span>';
        $('.existing_product_box').dropdown({
            // callback
            choice: function (e) {
                var productID = e.target.dataset.value;
                if(productID) {
                    existingProductMessage.html(loadingMessage);
                    $.ajax({
                        type: "get",
                        url: "{{url('manage/existing-product')}}/" + productID,
                        success: function(response) {               
                            if(response) {
                                fetchExistingProduct.html(response);
                                existingProductMessage.html('');
                            } else {
                                existingProductMessage.html(errorMessage);
                            }
                        },
                        error: function(response) {
                            existingProductMessage.html('');
                        }
                    });
                }
            }
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

            @if(old('category'))
                $("#category").val("{{old('category')}}");
            @endif
        });

        var getSpecifications = $('#get-specifications');
        var category = $('#category');
        $(document).on('change', '#category', function() {
            category = this;
            if(this.value != 0) {
                getSpecifications.html('<button type="button" class="btn btn-xs btn-block" id="get-specifications-btn">@lang('Get Specifications for') ' + $("#category option:selected").text() + '</button>');
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
                            specificationsHTML += '<tr> <td> <select class="form-control selectpicker" data-style="btn-default" name="specification_type[]"><option value="' +element.id+ '">'+element.name+'</option>'+options+'</select> </td> <td> <input class="form-control" placeholder="@lang('Example: 14, 3.5, red')" name="specification_type_value[]" type="text"> </td> <td> <input class="form-control" placeholder="@lang('kg, GHz (Leave blank if no unit)')" name="specification_type_unit[]" type="text"> </td> <td> <button class="remove_row btn btn-danger btn-xs" type="button"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </button> </td> </tr>'
                        });
                        $('.specification_types_rows').html(specificationsHTML);
                    } else {
                        $('<p class="text-danger">@lang('Specifications are not set for this category.')</p>').insertAfter(getSpecifications).fadeOut(2500);
                    }
                } else {
                    $('<p class="text-danger">@lang('Error occured while fetching specifications for this category.')</p>').insertAfter(getSpecifications).fadeOut(2500);
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

        var i = 0;
        $(document).on('click', '#add-variant', function() {
            i++;
            $('.variants-field').append('' +
                '<div class="form-group variant-field-row well">' +
                    '<label class="variant_name"><strong>@lang('Variant Name')</strong>' +
                    '&nbsp;<span class="remove_variant text-danger" type="button">' +
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                    '</span>' +
                    '<span class="custom_prod_var_span">' +
                        '<input required class="form-control variant_name_value" type="text" name="variant[' + i + ']">' +
                        '<label>' +
                            '<input type="checkbox" onchange="checkColorVariation(this.id)" id="variant_' + i + '"> @lang('is this Color Variation')' +
                            '<input type="hidden" name="is_color[' + i + ']" value="0" id="is_color_variant_' + i + '" >' +
                        '</label>' +
                    '</span>' +
                    '</label>' +
                    '<div class="variant-field-values">' +
                        '<table class="table table-responsive table-bordered">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>@lang('Name')</th>' +
                                    '<th>@lang('Additional Cost')</th>' +
                                    '<th></th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                                '<tr>' +
                                    '<td>' +
                                        '<input class="form-control" required placeholder="" name="variant_v[' + i + '][]" type="text" autocomplete="off">' +
                                    '</td>' +
                                    '<td>' +
                                        '<input class="form-control" required placeholder="" name="variant_p[' + i + '][]" type="number" step="any" min="0">' +
                                    '</td>' +
                                    '<td>' +
                                        '<button class="remove_variant_value btn btn-danger btn-xs" type="button">' +
                                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' +
                                        '</button>' +
                                    '</td>' +
                                '</tr>' +
                                '<tr>' +
                                    '<td>' +
                                        '<button class="add_variant_value btn btn-success btn-xs" type="button">' +
                                            '@lang("Add More")' +
                                        '</button>' +
                                    '</td>' +
                                '</tr>' +
                            '</tbody>' +
                        '</table>' +
                    '</div>' +
                '</div>'
            );
           // checkVariantName();
        });

        $(document).on('click', '.add_variant_value', function() {
            var tbody = $(this).parent().parent().parent();
            var row = tbody.find('tr:nth-child(1)').clone().find("input:text").val("").end().find("input[type='number']").val("").end();
            tbody.find('tr:last').prev().after(row);
            colorUpdate();
        });

        $(document).on('click', '.remove_variant_value', function() {
            var tbody = $(this).parent().parent().parent();
            if(tbody.find('tr').length > 2) {
                $(this).parent().parent().remove();
            }
        });

        $(document).on('click', '.remove_variant', function() {
            $(this).parent().parent().remove();
        });
    </script>
    @include('partials.manage.includes.colorPickJs')
@endsection

@section('content')
    @include('partials.manage.products.create')
@endsection