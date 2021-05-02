@extends('layouts.manage')

@section('title')
    @lang('Email Settings')
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
        var smtp = $('.smtp');
        var mailgun = $('.mailgun');

        smtp.hide();
        mailgun.hide();

        @if(config('mail.driver') == 'smtp')
            smtp.show();
        @elseif(config('mail.driver') == 'mailgun')
            mailgun.show();
        @endif

        $(document).ready(function() {
            $('#select-driver').on('change', function() {
                if(this.value == 'smtp') {
                    smtp.show();
                    mailgun.hide();
                } else if(this.value == 'mailgun') {
                    mailgun.show();
                    smtp.hide();
                }
            });
        });
    </script>
    <script>
        var orderPlaced = $('.order-placed');
        var paymentFailed = $('.payment-failed');
        var orderProcessed = $('.order-processed');
        var orderPackaged = $('.order-packaged');

        paymentFailed.hide();
        orderProcessed.hide();
        orderPackaged.hide();

        $(document).ready(function() {
            $('#select-template').on('change', function() {
                if(this.value == 'order_placed') {
                    orderPlaced.show();
                    paymentFailed.hide();
                    orderProcessed.hide();
                    orderPackaged.hide();
                } else if(this.value == 'payment_failed') {
                    paymentFailed.show();
                    orderPlaced.hide();
                    orderProcessed.hide();
                    orderPackaged.hide();
                } else if(this.value == 'order_processed') {
                    orderProcessed.show();
                    orderPlaced.hide();
                    paymentFailed.hide();
                    orderPackaged.hide();
                } else if(this.value == 'order_packaged') {
                    orderPackaged.show();
                    orderProcessed.hide();
                    orderPlaced.hide();
                    paymentFailed.hide();
                }
            });
        });
    </script>
    <script>
        var sendEmailBtn = $('#send-email');
        var feedback = $('.feedback');
        var feedbackAlert = $('.feedback-alert');
        feedbackAlert.hide();
        $(document).on('submit', '#send-test-email-form', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');

            sendEmailBtn.attr('value', '@lang('Please Wait...')');
            sendEmailBtn.attr("disabled", "disabled");

            $.post(url, data, function(receivedData) {
                if(!receivedData.error) {

                    if(!receivedData.permission) {
                        feedback.html('@lang('There is no permission to use this feature.')');
                    } else if(!receivedData.sent) {
                        feedback.html('@lang('Exception occurred while sending the email. Make sure that email template and configuration are set correctly.')');
                    } else if(receivedData.sent) {
                        feedback.html('@lang('Email was sent to') ' + receivedData.address);
                    } else {
                        feedback.html('@lang('Unknown error occurred.')');
                    }

                    feedbackAlert.show();
                } else {
                    feedbackAlert.show();
                    feedback.html('@lang('Something went wrong.')');
                }

                sendEmailBtn.attr('value', '@lang('Send Email')');
                sendEmailBtn.removeAttr("disabled");
            });

        });
    </script>
    @include('includes.tab_system_scripts')
@endsection

@section('content')
    @include('partials.manage.settings.email')
@endsection