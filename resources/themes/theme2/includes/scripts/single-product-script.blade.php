<script>

    async function checkShippingAvailability() {
        this.disabled = true;
        this.innerText ='Please Wait...';
        $('#shipping_success').css('display','none');
        $('#shipping_error').css('display','none');
        var shipping_pincode = $('#shipping_pincode').val();
        if(shipping_pincode != ''){
            let response = await fetch("{{url('/ajax/checkShippingAvailability')}}/"+ shipping_pincode);
            let output  = await response.json();
                @if(config('settings.enable_zip_code')){
                if(output === 1){
                    $('#add_cart').removeClass('btn-danger');
                    $('#add_cart').addClass('btn-success');
                    $('#add_cart').removeAttr('disabled');
                    $('#shipping_success').css('display','block');
                }else{
                    $('#add_cart').removeClass('btn-success');
                    $('#add_cart').addClass('btn-danger');
                    $('#add_cart').attr('disabled','true');
                    $('#shipping_error').css('display','block');
                }
            }
            @else
            $('#add_cart').addClass('btn-success');
            $('#add_cart').removeAttr('disabled');
            if(output === 1){
                $('#shipping_success').css('display','block');
            }else{
                $('#shipping_error').css('display','block');
            }
            @endif
        }else{
            $('#add_cart').removeClass('btn-success');
            $('#add_cart').addClass('btn-danger');
            $('#add_cart').attr('disabled','true');
            $('#shipping_error').css('display','block');
        }

    }

    function updateProductAmount(product) {
        var variants = [];
        var values = [];
        $('.variant_input').each(function(input) {
            if($(this).is(':checked')) {
                var variant = $(this).data('variant');
                var value = $(this).val();
                variants.push(variant);
                values.push(value);
            }
        });

        $.ajax({
            method: 'get',
            url: APP_URL + '/ajax/product/get-variant/' + product + '/' + variants.join(',') + '/' + values.join(','),
            success: function(response) {
                if(response.success) {
                    $('#single_prod_price').html(response.data)
                }
            }
        });
    }

    $(function(){
        // Product Details Product Color Active Js Code
        $(document).on('click', '.color-variation-list .box', function () {
            colors = $(this).data('color');
            var parent = $(this).parent();
            $('.color-variation-list li').removeClass('active');
            parent.addClass('active');

            var color_var_inp = parent.parent().find('.variant_input[type="radio"]');

            color_var_inp.each(function(input) {
                this.removeAttribute('checked');
                // this.setAttribute('value','0');
            });
            // console.log($(this).parent().find('.variant_input[type="hidden"]'));
            var checked_inp = parent.find('.variant_input[type="radio"]');
            checked_inp.attr('checked','true');
            var product = checked_inp.data('product');
            updateProductAmount(product);
            // checked_inp.attr('value','1');
        });
    });

    $(document).on('change', '.variant_input', function() {
        var product = $(this).data('product');
        updateProductAmount(product);
    });

    $("#halfstarsReview").rating({
        "half": true,
        "click": function (e) {
            console.log(e);
            $("#halfstarsInput").val(e.stars);
        }
    });


</script>