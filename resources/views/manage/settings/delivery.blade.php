@extends('layouts.manage')

@section('title')
    @lang('Delivery Settings')
@endsection

@section('page-header-title')
    @lang('Save Settings')
@endsection

@section('page-header-description')
    @lang('View and Update Settings')
@endsection

@section('styles')
    <style>
        .custom_card_box_css{
            border: 1px solid #c6c6c6;
            border-radius: 20px;
            padding-bottom: 10px;
            margin: 0 15px;
        }
        .custom_submit_btn{
            margin-top: 40px;
        }
        .custom_delivery_h4{
            border: 1px solid #237ba3;
            padding: 10px;
            background: #237ba3;
            color: white;
            text-transform: uppercase;
            font-weight: 700;
        }
        .form-group{
            margin-bottom: 20px!important;
        }
    </style>
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
    </script>
    @endif

    <script>
        var delhivery = $('.delhivery');

        @if(config('delivery.service') == 'delhivery')
            delhivery.show();
        @endif

        $(document).ready(function() {
            $('#select-driver').on('change', function() {
                if(this.value == 'delhivery') {
                    delhivery.show();
                }
            });
        });
    </script>


    <script>
        async function checkDeliveryEnable(payment_method, pay_value) {
            if(pay_value === '1'){
                let response = await fetch("{{url('manage/settings/enableDeliveryMethod')}}/"+payment_method);
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
    @include('partials.manage.settings.delivery')
@endsection