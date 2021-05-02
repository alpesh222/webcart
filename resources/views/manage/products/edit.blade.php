@extends('layouts.manage')

@section('title')
    @lang('Edit Product')
@endsection

@section('page-header-title')
    @lang('Edit Product') <a class="btn btn-info btn-sm" href="{{route('manage.products.index')}}">@lang('View Products')</a>
@endsection

@section('page-header-description')
    @lang('Edit Product') <a href="{{route('manage.products.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('js/colorpick/colorPick.css')}}">
    <!-- The following line applies the dark theme -->
    <link rel="stylesheet" href="{{asset('js/colorpick/colorPick.dark.theme.css')}}">

    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
    @include('partials.manage.categories-tree-style')
    <style>
        .bolden {
            font-family: "Arial Black";
        }
        .product-feature-image {
            max-height: 300px;
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
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    @include('partials.manage.categories-tree-script');
    @include('includes.tinymce')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('product_updated'))
            toastr.success("{{session('product_updated')}}");
        @endif
    </script>
    @endif
    <script>
        $('.brand_box').dropdown({
            // options here
        });
        $('.category_box').dropdown({
            // options here
        });
        $('.product_box').dropdown({
            // options here
        });
        $('#add-more-specification').click(function() {
            $('.specification_types_rows > tr:first').clone().appendTo('.specification_types_rows');
        });
        $('#specification_types_box').on('click', '.remove_row', function(){
            var rowCount =  $('.specification_types_rows tr').length;
            if(rowCount > 1) {
                $(this).closest('tr').remove();
            }
        });

        $('#add-more-field').click(function() {
            $('.custom_fields_rows > tr:first').clone().appendTo('.custom_fields_rows');
        });
        $('#custom_fields_box').on('click', '.remove_row', function(){
            var rowCount =  $('.custom_fields_rows tr').length;
            if(rowCount > 1) {
                $(this).closest('tr').remove();
            }
        });

        var virtualProduct = $('#virtual');
        var productQuantity = $('.product-quantity');

        var downloadableProduct = $('#downloadable');
        var downloadableFile = $('#downloadable-file');

        var removeFile = $('#remove_file');

        downloadableFile.hide();

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

            removeFile.on('change', function() {
                if(removeFile.is(':checked')) {
                    downloadableFile.fadeIn();
                    downloadableFile.find('input[type=file]').filter(':first').attr('name', 'file');
                } else {
                    downloadableFile.fadeOut();
                    downloadableFile.find('input[type=file]').filter(':first').removeAttr('name');
                }
            });
        });

        var i = $('#add-variant').data('count');
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
    @include('partials.manage.products.edit')
@endsection