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
                <strong>{{session('settings_not_saved')}}</strong>
            </div>
        @endif
        @include('includes.form_errors')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul id="settings-nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#store"
                    aria-controls="store"
                    role="tab"
                    data-toggle="tab"
                >@lang('Store')</a>
            </li>
            <li role="presentation">
                <a href="#theme"
                    aria-controls="theme"
                    role="tab"
                    data-toggle="tab"
                >@lang('Theme')</a>
            </li>
            <li role="presentation">
                <a href="#chat"
                    aria-controls="chat"
                    role="tab"
                    data-toggle="tab"
                >@lang('Live Chat')</a>
            </li>
            <li role="presentation">
                <a href="#tax-shipping"
                    aria-controls="tax-shipping"
                    role="tab"
                    data-toggle="tab"
                >@lang('Tax / Shipping')</a>
            </li>
            <li role="presentation">
                <a href="#vendor"
                    aria-controls="vendor"
                    role="tab"
                    data-toggle="tab"
                >@lang('Vendor')</a>
            </li>
            <li role="presentation">
                <a href="#admin-panel"
                    aria-controls="admin-panel"
                    role="tab"
                    data-toggle="tab"
                >@lang('Admin Panel')</a>
            </li>
            <li role="presentation">
                <a href="#recaptcha"
                    aria-controls="recaptcha"
                    role="tab"
                    data-toggle="tab"
                >@lang('Google Recaptcha')</a>
            </li>
            <li role="presentation">
                <a href="#map"
                    aria-controls="map"
                    role="tab"
                    data-toggle="tab"
                >@lang('Google Map')</a>
            </li>
            <li role="presentation">
                <a href="#analytics"
                   aria-controls="analytics"
                   role="tab"
                   data-toggle="tab"
                >@lang('Google Analytics')</a>
            </li>
            <li role="presentation">
                <a href="#site-map"
                   aria-controls="site-map"
                   role="tab"
                   data-toggle="tab"
                >@lang('Site Map')</a>
            </li>
            <li role="presentation">
                <a href="#referral"
                   aria-controls="referral"
                   role="tab"
                   data-toggle="tab"
                >@lang('Referral')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="store">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateStore', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Store Settings')</h4>
                        
                        <hr>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="maintenance_enable"
                                    @if(\App::isDownForMaintenance())
                                        checked
                                    @endif
                                >
                                    <strong class="text-danger">@lang('Enable Maintenance Mode')</strong>
                            </label>
                        </div>
                        <hr>

                        <div class="form-group{{ $errors->has('contact_email') ? ' has-error' : '' }}">
                            {!! Form::label('contact_email', __('Contact Email:')) !!}
                            {!! Form::email('contact_email', array_has($settings, 'contact_email') ? $settings['contact_email'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter contact email'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                            {!! Form::label('contact_number', __('Contact Number:')) !!}
                            {!! Form::text('contact_number', array_has($settings, 'contact_number') ? $settings['contact_number'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter contact number')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('site_logo_name') ? ' has-error' : '' }}">
                            {!! Form::label('site_logo_name', __('Logo Name:')) !!}
                            {!! Form::text('site_logo_name', array_has($settings, 'site_logo_name') ? $settings['site_logo_name'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter logo name')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('site_logo_colour') ? ' has-error' : '' }}">
                            {!! Form::label('site_logo_colour', __('Logo Background Colour (eg. #a70303, rgb(255,0,255), green):')) !!}
                            {!! Form::text('site_logo_colour', array_has($settings, 'site_logo_colour') ? $settings['site_logo_colour'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter logo background colour'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('site_logo_width') ? ' has-error' : '' }}">
                            {!! Form::label('site_logo_width', __('Logo Width (eg. 70px):')) !!}
                            {!! Form::text('site_logo_width', array_has($settings, 'site_logo_width') ? $settings['site_logo_width'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter logo width'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('site_logo_height') ? ' has-error' : '' }}">
                            {!! Form::label('site_logo_height', __('Logo Height (eg. 40px):')) !!}
                            {!! Form::text('site_logo_height', array_has($settings, 'site_logo_height') ? $settings['site_logo_height'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter logo height'), 'required'])!!}
                        </div>

                        <hr>

                        <img width="120" src="{{asset('img/'.config('settings.site_logo'))}}" class="img-responsive" alt="Site Logo">    
                        <br><br>

                        <div class="form-group">
                            {!! Form::label('logo', __('Choose Site Logo'), ['class'=>'btn btn-default btn-file']) !!}
                            {!! Form::file('logo',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info").html(files[0].name)']) !!}
                            <span class='label label-info' id="upload-file-info">@lang('No image chosen')</span>
                        </div>

                        <hr>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="site_logo_enable"
                                    @if(config('settings.site_logo_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Site Logo')</strong>
                            </label>
                        </div>

                        <hr>

                        <img width="40" src="{{url('/favicon.ico')}}" class="img-responsive" alt="Site Favicon">    
                        <br><br>

                        <div class="form-group">
                            {!! Form::label('site_favicon', __('Choose Site Favicon'), ['class'=>'btn btn-default btn-file']) !!}
                            {!! Form::file('site_favicon',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-info-favicon").html(files[0].name)']) !!}
                            <span class='label label-info' id="upload-file-info-favicon">@lang('No image chosen')</span>
                        </div>

                        <div class="form-group{{ $errors->has('pagination_count') ? ' has-error' : '' }}">
                            {!! Form::label('pagination_count', __('Pagination Counts')) !!}
                            {!! Form::number('pagination_count', array_has($settings, 'pagination_count') ? $settings['pagination_count'] : null, ['class'=>'form-control', 'min'=> 1, 'max'=> 999, 'placeholder'=>__('Enter Number of Items Per Page'), 'required'])!!}
                        </div>

                        <div class="form-group{{ $errors->has('about_us_title') ? ' has-error' : '' }}">
                            {!! Form::label('about_us_title', __('About Us Title:')) !!}
                            {!! Form::text('about_us_title', array_has($settings, 'about_us_title') ? $settings['about_us_title'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter about us title'), 'required'])!!}
                        </div>

                        <hr>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="banners_right_side_enable"
                                    @if(config('settings.banners_right_side_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Sidebar')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="enable_google_translation"
                                    @if(config('settings.enable_google_translation'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Google Translation')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="main_slider_enable"
                                    @if(config('settings.main_slider_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Main Slider')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="categories_slider_enable"
                                    @if(config('settings.categories_slider_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Categories Slider')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="brands_slider_enable"
                                    @if(config('settings.brands_slider_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Brands Slider')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="products_slider_enable"
                                    @if(config('settings.products_slider_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Products Slider')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="hide_main_slider_in_devices"
                                    @if(config('settings.hide_main_slider_in_devices'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Hide Main Slider in Small Devices')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="footer_enable"
                                    @if(config('settings.footer_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Footer')</strong>
                            </label>
                        </div>

                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">
                                    <a data-toggle="collapse" href="#collapse2">
                                        <div><strong>@lang('Social Share')</strong></div>
                                    </a>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="social_share_enable"
                                                       @if(config('settings.social_share_enable'))
                                                       checked
                                                        @endif
                                                >
                                                <strong>@lang('Enable Social Share')</strong>
                                            </label>
                                        </div>

                                        <div class="form-group{{ $errors->has('facebook_app_id') ? ' has-error' : '' }}">
                                            {!! Form::label('facebook_app_id', __('Facebook App ID:')) !!}
                                            {!! Form::text('facebook_app_id', array_has($settings, 'facebook_app_id') ? $settings['facebook_app_id'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Facebook App ID')])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">
                                    <a data-toggle="collapse" href="#collapse1">
                                        <div><strong>@lang('Social Links')</strong></div>
                                    </a>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    name="social_link_facebook_enable"
                                                    @if(config('settings.social_link_facebook_enable'))
                                                        checked
                                                    @endif
                                                >
                                                    <strong>@lang('Facebook')</strong>
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="social_link_instagram_enable"
                                                       @if(config('settings.social_link_instagram_enable'))
                                                       checked
                                                        @endif
                                                >
                                                <strong>@lang('Instagram')</strong>
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    name="social_link_twitter_enable"
                                                    @if(config('settings.social_link_twitter_enable'))
                                                        checked
                                                    @endif
                                                >
                                                    <strong>@lang('Twitter')</strong>
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    name="social_link_youtube_enable"
                                                    @if(config('settings.social_link_youtube_enable'))
                                                        checked
                                                    @endif
                                                >
                                                    <strong>@lang('Youtube')</strong>
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="social_link_google_plus_enable"
                                                       @if(config('settings.social_link_google_plus_enable'))
                                                       checked
                                                        @endif
                                                >
                                                <strong>@lang('Google Plus')</strong>
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="social_link_linkedin_enable"
                                                       @if(config('settings.social_link_linkedin_enable'))
                                                       checked
                                                        @endif
                                                >
                                                <strong>@lang('Linkedin')</strong>
                                            </label>
                                        </div>

                                        <br>
                                        <div class="form-group{{ $errors->has('social_link_facebook') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_facebook', __('Facebook Link:')) !!}
                                            {!! Form::text('social_link_facebook', array_has($settings, 'social_link_facebook') ? $settings['social_link_facebook'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Facebook Link')])!!}
                                        </div>

                                        <div class="form-group{{ $errors->has('social_link_instagram') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_instagram', __('Instagram Link:')) !!}
                                            {!! Form::text('social_link_instagram', array_has($settings, 'social_link_instagram') ? $settings['social_link_instagram'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Instagram Link')])!!}
                                        </div>

                                        <div class="form-group{{ $errors->has('social_link_twitter') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_twitter', __('Twitter Link:')) !!}
                                            {!! Form::text('social_link_twitter', array_has($settings, 'social_link_twitter') ? $settings['social_link_twitter'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Twitter Link')])!!}
                                        </div>

                                        <div class="form-group{{ $errors->has('social_link_youtube') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_youtube', __('Youtube Link:')) !!}
                                            {!! Form::text('social_link_youtube', array_has($settings, 'social_link_youtube') ? $settings['social_link_youtube'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Youtube Link')])!!}
                                        </div>

                                        <div class="form-group{{ $errors->has('social_link_google_plus') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_google_plus', __('Google Plus:')) !!}
                                            {!! Form::text('social_link_google_plus', array_has($settings, 'social_link_google_plus') ? $settings['social_link_google_plus'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Google Plus Link')])!!}
                                        </div>

                                        <div class="form-group{{ $errors->has('social_link_linkedin') ? ' has-error' : '' }}">
                                            {!! Form::label('social_link_linkedin', __('Linkedin Link:')) !!}
                                            {!! Form::text('social_link_linkedin', array_has($settings, 'social_link_linkedin') ? $settings['social_link_linkedin'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter Linkedin Link')])!!}
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

            </div>

            <div role="tabpanel" class="tab-pane" id="theme">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateTheme', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Theme Settings')</h4>

                        <div class="form-group{{ $errors->has('theme') ? ' has-error' : '' }}">
                            {!! Form::label('theme', __('Theme:')) !!}
                            {!! Form::select('theme', $themes, config('themeswitcher.current_theme'), ['class'=>'form-control', 'required'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="chat">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateLiveChat', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Live Chat Settings')</h4>

                        <div class="form-group{{ $errors->has('tawk_widget_code') ? ' has-error' : '' }}">
                            {!! Form::label('tawk_widget_code', __('Tawk Widget Code:')) !!}
                            {!! Form::textarea('tawk_widget_code', config('livechat.tawk_widget_code'), ['class'=>'form-control', 'placeholder'=>__('Enter Tawk Widget Code')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="tax-shipping">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateTaxShipping', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Tax / Shipping Settings')</h4>

                        <div class="form-group{{ $errors->has('tax_rate') ? ' has-error' : '' }}">
                            {!! Form::label('tax_rate', __('Tax Rate (in %):')) !!}
                            {!! Form::number('tax_rate', array_has($settings, 'tax_rate') ? $settings['tax_rate'] : null, ['class'=>'form-control', 'step'=>'any', 'min'=>0, 'max'=>100, 'placeholder'=>__('Enter tax rate'), 'required']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('shipping_cost') ? ' has-error' : '' }}">
                            {!! Form::label('shipping_cost', __('Shipping Cost:')) !!}
                            {!! Form::number('shipping_cost', array_has($settings, 'shipping_cost') ? $settings['shipping_cost'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter shipping cost'), 'required']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('shipping_cost_valid_below') ? ' has-error' : '' }}">
                            {!! Form::label('shipping_cost_valid_below', __('Shipping Cost applies below price:')) !!}
                            {!! Form::number('shipping_cost_valid_below', array_has($settings, 'shipping_cost_valid_below') ? $settings['shipping_cost_valid_below'] : null, ['class'=>'form-control', 'placeholder'=>__('Enter price below which shipping cost applies'), 'required', 'min'=>0, 'step'=>'any']) !!}
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="enable_zip_code"
                                       @if(config('settings.enable_zip_code'))
                                       checked
                                        @endif
                                >
                                <strong>@lang('Enable Pin Code Check')</strong>
                            </label>
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="vendor">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateVendor', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Vendor Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="enable_vendor_signup"
                                    @if(config('vendor.enable_vendor_signup'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Vendor Signup')</strong>
                            </label>
                        </div>

                        <hr>

                        <div class="form-group{{ $errors->has('minimum_amount_for_request') ? ' has-error' : '' }}">
                            {!! Form::label('minimum_amount_for_request', __('Minimum Amount required for Vendors before making Payment Requests.')) !!}
                            {!! Form::number('minimum_amount_for_request', config('vendor.minimum_amount_for_request'), ['class'=>'form-control', 'step'=>'any', 'min'=>0, 'placeholder'=>__('Enter minimum amount required for vendors before making payment requests.'), 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="admin-panel">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateAdminPanel', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Admin Panel Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="export_table_enable"
                                    @if(config('settings.export_table_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Table Data Export')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="toast_notifications_enable"
                                    @if(config('settings.toast_notifications_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Toast Notifications')</strong>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="loading_animation_enable"
                                    @if(config('settings.loading_animation_enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Loading Animation')</strong>
                            </label>
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="recaptcha">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateRecaptcha', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Google Recaptcha Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                    name="enable_recaptcha"
                                    @if(config('recaptcha.enable'))
                                        checked
                                    @endif
                                >
                                    <strong>@lang('Enable Google Recaptcha')</strong>
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('recaptcha_public_key') ? ' has-error' : '' }}">
                            {!! Form::label('recaptcha_public_key', __('Public Key or Site Key:')) !!}
                            {!! Form::text('recaptcha_public_key', config('recaptcha.public_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Public Key or Site Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('recaptcha_private_key') ? ' has-error' : '' }}">
                            {!! Form::label('recaptcha_private_key', __('Private Key or Secret Key:')) !!}
                            {!! Form::text('recaptcha_private_key', config('recaptcha.private_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Private Key or Secret Key')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="map">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateGoogleMap', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Google Map Settings')</h4>

                        <div class="form-group{{ $errors->has('map_embed_code') ? ' has-error' : '' }}">
                            {!! Form::label('map_embed_code', __('Embed Code:')) !!}
                            {!! Form::textarea('map_embed_code', config('googlemap.embed_code'), ['class'=>'form-control', 'placeholder'=>__('Enter Embed Code'), 'rows'=>5])!!}
                        </div>

                        <hr>
                        <div class="text-center text-primary"><strong>@lang('OR')</strong></div>
                        <hr>

                        <div class="form-group{{ $errors->has('map_api_key') ? ' has-error' : '' }}">
                            {!! Form::label('map_api_key', __('API Key:')) !!}
                            {!! Form::text('map_api_key', config('googlemap.api_key'), ['class'=>'form-control', 'placeholder'=>__('Enter API Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('map_location') ? ' has-error' : '' }}">
                            {!! Form::label('map_location', __('Location Name:')) !!}
                            {!! Form::text('map_location', config('googlemap.location_name'), ['class'=>'form-control', 'placeholder'=>__('Enter Location Name')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('map_zoom') ? ' has-error' : '' }}">
                            {!! Form::label('map_zoom', __('Zoom Level:')) !!}
                            {!! Form::number('map_zoom', config('googlemap.zoom'), ['class'=>'form-control', 'placeholder'=>__('Enter Zoom Level')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="analytics">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateGoogleAnalytics', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Google Analytics Settings')</h4>

                        <div class="form-group{{ $errors->has('map_embed_code') ? ' has-error' : '' }}">
                            {!! Form::label('tracking_code', __('Tracking Code:')) !!}
                            {!! Form::textarea('tracking_code', config('analytics.google_analytics_script'), ['class'=>'form-control', 'placeholder'=>__('Enter Tracking Code'), 'rows'=>10, 'cols'=>10])!!}
                        </div>
                        <br><br>
                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="site-map">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateSiteMap', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Site Map Settings')</h4>

                        <div class="form-group{{ $errors->has('site_map_file') ? ' has-error' : '' }}">
                            {!! Form::label('site_map_file', __('Select Site Map File'), ['class'=>'btn btn-default btn-file']) !!}
                            {!! Form::file('site_map_file',['class'=>'form-control','accept'=>'.xml', 'style'=>'display: none;','onchange'=>'$("#upload-sitemap-file-info").html(files[0].name)']) !!}
                            <span class='label label-info' id="upload-sitemap-file-info">@lang('No File chosen')</span>
                            <br>
                            <small class="text-primary"> ( @lang('Only XML File Format Supported*') )</small>
                        </div>
                        <hr>
                        <div class="form-group{{ $errors->has('site_map_url') ? ' has-error' : '' }}">
                            {!! Form::label('site_map_url', __('Site Map Url :')) !!}
                            {!! Form::text('site_map_url', config('site_map.site_map_url'), ['class'=>'form-control', 'placeholder'=>__('Enter Site Map Url')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="referral">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageSettingsController@updateReferral', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        <h4 class="text-center">@lang('Referral System Settings')</h4>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="enable_referral"
                                       @if(config('referral.enable'))
                                       checked
                                        @endif
                                >
                                <strong>@lang('Enable Referral System')</strong>
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('referral_to_amt') ? ' has-error' : '' }}">
                            {!! Form::label('referral_to_amt', __('Referral To Amount :')) !!}
                            {!! Form::number('referral_to_amt', config('referral.referral_to_amt'), ['class'=>'form-control', 'placeholder'=>__('Enter amount for a person who use referral code')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('referral_by_amt') ? ' has-error' : '' }}">
                            {!! Form::label('referral_by_amt', __('Referral By Amount :')) !!}
                            {!! Form::number('referral_by_amt', config('referral.referral_by_amt'), ['class'=>'form-control', 'placeholder'=>__('Enter amount for a person whose referral code is used')])!!}
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