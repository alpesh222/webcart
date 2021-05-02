<script>
    toastr.options.closeButton = true;

    @if(session()->has('subscribed'))
    toastr.success("{{session('subscribed')}}");
    @endif

    @if(session()->has('already_subscribed'))
    toastr.success("{{session('already_subscribed')}}");
    @endif

    @if(session()->has('subscribe_failed'))
    toastr.error("{{session('subscribe_failed')}}");
    @endif

    @if(session()->has('payment_success'))
    toastr.success("{{session('payment_success')}}");
    @endif

    @if(session()->has('payment_fail'))
    toastr.error("{{session('payment_fail')}}");
    @endif

    @if(session()->has('success'))
    toastr.success("{{ session('success') }}");
    @endif

    @if(session()->has('email_activation'))
    toastr.success("{{ session('email_activation') }}");
    @endif

</script>