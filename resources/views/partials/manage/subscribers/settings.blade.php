<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

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
        <ul id="subscribers-nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#template"
                    aria-controls="template"
                    role="tab"
                    data-toggle="tab"
                >@lang('Email Template')</a>
            </li>
            <li role="presentation">
                <a href="#mailchimp"
                aria-controls="mailchimp"
                role="tab"
                data-toggle="tab"
                >@lang('MailChimp')</a>
            </li>
            <li role="presentation">
                <a href="#subsDetails"
                aria-controls="subsDetails"
                role="tab"
                data-toggle="tab"
                >@lang('Newsletter Text')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="template">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSubscribers', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Subscribers Settings')</h4>

                        {!! Form::label('mail_driver', __('Email Carrier:')) !!}
                        <select name="mail_driver" id="mail_driver" class="form-control selectpicker" data-style="btn-default">
                            <option {{config('subscribers.email_carrier') == 'smtp' ? 'selected' : ''}} value="smtp">@lang('SMTP')</option>
                            <option {{config('subscribers.email_carrier') == 'mailgun' ? 'selected' : ''}} value="mailgun">@lang('Mailgun')</option>
                        </select>
                        
                        <br>
                        <div class="form-group{{ $errors->has('mail_from_address') ? ' has-error' : '' }}">
                            {!! Form::label('mail_from_address', __('Mail From Address:')) !!}
                            {!! Form::email('mail_from_address', config('subscribers.from.address'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail From Address'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_from_name') ? ' has-error' : '' }}">
                            {!! Form::label('mail_from_name', __('Mail From Name:')) !!}
                            {!! Form::text('mail_from_name', config('subscribers.from.name'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail From Name'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_message_title_subscribed') ? ' has-error' : '' }}">
                            {!! Form::label('mail_message_title_subscribed', __('Mail Message Title:')) !!}
                            {!! Form::text('mail_message_title_subscribed', config('subscribers.mail_message_title_subscribed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mail_message_subscribed') ? ' has-error' : '' }}">
                            {!! Form::label('mail_message_subscribed', __('Mail Message:')) !!}
                            {!! Form::textarea('mail_message_subscribed', config('subscribers.mail_message_subscribed'), ['class'=>'form-control', 'placeholder'=>__('Enter Mail Message Title'), 'rows'=>5, 'cols'=>10, 'required'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="mailchimp">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateMailChimp', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('MailChimp Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="mailchimp_enable"
                                    @if(config('mailchimp.enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable MailChimp Subscription')</strong>
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('mailchimp_api') ? ' has-error' : '' }}">
                            {!! Form::label('mailchimp_api', __('MailChimp API:')) !!}
                            {!! Form::text('mailchimp_api', config('mailchimp.apikey'), ['class'=>'form-control', 'placeholder' =>__('Enter MailChimp API')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('mailchimp_list_id') ? ' has-error' : '' }}">
                            {!! Form::label('mailchimp_list_id', __('MailChimp List ID:')) !!}
                            {!! Form::text('mailchimp_list_id', config('mailchimp.list_id'), ['class'=>'form-control', 'placeholder' =>__('Enter MailChimp List ID')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="subsDetails">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateSubsDetails', 'enctype'=>'multipart/form-data','onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Front Panel Subscribers Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="subscribers_enable"
                                       @if(config('settings.enable_subscribers'))
                                       checked
                                        @endif
                                >
                                <strong>@lang('Enable Front Panel Subscribers')</strong>
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('subscribers_title') ? ' has-error' : '' }}">
                            {!! Form::label('subscribers_title', __('Subscribers Title : ')) !!}
                            {!! Form::text('subscribers_title', config('settings.subscribers_title'), ['class'=>'form-control', 'placeholder' =>__('Enter Subscribe Title')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('subscribers_cover_image') ? ' has-error' : '' }}">
                            <strong>{!! Form::label('subscribers_cover_image', __('Subscribers Background Image : '),['style'=>'display:block;']) !!}</strong>
                            {!! Form::label('subs_bg_img', __('Choose a Image File'), ['class'=>'btn btn-default btn-file']) !!}
                            {!! Form::file('subs_bg_img',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-name").html(files[0].name)']) !!}
                            <br><br>
                            <img class="img-responsive" src="{{asset('themes/theme1/img/subscribers-img.jpg') . '?v=' . time()}}">
                        </div>

                        <div class="form-group{{ $errors->has('subscribers_description') ? ' has-error' : '' }}">
                            <strong>{!! Form::label('subscribers_description', __('Subscribers Description : ')) !!}</strong>
                            {!! Form::textarea('subscribers_description', config('settings.subscribers_description'), ['class'=>'form-control', 'placeholder' =>__('Enter Subscriber Description')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('subscribers_btn_text') ? ' has-error' : '' }}">
                            <strong>{!! Form::label('subscribers_btn_text', __('Subscribers Btn Text : ')) !!}</strong>
                            {!! Form::text('subscribers_btn_text', config('settings.subscribers_btn_text'), ['class'=>'form-control', 'placeholder' =>__('Enter Subscriber Btn Text')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('subscribers_placeholder_text') ? ' has-error' : '' }}">
                            <strong>{!! Form::label('subscribers_placeholder_text', __('Subscribers Placeholder Text : ')) !!}</strong>
                            {!! Form::text('subscribers_placeholder_text', config('settings.subscribers_placeholder_text'), ['class'=>'form-control', 'placeholder' =>__('Enter Subscriber Placeholder Text')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>