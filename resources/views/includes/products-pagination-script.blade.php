<script src="{{asset('js/jquery.loadBar.min.js')}}"></script>
<script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: '@if(isset($category)) {{$product_max_price? $product_max_price : 0}} @else {{$product_max_price ? $product_max_price : 0}} @endif',
      values: [ 0, '@if(isset($category)) {{$product_max_price}} @else {{$product_max_price}} @endif' ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "{{config('currency.default')}}: " + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "{{config('currency.default')}}: " + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
  } );

    var reg = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/;
    if(reg.exec(APP_URL) != null) {
        var removePathname = reg.exec(APP_URL)[1];
    } else {
        removePathname = '';
    }

    $(document).on('change', '#sort_products', function(e) {
        e.preventDefault();
    
        // Price Range
        // var min_price = $('input[name="min_price"]').val();
        // var max_price = $('input[name="max_price"]').val();
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Sorting Check
        sortBy = $(this).val();
        if(sortBy != 0) {
            var options = window.location.search;
            var pathname = (window.location.pathname).replace(removePathname, '');
            if(options == "") {
                options += '?';
            } else {
                options += '&';
            }

            // Checkbox Filters
            var checkedFilters = $('.filter_products:checkbox:checked');
            var filterBy = [];
            var filterValue = [];
            var filterUnit = [];
            checkedFilters.each(function() {
                filterBy.push($(this).data("value").id);
                filterValue.push($(this).data("value").value);
                filterUnit.push($(this).data("value").unit);
            });

            // Checkbox Brands Filters
            var checkedFilters = $('.filter_products_brands:checkbox:checked');
            var filterByBrand = [];
            checkedFilters.each(function() {
                filterByBrand.push($(this).data('value').id);
            });

            requestOptions = {'sort_by': sortBy, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'filter_by_brand[]': filterByBrand, 'min_price': min_price, 'max_price': max_price};
            getProducts(1, options, pathname, requestOptions);
        }
    });

    $(document).on('slidestop', '#slider-range', function(e) {
        e.preventDefault();

        // Price Range
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Sorting Check
        var sortBy = $('#sort_products').val();

        // Checkbox Brands Filters
        var checkedFilters = $('.filter_products_brands:checkbox:checked');
        var filterByBrand = [];
        checkedFilters.each(function() {
            filterByBrand.push($(this).data('value').id);
        });

        // Checkbox Categories Filters
        var checkedFilters = $('.filter_products_categories:checkbox:checked');
        var filterByCategory = [];
        checkedFilters.each(function() {
            filterByCategory.push($(this).data('value').id);
        });

        // Checkbox Filters
        var checkedFilters = $('.filter_products:checkbox:checked');
        var filterBy = [];
        var filterValue = [];
        var filterUnit = [];
        checkedFilters.each(function() {
            filterBy.push($(this).data("value").id);
            filterValue.push($(this).data("value").value);
            filterUnit.push($(this).data("value").unit);
        });

        var options = window.location.search;
        var pathname = (window.location.pathname).replace(removePathname, '');
        if(options == "") {
            options += '?';
        } else {
            options += '&';
        }

        if(sortBy != 0) {
        requestOptions = {'sort_by': sortBy, 'filter_by_brand[]': filterByBrand, 'filter_by_category[]': filterByCategory, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        } else {
        requestOptions = {'filter_by_brand[]': filterByBrand, 'filter_by_category[]': filterByCategory, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        }
        getProducts(1, options, pathname, requestOptions);
    });

    $(document).on('change', '.filter_products_brands', function(e) {
        e.preventDefault();

        // Price Range
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Sorting Check
        var sortBy = $('#sort_products').val();

        // Checkbox Brands Filters
        var checkedFilters = $('.filter_products_brands:checkbox:checked');
        var filterByBrand = [];
        checkedFilters.each(function() {
            filterByBrand.push($(this).data('value').id);
        });

        // Checkbox Filters
        var checkedFilters = $('.filter_products:checkbox:checked');
        var filterBy = [];
        var filterValue = [];
        var filterUnit = [];
        checkedFilters.each(function() {
            filterBy.push($(this).data("value").id);
            filterValue.push($(this).data("value").value);
            filterUnit.push($(this).data("value").unit);
        });

        var options = window.location.search;
        var pathname = (window.location.pathname).replace(removePathname, '');
        if(options == "") {
            options += '?';
        } else {
            options += '&';
        }

        if(sortBy != 0) {
        requestOptions = {'sort_by': sortBy, 'filter_by_brand[]': filterByBrand, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        } else {
        requestOptions = {'filter_by_brand[]': filterByBrand, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        }
        getProducts(1, options, pathname, requestOptions);
    });

    $(document).on('change', '.filter_products_categories', function(e) {
        e.preventDefault();

        // Price Range
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Sorting Check
        var sortBy = $('#sort_products').val();

        // Checkbox Categories Filters
        var checkedFilters = $('.filter_products_categories:checkbox:checked');
        var filterByCategory = [];
        checkedFilters.each(function() {
            filterByCategory.push($(this).data('value').id);
        });

        var options = window.location.search;
        var pathname = (window.location.pathname).replace(removePathname, '');
        if(options == "") {
            options += '?';
        } else {
            options += '&';
        }

        if(sortBy != 0) {
        requestOptions = {'sort_by': sortBy, 'filter_by_category[]': filterByCategory, 'min_price': min_price, 'max_price': max_price};
        } else {
        requestOptions = {'filter_by_category[]': filterByCategory, 'min_price': min_price, 'max_price': max_price};
        }
        getProducts(1, options, pathname, requestOptions);
    });

    $(document).on('change', '.filter_products', function(e) {
        e.preventDefault();

        // Price Range
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Sorting Check
        var sortBy = $('#sort_products').val();

        // Checkbox Filters
        var checkedFilters = $('.filter_products:checkbox:checked');
        var filterBy = [];
        var filterValue = [];
        var filterUnit = [];
        checkedFilters.each(function() {
            filterBy.push($(this).data("value").id);
            filterValue.push($(this).data("value").value);
            filterUnit.push($(this).data("value").unit);
        });

        // Checkbox Brands Filters
        var checkedFilters = $('.filter_products_brands:checkbox:checked');
        var filterByBrand = [];
        checkedFilters.each(function() {
            filterByBrand.push($(this).data('value').id);
        });

        var options = window.location.search;
        var pathname = (window.location.pathname).replace(removePathname, '');
        if(options == "") {
            options += '?';
        } else {
            options += '&';
        }

        if(sortBy != 0) {
        requestOptions = {'sort_by': sortBy, 'filter_by_brand[]': filterByBrand, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        } else {
        requestOptions = {'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'filter_by_brand[]': filterByBrand, 'min_price': min_price, 'max_price': max_price};
        }
        getProducts(1, options, pathname, requestOptions);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        // Price Range
        var min_price = $( "#slider-range" ).slider("values")[0];
        var max_price = $( "#slider-range" ).slider("values")[1];

        // Checkbox Filters
        var checkedFilters = $('.filter_products:checkbox:checked');
        var filterBy = [];
        var filterValue = [];
        var filterUnit = [];
        checkedFilters.each(function() {
            filterBy.push($(this).data("value").id);
            filterValue.push($(this).data("value").value);
            filterUnit.push($(this).data("value").unit);
        });

        // Checkbox Brands Filters
        var checkedFilters = $('.filter_products_brands:checkbox:checked');
        var filterByBrand = [];
        checkedFilters.each(function() {
            filterByBrand.push($(this).data('value').id);
        });

        // Checkbox Categories Filters
        var checkedFilters = $('.filter_products_categories:checkbox:checked');
        var filterByCategory = [];
        checkedFilters.each(function() {
            filterByCategory.push($(this).data('value').id);
        });

        // Sorting Check
        sortBy = $('#sort_products').val();

        if(sortBy != 0) {
            requestOptions = {'sort_by': sortBy, 'filter_by_brand[]': filterByBrand, 'filter_by_category[]': filterByCategory, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        } else {
            requestOptions = {'filter_by_brand[]': filterByBrand, 'filter_by_category[]': filterByCategory, 'filter_by[]': filterBy, 'filter_value[]': filterValue, 'filter_unit[]': filterUnit, 'min_price': min_price, 'max_price': max_price};
        }

        var page = $(this).attr('href').split('page=')[1];
        var options = window.location.search;
        var pathname = (window.location.pathname).replace(removePathname, '');
        if(options == "") {
            options += '?';
        } else {
            options += '&';
        }
        getProducts(page, options, pathname, requestOptions);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // main color
    loadBar.mainColor = 'red';
    // strip color
    loadBar.stripColor = 'black';
    // animation speed
    loadBar.barSpeed = 5; 
    // bar height
    loadBar.barHeight = 5;

    function getProducts(page, options, pathname, requestOptions={}) {
        var products = $('.custom_product_data');
        loadBar.trigger('show');
        $.get(APP_URL+ '/ajax'+pathname+options+ 'page='+ page, requestOptions, function(receivedData) {
            if(!receivedData.error) {
                products.html(receivedData);
            } else {
                products.html('<h1>@lang('Something went wrong!')</h1>');
            }
            loadBar.trigger('hide');
        });
    }
</script>