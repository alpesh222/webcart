@extends('layouts.manage')

@section('title')
    @lang('SMS Settings')
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
    </script>
    @endif
    <script>
        var msgclub = $('.msgclub');
        var pointsms = $('.pointsms');
        var nexmo = $('.nexmo');
        var textlocal = $('.textlocal');
        var twilio = $('.twilio');
        var ebulk = $('.ebulk');

        pointsms.hide();
        msgclub.hide();
        nexmo.hide();
        textlocal.hide();
        twilio.hide();
        ebulk.hide();

        @if(config('sms.carrier') == 'msgclub')
            msgclub.show();
        @elseif(config('sms.carrier') == 'pointsms')
            pointsms.show();
        @elseif(config('sms.carrier') == 'nexmo')
            nexmo.show();
        @elseif(config('sms.carrier') == 'textlocal')
            textlocal.show();
        @elseif(config('sms.carrier') == 'twilio')
            twilio.show();
        @elseif(config('sms.carrier') == 'ebulk')
            ebulk.show();
        @endif

        $(document).ready(function() {
            $('#select-driver').on('change', function() {
                if(this.value == 'msgclub') {
                    nexmo.hide();
                    textlocal.hide();
                    twilio.hide();
                    ebulk.hide();
                    pointsms.hide();
                    msgclub.show();
                } else if(this.value == 'pointsms') {
                    msgclub.hide();
                    textlocal.hide();
                    twilio.hide();
                    ebulk.hide();
                    nexmo.hide();
                    pointsms.show();
                } else if(this.value == 'nexmo') {
                    msgclub.hide();
                    textlocal.hide();
                    twilio.hide();
                    ebulk.hide();
                    pointsms.hide();
                    nexmo.show();
                } else if(this.value == 'textlocal') {
                    msgclub.hide();
                    nexmo.hide();
                    twilio.hide();
                    ebulk.hide();
                    pointsms.hide();
                    textlocal.show();
                }else if(this.value == 'twilio') {
                    msgclub.hide();
                    nexmo.hide();
                    textlocal.hide();
                    ebulk.hide();
                    pointsms.hide();
                    twilio.show();
                }else if(this.value == 'ebulk') {
                    msgclub.hide();
                    nexmo.hide();
                    textlocal.hide();
                    twilio.hide();
                    pointsms.hide();
                    ebulk.show();
                }
            });
        });
    </script>
    <script>
        var orderPlaced = $('.order-placed');
        var orderProcessed = $('.order-processed');
        var orderPackaged = $('.order-packaged');

        orderProcessed.hide();
        orderPackaged.hide();

        $(document).ready(function() {
            $('#select-template').on('change', function() {
                if(this.value == 'order_placed') {
                    orderPlaced.show();
                    orderProcessed.hide();
                    orderPackaged.hide();
                } else if(this.value == 'order_processed') {
                    orderProcessed.show();
                    orderPlaced.hide();
                    orderPackaged.hide();
                } else if(this.value == 'order_packaged') {
                    orderProcessed.hide();
                    orderPlaced.hide();
                    orderPackaged.show();
                }
            });
        });
    </script>
    <script>
        var sendSMSBtn = $('#send-sms');
        var feedback = $('.feedback');
        var feedbackAlert = $('.feedback-alert');
        feedbackAlert.hide();
        $(document).on('submit', '#send-test-sms-form', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');

            sendSMSBtn.attr('value', '@lang('Please Wait...')');
            sendSMSBtn.attr("disabled", "disabled");

            $.post(url, data, function(receivedData) {
                if(!receivedData.error) {

                    if(!receivedData.permission) {
                        feedback.html('@lang('There is no permission to use this feature.')');
                    } else if(receivedData.invalid_api) {
                        feedback.html('@lang('Incorrect API keys or Exception occurred.')');
                    }
                    else if(!receivedData.sent) {
                        feedback.html('@lang('SMS carrier is not set.')');
                    } else if(receivedData.sent) {
                        feedback.html('@lang('SMS was sent to ')' + receivedData.mobile);
                    } else {
                        feedback.html('@lang('Unknown error occurred.')');
                    }

                    feedbackAlert.show();
                } else {
                    feedbackAlert.show();
                    feedback.html('@lang('Something went wrong.')');
                }

                sendSMSBtn.attr('value', '@lang('Send SMS')');
                sendSMSBtn.removeAttr("disabled");
            });

        });
    </script>
    @include('includes.tab_system_scripts')
@endsection

@section('content')
    @include('partials.manage.settings.sms')
@endsection