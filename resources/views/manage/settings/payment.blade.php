@extends('layouts.manage')

@section('title')
    @lang('Payment Settings')
@endsection

@section('page-header-title')
    @lang('Save Settings')
@endsection

@section('page-header-description')
    @lang('View and Update Settings')
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('settings_saved'))
            toastr.success("{{session('settings_saved')}}");
        @endif
        @if(session()->has('settings_not_saved'))
            toastr.error("{{session('settings_not_saved')}}");
        @endif
        var payUmoney = $('#payu-money');
        var payUbiz = $('#payu-biz');
        payUmoney.hide();
        payUbiz.hide();
        @if(config('payu.default') == 'payubiz')
            payUbiz.show();
        @elseif(config('payu.default') == 'payumoney')
            payUmoney.show();
        @endif
        $('#payu-selector').on('change', function() {
            if(this.value == 'payumoney') {
                payUbiz.hide();
                payUmoney.fadeIn();
            } else {
                payUmoney.hide();
                payUbiz.fadeIn();
            }
        });
    </script>
    @endif
    <script>
        async function checkPaymentEnable(payment_method, pay_value) {
            if(pay_value === '1'){
                let response = await fetch("{{url('manage/settings/enablePaymentMethod')}}/"+payment_method);
                let output  = await response.json();
                if(output === 1){
                    $('#'+payment_method+'_error').css('display','none');
                }else{
                    $('#'+payment_method).val(0);
                    $('#'+payment_method+'_error').css('display','block');
                }
            }
        }
    </script>
    @include('includes.tab_system_scripts')
@endsection

@section('content')
    @include('partials.manage.settings.payment')
@endsection