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
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateBusiness', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <h4 class="text-center">@lang('Business Settings')</h4>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('App Name:')) !!}
            {!! Form::text('name', config('app.name'), ['class'=>'form-control', 'placeholder'=>__('App Name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
            {!! Form::label('url', __('App URL / Site URL:')) !!}
            {!! Form::text('url', config('app.url'), ['class'=>'form-control', 'placeholder'=>__('App URL'), 'required'])!!}
        </div>

        <hr>

        <div class="form-group{{ $errors->has('terms_of_service_url') ? ' has-error' : '' }}">
            {!! Form::label('terms_of_service_url', __('Terms of Service URL:')) !!}
            {!! Form::text('terms_of_service_url', config('settings.terms_of_service_url'), ['class'=>'form-control', 'placeholder'=>__('Terms of Service URL')])!!}
        </div>

        <div class="form-group{{ $errors->has('privacy_policy_url') ? ' has-error' : '' }}">
            {!! Form::label('privacy_policy_url', __('Privacy Policy URL:')) !!}
            {!! Form::text('privacy_policy_url', config('settings.privacy_policy_url'), ['class'=>'form-control', 'placeholder'=>__('Privacy Policy URL')])!!}
        </div>

        <div class="form-group{{ $errors->has('copyright_text') ? ' has-error' : '' }}">
            {!! Form::label('copyright_text', __('Copyright Text:')) !!}
            {!! Form::text('copyright_text', config('settings.copyright_text'), ['class'=>'form-control', 'placeholder'=>__('Copyright Text')])!!}
        </div>

        <hr>
        <div class="form-group{{ $errors->has('admin_country_code') ? ' has-error' : '' }}">
            {!! Form::label('admin_country_code', __('Country Code:')) !!}
            {!! Form::text('admin_country_code', config('googlemap.admin_country_code'), ['class'=>'form-control', 'placeholder'=>__('Enter Country Code')])!!}
        </div>

        <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
            {!! Form::label('timezone', __('Timezone:')) !!}
            {!! Form::select('timezone', $timezones, config('app.timezone'), ['class'=>'form-control', 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
            {!! Form::label('currency', __('Currency:')) !!}
            {!! Form::select('currency', $currencies, config('currency.default'), ['class'=>'form-control', 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
            {!! Form::label('language', __('Language:')) !!}
            {!! Form::select('language', $languages, config('app.locale'), ['class'=>'form-control', 'required'])!!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="allow_multi_language" value="1" @if(config('settings.allow_multi_language')) checked @endif>
                <strong>@lang('Allow Multi-Langauge Selector')</strong>
            </label>
        </div>
{{--        <span>--}}
{{--            To translate <strong>Web-Cart</strong> in your language, please use the language files inside of folder <strong>"resources/lang/"</strong>. When the translation is completed, please email us with translation files (For example: <strong>de.json</strong> and all files inside of <strong>resources/lang/de/</strong> folder) to <strong><a href="mailto:lizarweb@gmail.com">lizarweb@gmail.com</a></strong>. Then, we will verify the translation files and support this language in future updates.--}}
{{--        </span>--}}
        <hr>

        <div class="form-group{{ $errors->has('currencyconverterapi_key') ? ' has-error' : '' }}">
            {!! Form::label('currencyconverterapi_key', __('CurrencyConverterAPI Key:')) !!}
            <small><br>@lang('In case you are using payment methods which supports different currencies than currently set.') <a href="http://currencyconverterapi.com/" target="_blank">@lang('Click to get your API key')</a></small>
            {!! Form::text('currencyconverterapi_key', config('settings.currencyconverterapi_key'), ['class'=>'form-control', 'placeholder'=>__('Enter currency converter API key')])!!}
        </div>

        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <a data-toggle="collapse" href="#collapse1">
                        <div><strong>@lang('SEO')</strong></div>
                    </a>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', __('Meta Title:')) !!}
                            {!! Form::text('title', config('custom.meta_title'), ['class'=>'form-control', 'placeholder'=>__('Enter meta title')]) !!}
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', __('Meta Description:')) !!}
                            {!! Form::textarea('description', config('custom.meta_description'), ['rows'=>6, 'class'=>'form-control', 'placeholder'=>__('Enter meta description')]) !!}
                        </div>
                        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
                            {!! Form::label('keywords', __('Meta Keywords:')) !!}
                            {!! Form::textarea('keywords', config('custom.meta_keywords'), ['rows'=>3, 'class'=>'form-control', 'placeholder'=>__('Enter meta keywords')]) !!}
                        </div>
                        <div class="form-group{{ $errors->has('google_analytics_script') ? ' has-error' : '' }}">
                            {!! Form::label('google_analytics_script', __('Google Analytics Script:')) !!}
                            {!! Form::textarea('google_analytics_script', config('analytics.google_analytics_script'), ['class'=>'form-control', 'placeholder'=>__('Enter Google Analytics Script')])!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>