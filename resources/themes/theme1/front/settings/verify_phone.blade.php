@extends('layouts.front')

@section('title') @lang('Verify your phone number') - {{config('app.name')}}@endsection

@section('page-header-title')
    @lang('Verify your phone number')
@endsection

@section('page-header-description')
    @lang('Verify your phone number')
@endsection

@section('styles')
    @include('partials.phone_style')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
    <style>
        #page-inner {
            background-color: #f5f5f5 !important;
        }
    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-sticky col-md-10">
        @include('partials.front.sidebar')
        <div class="content col-md-9">
            <div class="page-title">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <h2>@lang('Verify your phone number')</h2>
                <hr>
                @if($user->mobile && !$user->mobile->verified)
                    <div class="row verify-phone-block">
                        <div class="col-md-12 col-sm-6">
                            <span class="help-block">
                                <strong class="text-danger">
                                    @lang('Please verify your phone number:')
                                </strong>
                                <strong class="text-primary">
                                	{{$user->mobile->number}}
                                </strong>
                            </span>
                            {!! Form::open(['method'=>'post', 'action'=>'SendVerificationSMS@sendOtp', 'id'=>'send-otp-form']) !!}
                            <div class="form-group">
                                {!! Form::submit(__('Click here to send verification code to your phone.'), ['class'=>'btn-primary btn-link', 'name'=>'submit_button', 'id'=>'send-otp-btn']) !!}
                            </div>
                            {{ Form::close() }}
                            <div class="feedback-alert">
                                <br>
                                <div class="alert alert-info" role="alert">
                                    <span class="feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="verify-phone"></div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('partials.phone_script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var sendOtpBtn = $('#send-otp-btn');
        var feedback = $('.feedback');
        var feedbackAlert = $('.feedback-alert');
        feedbackAlert.hide();
        $(document).on('submit', '#send-otp-form', function (e) {

            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');

            sendOtpBtn.attr("disabled", "disabled");

            $.post(url, data, function (receivedData) {
                if (!receivedData.error) {
                    if (receivedData.sent) {
                        feedback.html('@lang('Verification code was sent to ')' + receivedData.number);
                        var ajaxurl = '{{route('auth.sms.verify.form')}}';
                        $.ajax({
                            url: ajaxurl,
                            type: "GET",
                            success: function (data) {
                                $data = $(data);
                                $('#verify-phone').hide().html($data).fadeIn();
                            }
                        });
                    } else {
                        if (receivedData.message) {
                            feedback.html(receivedData.message);
                        } else {
                            feedback.html('@lang('Error occurred while sending verification code. Please try again after some time.')');
                        }
                    }
                    feedbackAlert.show();
                } else {
                    feedbackAlert.show();
                    feedback.html('@lang('Something went wrong.')');
                }

                sendOtpBtn.removeAttr("disabled");
            });

        });
    </script>
@endsection
