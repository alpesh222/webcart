<script>
    $('#seller_form').css('display','none');
    $('input[type=radio][name=user_role]').change(function() {
        $('.is_vendor').remove();
        $('#vendor_terms').remove();
        if (this.value == 'buyer') {
            $('#seller_form').css('display','none');
            $('#register-button').attr('disabled',false);
        }
        else if (this.value == 'seller') {
            $('#register-button').attr('disabled',true);
            $('#seller_form').css('display','block');
            $('<input type="hidden" name="vendor" value="1" class="is_vendor">').appendTo('#seller_form');
            var terms_url = '';
            @if(config('settings.terms_of_service_url'))
                terms_url = '<a class="text-primary" href="{{config('settings.terms_of_service_url')}}">terms and conditions</a>';
            @endif
            $('<div class="col-md-12 pl-0 mb-20" id="vendor_terms"><input type="checkbox" id="check_vendor_terms" onclick="checkTermsConditions()"> <span> @lang('I Accept Terms and Conditions') '+terms_url+'</span></div>').appendTo('#term_checkbox');
        }
    });
    function checkTermsConditions(){
        if ($('#check_vendor_terms').is(':checked')){
            $('#register-button').attr('disabled',false);
        } else {
            $('#register-button').attr('disabled',true);
        }
    }
</script>