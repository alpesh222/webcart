<script type="text/javascript">
	var APP_URL = {!! json_encode(url('/')) !!}
</script>
@if(config('settings.enable_google_translation'))
    <script type="text/javascript" src="{{asset('js/google-translate.js')}}"></script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endif

