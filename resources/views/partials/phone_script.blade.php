<script src="{{asset('js/intlTelInput.min.js')}}"></script>
<script>
	telInput = $("#phone-number");
    $(document).ready(function() {
        telInput.intlTelInput({
            allowExtensions: true,
            nationalMode: true,
            hiddenInput: "phone",
            initialCountry: '{{ config('googlemap.admin_country_code') ? config('googlemap.admin_country_code') : 'IN' }}',
		  	separateDialCode: true,
            preventInvalidNumbers: true,
            utilsScript: "{{asset('js/utils.js')}}"
        });
    });
</script>