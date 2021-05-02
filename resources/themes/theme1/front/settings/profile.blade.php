@extends('layouts.front')

@section('title')@lang('Profile Settings') - {{config('app.name')}}@endsection

@section('page-header-title')
    @lang('Profile Settings')
@endsection

@section('page-header-description')
    @lang('View or Change Profile Settings')
@endsection

@section('styles')
    @include('partials.phone_style')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrapper wrapper-sticky col-md-10">
        @include('partials.front.sidebar')
        <div class="content col-md-9">
            <div class="page-title">
                <h2>@lang('Profile Settings')</h2>
            </div>
            @if(session()->has('profile_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('profile_updated')}}
                </div>
            @endif
            @include('includes.form_errors')

            @if(config('settings.phone_otp_verification'))
                @if(!$user->mobile)
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="text-danger">
                        <strong>
                        @lang('Please add your phone number.')
                        </strong>
                    </div>
                </div>
                @elseif(!$user->mobile->verified)
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="verify-phone-block">
                        <span class="help-block">
                            <strong class="text-danger">
                                @lang('Please verify your phone number.')
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
                    <div id="verify-phone"></div>
                </div>
                @endif
            @endif

            <div class="col-sm-8 col-sm-offset-2 profile-setting-form">
                {!! Form::model($user, ['method'=>'patch', 'action'=>['FrontSettingsController@updateProfile'], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;', 'id'=>'update-profile-form']) !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', __('Name:')) !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
                </div>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    {!! Form::label('username', __('Username:')) !!}
                    {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>__('Enter username'), 'required'])!!}
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', __('Email:')) !!}
                    {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter email'), 'required']) !!}
                </div>

                @if(config('settings.phone_otp_verification'))
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    {!! Form::label('phone-number','Phone Number:') !!}
                    <input type="text" name="phone-number" id="phone-number" class="form-control"
                           value="{{old('phone') ? old('phone') : ($user->mobile ? $user->mobile->number : null) }}"
                           placeholder="Enter your phone number">
                </div>
                @endif

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', __('Password:')) !!}
                    {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>__('Enter password')]) !!}
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation', __('Confirm Password:')) !!}
                    {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>__('Enter password again')]) !!}
                </div>

                <div class="form-group">
                    <button type="submit" class="btn  btn-block" name="submit_button" id="update_btn"> @lang('Update Profile')
                    </button>

                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var updateProfileForm = $('#update-profile-form');
        var oldEmail = updateProfileForm.find('input[name="email"]').val();
        $(document).on('click', '#update_btn', function (event) {
            event.preventDefault();
            var newEmail = updateProfileForm.find('input[name="email"]').val();
            if (oldEmail != newEmail) {
                if (confirm('@lang('You have requested to change your email. An activation link will be sent to') "' + newEmail + '". @lang('You are going to logout. Click Ok to confirm.')')) {
                    updateProfileForm.submit();
                }
            } else {
                updateProfileForm.submit();
            }
        });
    </script>
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
                        feedback.html('Verification code was sent to ' + receivedData.number);
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
                            feedback.html('Error occurred while sending verification code. Please try again after some time.');
                        }
                    }
                    feedbackAlert.show();
                } else {
                    feedbackAlert.show();
                    feedback.html('Something went wrong.');
                }

                sendOtpBtn.removeAttr("disabled");
            });

        });
    </script>
@endsection
