<div class="row">
    <div class="col-xs-12">
        @if(session()->has('settings_saved'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('settings_saved')}}</strong>
            </div>
        @endif

        @if(session()->has('settings_not_saved'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <strong>&nbsp;@lang('Error:')</strong> {{session('settings_not_saved')}}
            </div>
        @endif

        @include('includes.form_errors')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul id="sms-nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#template"
                    aria-controls="template"
                    role="tab"
                    data-toggle="tab"
                >@lang('Template')</a>
            </li>
            <li role="presentation">
                <a href="#configuration"
                aria-controls="configuration"
                role="tab"
                data-toggle="tab"
                >@lang('Configuration')</a>
            </li>
            <li role="presentation">
                <a href="#otp"
                    aria-controls="otp"
                    role="tab"
                    data-toggle="tab"
                >@lang('OTP Verification')</a>
            </li>
            <li role="presentation">
                <a href="#test"
                aria-controls="test"
                role="tab"
                data-toggle="tab"
                >@lang('SMS Test')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="template">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSTemplate', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

						<h4 class="text-center">@lang('SMS')</h4>

                        <div class="form-group{{ $errors->has('enable_sms') ? ' has-error' : '' }}">
                            {!! Form::select('enable_sms', [true=>__('Enable'), false=>__('Disable')], config('sms.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <h4 class="text-center">@lang('SMS Template')</h4>

                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                <h4 class="text-center">@lang('SMS Text')</h4>

                                <select id="select-template" class="form-control selectpicker" data-style="btn-default">
                                    <option value="order_placed">@lang('Order Placed')</option>
                                    <option value="order_processed">@lang('Order Processed')</option>
                                    <option value="order_packaged">@lang('Order Packaged')</option>
                                </select>

                                <hr>
                            </div>
                        </div>

                        <div class="order-placed">
                            <div class="form-group{{ $errors->has('sms_message_order_placed') ? ' has-error' : '' }}">
                                {!! Form::label('sms_message_order_placed', __('Order Placed SMS:')) !!}
                                {!! Form::textarea('sms_message_order_placed', config('sms.messages.order_placed'), ['class'=>'form-control', 'placeholder'=>__('Enter Message For Order Placed'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="order-processed">
                            <div class="form-group{{ $errors->has('sms_message_order_processed') ? ' has-error' : '' }}">
                                {!! Form::label('sms_message_order_processed', __('Order Processed SMS:')) !!}
                                {!! Form::textarea('sms_message_order_processed', config('sms.messages.order_processed'), ['class'=>'form-control', 'placeholder'=>__('Enter Message For Order Processed'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="order-packaged">
                            <div class="form-group{{ $errors->has('sms_message_order_packaged') ? ' has-error' : '' }}">
                                {!! Form::label('sms_message_order_packaged', __('Order Packaged SMS:')) !!}
                                {!! Form::textarea('sms_message_order_packaged', config('sms.messages.order_packaged'), ['class'=>'form-control', 'placeholder'=>__('Enter Message For Order Packaged'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="configuration">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        <h4 class="text-center">@lang('SMS Configuration')</h4>

                        <select id="select-driver" class="form-control selectpicker" data-style="btn-default">
                            <option {{config('sms.carrier') == 'msgclub' ? 'selected' : ''}} value="msgclub">@lang('Infigo Msg')</option>
                            <option {{config('sms.carrier') == 'pointsms' ? 'selected' : ''}} value="pointsms">@lang('Infigo Point')</option>
                            <option {{config('sms.carrier') == 'nexmo' ? 'selected' : ''}} value="nexmo">@lang('Nexmo')</option>
                            <option {{config('sms.carrier') == 'textlocal' ? 'selected' : ''}} value="textlocal">@lang('Textlocal')</option>
                            <option {{config('sms.carrier') == 'twilio' ? 'selected' : ''}} value="twilio">@lang('Twilio')</option>
                            <option {{config('sms.carrier') == 'ebulk' ? 'selected' : ''}} value="ebulk">@lang('eBulk')</option>
                        </select>

                        <hr>
                    </div>
                </div>

                <div class="row msgclub">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSMsgClub', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'msgclub') !!}

                        <a target="_blank" href="https://infigosoftware.in/bulk-sms-service/">
                            <strong>@lang('Click here for Infigo Msg SMS Package Features and Pricing')</strong>
                        </a>
                        <hr>

                        <div class="form-group{{ $errors->has('msgclub_auth_key') ? ' has-error' : '' }}">
                            {!! Form::label('msgclub_auth_key', __('Infigo Msg Auth Key:')) !!}
                            {!! Form::text('msgclub_auth_key', config('sms.msgclub.auth_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Auth Key')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('msgclub_senderId') ? ' has-error' : '' }}">
                            {!! Form::label('msgclub_senderId', __('Infigo Msg Sender ID:')) !!}
                            {!! Form::text('msgclub_senderId', config('sms.msgclub.senderId'), ['class'=>'form-control', 'placeholder'=>__('Enter Sender ID')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                            {!! Form::label('msgclub_routeId', __('Infigo Msg Route ID:')) !!}
                            {!! Form::text('msgclub_routeId', config('sms.msgclub.routeId'), ['class'=>'form-control', 'placeholder'=>__('Enter Route ID')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('msgclub_sms_content_type') ? ' has-error' : '' }}">
                            {!! Form::label('msgclub_sms_content_type', __('Infigo Msg SMS Content Type:')) !!}
                            {!! Form::text('msgclub_sms_content_type', config('sms.msgclub.sms_content_type'), ['class'=>'form-control', 'placeholder'=>__('Enter SMS Content Type')]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row pointsms">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSPointSMS', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'pointsms') !!}

                        <a target="_blank" href="https://infigosoftware.in/bulk-sms-service/">
                            <strong>@lang('Click here for Infigo Point SMS Package Features and Pricing')</strong>
                        </a>
                        <hr>

                        <div class="form-group{{ $errors->has('pointsms_username') ? ' has-error' : '' }}">
                            {!! Form::label('pointsms_username', __('Infigo Point Username:')) !!}
                            {!! Form::text('pointsms_username', config('sms.pointsms.username'), ['class'=>'form-control', 'placeholder'=>__('Enter Username')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pointsms_password') ? ' has-error' : '' }}">
                            {!! Form::label('pointsms_password', __('Infigo Point Password:')) !!}
                             {!! Form::password('pointsms_password', ['class'=>'form-control', 'placeholder'=>__('Enter Password')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pointsms_senderId') ? ' has-error' : '' }}">
                            {!! Form::label('pointsms_senderId', __('Infigo Point Sender ID:')) !!}
                            {!! Form::text('pointsms_senderId', config('sms.pointsms.senderId'), ['class'=>'form-control', 'placeholder'=>__('Enter Sender ID')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pointsms_channel') ? ' has-error' : '' }}">
                            {!! Form::label('pointsms_channel', __('Infigo Point Channel:')) !!}
                            {!! Form::text('pointsms_channel', config('sms.pointsms.channel'), ['class'=>'form-control', 'placeholder'=>__('Enter channel (Trans or Promo)')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pointsms_route') ? ' has-error' : '' }}">
                            {!! Form::label('pointsms_route', __('Infigo Point Route:')) !!}
                            {!! Form::text('pointsms_route', config('sms.pointsms.route'), ['class'=>'form-control', 'placeholder'=>__('Enter Route')]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row nexmo">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSNexmo', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'nexmo') !!}

                        <div class="form-group{{ $errors->has('nexmo_api_key') ? ' has-error' : '' }}">
                            {!! Form::label('nexmo_api_key', __('Nexmo API Key:')) !!}
                            {!! Form::text('nexmo_api_key', config('nexmo.api_key'), ['class'=>'form-control', 'placeholder'=>__('Enter API Key')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('nexmo_api_secret') ? ' has-error' : '' }}">
                            {!! Form::label('nexmo_api_secret', __('Nexmo API Secret:')) !!}
                            {!! Form::text('nexmo_api_secret', config('nexmo.api_secret'), ['class'=>'form-control', 'placeholder'=>__('Enter API Secret')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('nexmo_from') ? ' has-error' : '' }}">
                            {!! Form::label('nexmo_from', __('Nexmo From:')) !!}
                            {!! Form::text('nexmo_from', config('sms.nexmo.from'), ['class'=>'form-control', 'placeholder'=>__('Enter From')]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row textlocal">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSTextlocal', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'textlocal') !!}

                        <div class="form-group{{ $errors->has('textlocal_api_key') ? ' has-error' : '' }}">
                            {!! Form::label('textlocal_api_key', __('Textlocal API Key:')) !!}
                            {!! Form::text('textlocal_api_key', config('sms.textlocal.api_key'), ['class'=>'form-control', 'placeholder'=>__('Enter API Key')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('textlocal_sender') ? ' has-error' : '' }}">
                            {!! Form::label('textlocal_sender', __('Textlocal Sender:')) !!}
                            {!! Form::text('textlocal_sender', config('sms.textlocal.sender'), ['class'=>'form-control', 'placeholder'=>__('Enter Sender ID')]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row twilio">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSTwilio', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'twilio') !!}

                        <div class="form-group{{ $errors->has('twilio_sender_id') ? ' has-error' : '' }}">
                            {!! Form::label('twilio_sender_id', __('Twilio Account SID:')) !!}
                            {!! Form::text('twilio_sender_id', config('sms.twilio.senderId'), ['class'=>'form-control', 'placeholder'=>__('Enter Your Twilio Account SID')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('twilio_auth_token') ? ' has-error' : '' }}">
                            {!! Form::label('twilio_auth_token', __('Twilio Auth Token:')) !!}
                            {!! Form::text('twilio_auth_token', config('sms.twilio.auth_token'), ['class'=>'form-control', 'placeholder'=>__('Enter Your Twilio Auth Token')]) !!}
                        </div>
                        <div class="form-group{{ $errors->has('twilio_from') ? ' has-error' : '' }}">
                            {!! Form::label('twilio_from', __('Twilio From Number:')) !!}
                            {!! Form::number('twilio_from', config('sms.twilio.from'), ['class'=>'form-control', 'placeholder'=>__('Enter Your Twilio Number')]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row ebulk">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSeBulk', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('sms_carrier', 'ebulk') !!}

                        <div class="form-group{{ $errors->has('ebulk_user_name') ? ' has-error' : '' }}">
                            {!! Form::label('ebulk_user_name', __('eBulk Sender Name:')) !!}
                            {!! Form::text('ebulk_user_name', config('sms.ebulk.user_name'), ['class'=>'form-control', 'placeholder'=>__('Enter Your eBulk User Name')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('ebulk_api_key') ? ' has-error' : '' }}">
                            {!! Form::label('ebulk_api_key', __('Twilio Auth Token:')) !!}
                            {!! Form::text('ebulk_api_key', config('sms.ebulk.api_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Your eBulk Api Key')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="otp">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSMSOtp', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Phone Field & OTP Verification')</h4>

                        <div class="form-group{{ $errors->has('phone_otp_verification') ? ' has-error' : '' }}">
                            {!! Form::select('phone_otp_verification', [true=>__('Enable'), false=>__('Disable')], config('settings.phone_otp_verification'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="test">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        <h4 class="text-center">@lang('SMS Test')</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'post', 'action'=>'ManageTestController@testSMS', 'id'=>'send-test-sms-form']) !!}

                        <div class="form-group{{ $errors->has('sms_test_number') ? ' has-error' : '' }}">
                            {!! Form::label('sms_test_number', __('Mobile Number')) !!}
                            {!! Form::text('sms_test_number', null, ['class'=>'form-control', 'placeholder'=>__("Enter Receiver's Mobile Number"), 'required']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('sms_test_message') ? ' has-error' : '' }}">
                            {!! Form::label('sms_test_message', __('Enter your message')) !!}
                            {!! Form::textarea('sms_test_message', null, ['class'=>'form-control', 'placeholder'=> __('Enter your message'), 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Send SMS'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'id'=>'send-sms']) !!}
                        </div>

                        {!! Form::close() !!}
                        
                        <div class="clearfix"></div>

                        <div class="feedback-alert">
                            <br>
                            <div class="alert alert-info" role="alert">
                                <strong class="feedback"></strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>