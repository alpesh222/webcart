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
        <ul id="email-nav-tabs" class="nav nav-tabs" role="tablist">
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
                <a href="#test"
                aria-controls="test"
                role="tab"
                data-toggle="tab"
                >@lang('Email Test')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="template">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateEmailTemplate', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Email Template')</h4>

                        <div class="form-group{{ $errors->has('mail_from_address') ? ' has-error' : '' }}">
                            {!! Form::label('mail_from_address', __('Mail From Address:')) !!}
                            {!! Form::email('mail_from_address', config('mail.from.address'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail From Address'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_from_name') ? ' has-error' : '' }}">
                            {!! Form::label('mail_from_name', __('Mail From Name:')) !!}
                            {!! Form::text('mail_from_name', config('mail.from.name'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail From Name'), 'required'])!!}
                        </div>

                        <label>@lang('Mail Logo:')</label><br>
                        <img src="{{asset('img/'.config('custom.mail_logo'))}}" class="img-responsive" alt="Mail Logo">    
                        <br><br>

                        <div class="form-group">
                            {!! Form::label('mail_logo', __('Choose Logo'), ['class'=>'btn btn-default btn-file']) !!}
                            {!! Form::file('mail_logo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
                            <span class='label label-info' id="upload-file-info">@lang('No logo chosen')</span>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                <h4 class="text-center">@lang('Email Subject / Message')</h4>

                                <select id="select-template" class="form-control selectpicker" data-style="btn-default">
                                    <option value="order_placed">@lang('Order Placed')</option>
                                    <option value="payment_failed">@lang('Payment Failed')</option>
                                    <option value="order_processed">@lang('Order Processed')</option>
                                    <option value="order_packaged">@lang('Order Packaged')</option>
                                </select>

                                <hr>
                            </div>
                        </div>

                        <div class="order-placed">
                            <div class="form-group{{ $errors->has('mail_message_title_order_placed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_title_order_placed', __('Order Placed Mail Message Title:')) !!}
                                {!! Form::text('mail_message_title_order_placed', config('custom.mail_message_title_order_placed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title')])!!}
                            </div>

                            <div class="form-group{{ $errors->has('mail_message_order_placed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_order_placed', __('Order Placed Mail Message:')) !!}
                                {!! Form::textarea('mail_message_order_placed', config('custom.mail_message_order_placed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="payment-failed">
                            <div class="form-group{{ $errors->has('mail_message_title_payment_failed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_title_payment_failed', __('Payment Failed Mail Message Title:')) !!}
                                {!! Form::text('mail_message_title_payment_failed', config('custom.mail_message_title_payment_failed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title')])!!}
                            </div>

                            <div class="form-group{{ $errors->has('mail_message_payment_failed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_payment_failed', __('Payment Failed Mail Message:')) !!}
                                {!! Form::textarea('mail_message_payment_failed', config('custom.mail_message_payment_failed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="order-processed">
                            <div class="form-group{{ $errors->has('mail_message_title_order_processed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_title_order_processed', __('Order Processed Mail Message Title:')) !!}
                                {!! Form::text('mail_message_title_order_processed', config('custom.mail_message_title_order_processed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title')])!!}
                            </div>

                            <div class="form-group{{ $errors->has('mail_message_order_processed') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_order_processed', __('Order Processed Mail Message:')) !!}
                                {!! Form::textarea('mail_message_order_processed', config('custom.mail_message_order_processed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message'), 'rows'=>5, 'cols'=>10])!!}
                            </div>
                        </div>

                        <div class="order-packaged">
                            <div class="form-group{{ $errors->has('mail_message_title_order_packaged') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_title_order_packaged', __('Order Packaged Mail Message Title:')) !!}
                                {!! Form::text('mail_message_title_order_packaged', config('custom.mail_message_title_order_packaged'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title')])!!}
                            </div>

                            <div class="form-group{{ $errors->has('mail_message_order_packaged') ? ' has-error' : '' }}">
                                {!! Form::label('mail_message_order_packaged', __('Order Packaged Mail Message:')) !!}
                                {!! Form::textarea('mail_message_order_packaged', config('custom.mail_message_order_packaged'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message'), 'rows'=>5, 'cols'=>10])!!}
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
                        <h4 class="text-center">@lang('Email Configuration')</h4>

                        <select id="select-driver" class="form-control selectpicker" data-style="btn-default">
                            <option {{config('mail.driver') == 'smtp' ? 'selected' : ''}} value="smtp">@lang('SMTP')</option>
                            <option {{config('mail.driver') == 'mailgun' ? 'selected' : ''}} value="mailgun">@lang('Mailgun')</option>
                        </select>

                        <hr>
                    </div>
                </div>

                <div class="row smtp">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateEmailSmtp', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('mail_driver', 'smtp') !!}

                        <div class="form-group{{ $errors->has('mail_host') ? ' has-error' : '' }}">
                            {!! Form::label('mail_host', __('Mail Host:')) !!}
                            {!! Form::text('mail_host', config('mail.host'), ['class'=>'form-control', 'placeholder'=>__('smtp.mailtrap.io, smtp.mailgun.org')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_port') ? ' has-error' : '' }}">
                            {!! Form::label('mail_port', __('Mail Port:')) !!}
                            {!! Form::text('mail_port', config('mail.port'), ['class'=>'form-control', 'placeholder'=> __('2525, 465, 25')]) !!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_encryption') ? ' has-error' : '' }}">
                            {!! Form::label('mail_encryption', __('Mail Encryption:')) !!}
                            {!! Form::select('mail_encryption', [''=>__('none'), 'tls'=>__('tls'), 'ssl'=>__('ssl')], config('mail.encryption'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_username') ? ' has-error' : '' }}">
                            {!! Form::label('mail_username', __('SMTP Server Username:')) !!}
                            {!! Form::text('mail_username', config('mail.username'), ['class'=>'form-control', 'placeholder'=>__('SMTP Server Username')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_password') ? ' has-error' : '' }}">
                            {!! Form::label('mail_password', __('SMTP Server Password:')) !!}
                            {!! Form::password('mail_password', ['class'=>'form-control', 'placeholder'=>__('SMTP Server Password')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row mailgun">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateEmailMailgun', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        {!! Form::hidden('mail_driver', 'mailgun') !!}
                        {!! Form::hidden('mail_host', 'smtp.mailgun.org') !!}

                        <div class="form-group{{ $errors->has('mailgun_domain') ? ' has-error' : '' }}">
                            {!! Form::label('mailgun_domain', __('Mailgun Domain:')) !!}
                            {!! Form::text('mailgun_domain', config('services.mailgun.domain'), ['class'=>'form-control', 'placeholder'=>__('Enter Mailgun Domain'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mailgun_secret') ? ' has-error' : '' }}">
                            {!! Form::label('mailgun_secret', __('Mailgun Secret:')) !!}
                            {!! Form::text('mailgun_secret', config('services.mailgun.secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Mailgun Secret'), 'required'])!!}
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
                        <h4 class="text-center">@lang('Email Test')</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'post', 'action'=>'ManageTestController@testEmail', 'id'=>'send-test-email-form']) !!}

                        <div class="form-group{{ $errors->has('email_test_address') ? ' has-error' : '' }}">
                            {!! Form::label('email_test_address', __("Receiver's Email Address")) !!}
                            {!! Form::text('email_test_address', null, ['class'=>'form-control', 'placeholder'=>__("Enter Receiver's Email Address"), 'required']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('email_test_message') ? ' has-error' : '' }}">
                            {!! Form::label('email_test_message', __('Enter your message')) !!}
                            {!! Form::textarea('email_test_message', null, ['class'=>'form-control', 'placeholder'=> __('Enter your message'), 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Send Email'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'id'=>'send-email']) !!}
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