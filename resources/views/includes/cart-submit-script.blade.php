<script src="{{asset('js/jquery.loadBar.min.js')}}"></script><script>        $.ajaxSetup({        headers: {            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')        }    });    // main color    loadBar.mainColor = 'red';    // strip color    loadBar.stripColor = 'black';    // animation speed    loadBar.barSpeed = 5;    // bar height    loadBar.barHeight = 5;    var cartMessage = $('.cart-message');    var cartCount = $('.cart-count');    $(document).on('submit', '#cart-form', function(e) {        e.preventDefault();        var data = $(this).serialize();        var url = $(this).attr('action');        var submitBtn = $(this).find("input[type=submit]:focus");        submitBtn.val('Adding to Cart');        submitBtn.closest('div').addClass('loader');        loadBar.trigger('show');        $.post(url, data, function(receivedData) {            var selectorCartCount = '.cart-count';            var selectorproductAdded = '.product-added';            var receivedData = $("<div>" + receivedData + "</div>");            var count = receivedData.find(selectorCartCount).html();            var productAdded = receivedData.find(selectorproductAdded).html();            receivedData.find(selectorCartCount).remove();            receivedData.find(selectorproductAdded).remove();            receivedData = receivedData.html();            if(!receivedData.error) {                cartMessage.html(receivedData);                jQuery('.dropdown-wrapper-cart').load(location.href + " " + '.dropdown-wrapper-cart', function() {});                if (jQuery('.dropdown-cart-anchor')){                    jQuery('.dropdown-cart-anchor').click();                }                // cartCount.html(count);                // if(productAdded) {                //     window.location.href = APP_URL + '/cart';                // }            } else {                cartMessage.html('<h1>@lang('Something went wrong!')</h1>');            }            loadBar.trigger('hide');            submitBtn.val('{{__('Add to Cart')}}');            submitBtn.closest('div').removeClass('loader');        });    });</script>