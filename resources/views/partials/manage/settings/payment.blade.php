<div class="row">
    <div class="col-xs-12">

        @if(session()->has('settings_saved'))
            <div class="alert alert-success alert-dismissible" role="alert" id="alert_success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('settings_saved')}}</strong>
            </div>
        @endif

        @if(session()->has('settings_not_saved'))
            <div class="alert alert-danger alert-dismissible" role="alert" id="alert_error">
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
        <ul id="payment-nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#cod"
                    aria-controls="cod"
                    role="tab"
                    data-toggle="tab"
                >@lang('Cash on Delivery')</a>
            </li>
            <li role="presentation">
                <a href="#wallet"
                    aria-controls="wallet"
                    role="tab"
                    data-toggle="tab"
                >@lang('Wallet')</a>
            </li>
            <li role="presentation">
                <a href="#paypal"
                    aria-controls="paypal"
                    role="tab"
                    data-toggle="tab"
                >@lang('Paypal')</a>
            </li>
            <li role="presentation">
                <a href="#paystack"
                   aria-controls="paystack"
                   role="tab"
                   data-toggle="tab"
                >@lang('Paystack')</a>
            </li>
            <li role="presentation">
                <a href="#paytm"
                    aria-controls="paytm"
                    role="tab"
                    data-toggle="tab"
                >@lang('Paytm')</a>
            </li>
            <li role="presentation">
                <a href="#pesapal"
                    aria-controls="pesapal"
                    role="tab"
                    data-toggle="tab"
                >@lang('Pesapal')</a>
            </li>
            <li role="presentation">
                <a href="#stripe"
                aria-controls="stripe"
                role="tab"
                data-toggle="tab"
                >@lang('Stripe')</a>
            </li>
            <li role="presentation">
                <a href="#razorpay"
                aria-controls="razorpay"
                role="tab"
                data-toggle="tab"
                >@lang('Razorpay')</a>
            </li>
            <li role="presentation">
                <a href="#instamojo"
                aria-controls="instamojo"
                role="tab"
                data-toggle="tab"
                >@lang('Instamojo')</a>
            </li>
            <li role="presentation">
                <a href="#payu"
                aria-controls="payu"
                role="tab"
                data-toggle="tab"
                >@lang('PayUmoney / PayUbiz')</a>
            </li>
            <li role="presentation">
                <a href="#bank_transfer"
                    aria-controls="bank_transfer"
                    role="tab"
                    data-toggle="tab"
                >@lang('Bank Transfer')</a>
            </li>
            <li role="presentation">
                <a href="#cashback"
                    aria-controls="cashback"
                    role="tab"
                    data-toggle="tab"
                >@lang('Cashback')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="cod">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentCOD', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('COD Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_cod') ? ' has-error' : '' }}">
                            {!! Form::label('enable_cod', __('COD Payment:')) !!}
                            {!! Form::select('enable_cod', [true=>__('Enable'), false=>__('Disable')], config('cod.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="wallet">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentWallet', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Wallet Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_wallet') ? ' has-error' : '' }}">
                            {!! Form::label('enable_wallet', __('Wallet Use:')) !!}
                            {!! Form::select('enable_wallet', [true=>__('Enable'), false=>__('Disable')], config('wallet.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('wallet_use_percent') ? ' has-error' : '' }}">
                            {!! Form::label('wallet_use_percent', __('Wallet Use Percent:')) !!}
                            {!! Form::text('wallet_use_percent', config('wallet.percent'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Sandbox API Username')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="paypal">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPaypal', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        
                        <h4 class="text-center">@lang('Paypal Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_paypal') ? ' has-error' : '' }}">
                            {!! Form::label('enable_paypal', __('Paypal Payment:')) !!}
                            {!! Form::select('enable_paypal', [true=>__('Enable'), false=>__('Disable')], config('paypal.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_paypal_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_paypal_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_mode') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_mode', __('Paypal Mode:')) !!}
                            {!! Form::select('paypal_mode', ['sandbox'=>__('Sandbox'), 'live'=>__('Live')], config('paypal.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_sandbox_api_username') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_sandbox_api_username', __('Paypal Sandbox API Username:')) !!}
                            {!! Form::text('paypal_sandbox_api_username', config('paypal.sandbox.username'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Sandbox API Username')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_sandbox_api_password') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_sandbox_api_password', __('Paypal Sandbox API Password:')) !!}
                            {!! Form::text('paypal_sandbox_api_password', config('paypal.sandbox.password'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Sandbox API Password')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_sandbox_api_secret') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_sandbox_api_secret', __('Paypal Sandbox API Secret:')) !!}
                            {!! Form::text('paypal_sandbox_api_secret', config('paypal.sandbox.secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Sandbox API Secret')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_live_api_username') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_live_api_username', __('Paypal Live API Username:')) !!}
                            {!! Form::text('paypal_live_api_username', config('paypal.live.username'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Live API Username')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_live_api_password') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_live_api_password', __('Paypal Live API Password:')) !!}
                            {!! Form::text('paypal_live_api_password', config('paypal.live.password'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Live API Password')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paypal_live_api_secret') ? ' has-error' : '' }}">
                            {!! Form::label('paypal_live_api_secret', __('Paypal Live API Secret:')) !!}
                            {!! Form::text('paypal_live_api_secret', config('paypal.live.secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Paypal Live API Secret')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="paystack">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPaystack', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Paystack Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_paystack') ? ' has-error' : '' }}">
                            {!! Form::label('enable_paystack', __('Paystack Payment:')) !!}
                            {!! Form::select('enable_paystack', [true=>__('Enable'), false=>__('Disable')], config('paystack.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_paystack_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_paystack_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('paystack_mode') ? ' has-error' : '' }}">
                            {!! Form::label('paystack_mode', __('Paystack Mode:')) !!}
                            {!! Form::select('paystack_mode', ['sandbox'=>__('Sandbox'), 'live'=>__('Live')], config('paystack.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('paystack_sandbox_api_secret') ? ' has-error' : '' }}">
                            {!! Form::label('paystack_sandbox_api_secret', __('Paystack Sandbox API Secret Key:')) !!}
                            {!! Form::text('paystack_sandbox_api_secret', config('paystack.sandbox.secret_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Paystack Sandbox API Secret Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paystack_sandbox_api_public') ? ' has-error' : '' }}">
                            {!! Form::label('paystack_sandbox_api_public', __('Paystack Sandbox API Public Key:')) !!}
                            {!! Form::text('paystack_sandbox_api_public', config('paystack.sandbox.public_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Paystack Sandbox API Public Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paystack_live_api_secret') ? ' has-error' : '' }}">
                            {!! Form::label('paystack_live_api_secret', __('Paystack Live API Secret Key:')) !!}
                            {!! Form::text('paystack_live_api_secret', config('paystack.live.secret_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Paystack Live API Secret Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paystack_live_api_public') ? ' has-error' : '' }}">
                            {!! Form::label('paystack_live_api_public', __('Paystack Live API Public Key:')) !!}
                            {!! Form::text('paystack_live_api_public', config('paystack.live.public_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Paystack Live API Public Key')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="feature-description">
                            <h4 class="text-muted">For Using Paystack Payment Please Follow Some Simple Steps :-</h4>
                            <hr>
                            <!-- feature-left -->
                            <div class="feature-left">
                                <div class="feature-content">
                                    <p>1) Go In Settings Page of Paystack <a target="blank" href="https://dashboard.paystack.com/#/settings/developer">Settings Page</a></p>
                                </div>
                            </div>
                            <!-- /.feature-left -->
                            <!-- feature-left -->
                            <div class="feature-left">
                                <div class="feature-content">
                                    <p>2) Change the Callback Url With Your Current Website Url <br><small>Example : http://YourSite.com/public/paystack/paystack-callback</small></p>
                                </div>
                            </div>
                            <!-- /.feature-left -->
                            <!-- feature-left -->
                            <div class="feature-left">
                                <div class="feature-content">
                                    <p>3) Also Change the WebHook Url <br><small>Example : http://YourSite.com/public/paystack/paytack-handle-webhook</small> </p>
                                </div>
                            </div>
                            <!-- /.feature-left -->
                            <hr>
                            <p class="text-danger">Note: You Need to Change these Setting For Using the Paystack Payment Gateway Feature.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="paytm">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPaytm', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Paytm Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_paytm') ? ' has-error' : '' }}">
                            {!! Form::label('enable_paytm', __('Paytm Payment:')) !!}
                            {!! Form::select('enable_paytm', [true=>__('Enable'), false=>__('Disable')], config('paytm.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_paytm_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_paytm_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        {{--                        Merchant Id , Channel Id , Website --}}

                        <div class="form-group{{ $errors->has('paytm_mode') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_mode', __('Paytm Mode:')) !!}
                            {!! Form::select('paytm_mode', ['TEST'=>__('TEST'), 'PROD'=>__('PROD')], config('paytm.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('paytm_merchant_id') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_merchant_id', __('Paytm Merchant Id:')) !!}
                            {!! Form::text('paytm_merchant_id', config('paytm.m_id'), ['class'=>'form-control', 'placeholder'=>__('Enter Paytm Merchant Id')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paytm_merchant_key') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_merchant_key', __('Paytm Merchant Key:')) !!}
                            {!! Form::text('paytm_merchant_key', config('paytm.m_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Paytm Merchant Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paytm_industry_type_id') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_industry_type_id', __('Paytm Industry Type Id:')) !!}
                            {!! Form::text('paytm_industry_type_id', config('paytm.industry_type_id'), ['class'=>'form-control', 'placeholder'=>__('Enter Paytm Industry Type Id')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paytm_channel_id') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_channel_id', __('Paytm Channel Id:')) !!}
                            {!! Form::text('paytm_channel_id', config('paytm.channel_id'), ['class'=>'form-control', 'placeholder'=>__('Enter Paytm Channel Id')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('paytm_website') ? ' has-error' : '' }}">
                            {!! Form::label('paytm_website', __('Paytm Website:')) !!}
                            {!! Form::text('paytm_website', config('paytm.website'), ['class'=>'form-control', 'placeholder'=>__('Enter Paytm Website')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="pesapal">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPesapal', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Pesapal Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_pesapal') ? ' has-error' : '' }}">
                            {!! Form::label('enable_pesapal', __('Paytm Payment:')) !!}
                            {!! Form::select('enable_pesapal', [true=>__('Enable'), false=>__('Disable')], config('pesapal.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_pesapal_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_pesapal_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pesapal_mode') ? ' has-error' : '' }}">
                            {!! Form::label('pesapal_mode', __('Pesapal Mode:')) !!}
                            {!! Form::select('pesapal_mode', ['SANDBOX'=>__('SANDBOX'), 'LIVE'=>__('LIVE')], config('pesapal.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('pesapal_consumer_key') ? ' has-error' : '' }}">
                            {!! Form::label('pesapal_consumer_key', __('Consumer Key:')) !!}
                            {!! Form::text('pesapal_consumer_key', config('pesapal.consumer_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Pesapal Consumer Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('pesapal_consumer_secret_key') ? ' has-error' : '' }}">
                            {!! Form::label('pesapal_consumer_secret_key', __('Pesapal Consumer Secret Key:')) !!}
                            {!! Form::text('pesapal_consumer_secret_key', config('pesapal.consumer_secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Pesapal Consumer Secret Key')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="stripe">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentStripe', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Stripe Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_stripe') ? ' has-error' : '' }}">
                            {!! Form::label('enable_stripe', __('Stripe Payment:')) !!}
                            {!! Form::select('enable_stripe', [true=>__('Enable'), false=>__('Disable')], config('stripe.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_stripe_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_stripe_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('stripe_key') ? ' has-error' : '' }}">
                            {!! Form::label('stripe_key', __('Stripe Key:')) !!}
                            {!! Form::text('stripe_key', config('stripe.stripe_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Stripe Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('stripe_secret') ? ' has-error' : '' }}">
                            {!! Form::label('stripe_secret', __('Stripe Secret:')) !!}
                            {!! Form::text('stripe_secret', config('stripe.stripe_secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Stripe Secret')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="razorpay">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentRazorpay', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Razorpay Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_razorpay') ? ' has-error' : '' }}">
                            {!! Form::label('enable_razorpay', __('Razorpay Payment:')) !!}
                            {!! Form::select('enable_razorpay', [true=>__('Enable'), false=>__('Disable')], config('razorpay.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_razorpay_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_razorpay_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('razor_key') ? ' has-error' : '' }}">
                            {!! Form::label('razor_key', __('Razorpay Key:')) !!}
                            {!! Form::text('razor_key', config('razorpay.razor_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Razorpay Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('razor_secret') ? ' has-error' : '' }}">
                            {!! Form::label('razor_secret', __('Razorpay Secret:')) !!}
                            {!! Form::text('razor_secret', config('razorpay.razor_secret'), ['class'=>'form-control', 'placeholder'=>__('Enter Razorpay Secret')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="instamojo">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentInstamojo', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Instamojo Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_instamojo') ? ' has-error' : '' }}">
                            {!! Form::label('enable_instamojo', __('Instamojo Payment:')) !!}
                            {!! Form::select('enable_instamojo', [true=>__('Enable'), false=>__('Disable')], config('instamojo.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_instamojo_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_instamojo_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('instamojo_mode') ? ' has-error' : '' }}">
                            {!! Form::label('instamojo_mode', __('Instamojo Mode:')) !!}
                            {!! Form::select('instamojo_mode', ['test'=>__('Test'), 'live'=>__('Live')], config('instamojo.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('instamojo_api_key') ? ' has-error' : '' }}">
                            {!! Form::label('instamojo_api_key', __('Instamojo API Key:')) !!}
                            {!! Form::text('instamojo_api_key', config('instamojo.instamojo_api_key'), ['class'=>'form-control', 'placeholder'=>__('Enter Instamojo Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('instamojo_auth_token') ? ' has-error' : '' }}">
                            {!! Form::label('instamojo_auth_token', __('Instamojo Auth Token:')) !!}
                            {!! Form::text('instamojo_auth_token', config('instamojo.instamojo_auth_token'), ['class'=>'form-control', 'placeholder'=>__('Enter Instamojo Secret')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="payu">
                
                <div class="row">
                    <div class=".col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        <p class="text-center">@lang('You can either use PayUbiz or PayUmoney.')</p>
                        <h4 class="text-center text-muted">@lang('Current Mode:') {{config('payu.default')}}</h4>
                        <select class="form-control selectpicker" data-style="btn-defualt" id="payu-selector">
                            <option {{(config('payu.default') == 'payubiz') ? 'selected' : null}} value="payubiz">@lang('PayUbiz')</option>
                            <option {{(config('payu.default') == 'payumoney') ? 'selected' : null}} value="payumoney">@lang('PayUmoney')</option>
                        </select>
                    </div> 
                </div>
                <div class="row" id="payu-money">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPayUmoney', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        
                        <h4 class="text-center">@lang('PayUmoney Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_payumoney') ? ' has-error' : '' }}">
                            {!! Form::label('enable_payumoney', __('PayUmoney Payment:')) !!}
                            {!! Form::select('enable_payumoney', [true=>__('Enable'), false=>__('Disable')], config('payu.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_payumoney_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_payumoney_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('payumoney_mode') ? ' has-error' : '' }}">
                            {!! Form::label('payumoney_mode', __('PayUmoney Mode:')) !!}
                            {!! Form::select('payumoney_mode', ['test'=>__('Test'), 'secure'=>__('Live')], config('payu.env'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('payumoney_merchant_key') ? ' has-error' : '' }}">
                            {!! Form::label('payumoney_merchant_key', __('PayUmoney Merchant Key:')) !!}
                            {!! Form::text('payumoney_merchant_key', config('payu.accounts.payumoney.key'), ['class'=>'form-control', 'placeholder'=>__('Enter PayUmoney Merchant Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('payumoney_merchant_salt') ? ' has-error' : '' }}">
                            {!! Form::label('payumoney_merchant_salt', __('PayUmoney Merchant Salt:')) !!}
                            {!! Form::text('payumoney_merchant_salt', config('payu.accounts.payumoney.salt'), ['class'=>'form-control', 'placeholder'=>__('Enter PayUmoney Merchant Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('payumoney_auth_token') ? ' has-error' : '' }}">
                            {!! Form::label('payumoney_auth_token', __('PayUmoney Auth Token:')) !!}
                            {!! Form::text('payumoney_auth_token', config('payu.accounts.payumoney.auth'), ['class'=>'form-control', 'placeholder'=>__('Enter PayUmoney Merchant Key')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="row" id="payu-biz">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentPayUbiz', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        
                        <h4 class="text-center">@lang('PayUbiz Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_payubiz') ? ' has-error' : '' }}">
                            {!! Form::label('enable_payubiz', __('PayUbiz Payment:')) !!}
                            {!! Form::select('enable_payubiz', [true=>__('Enable'), false=>__('Disable')], config('payu.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkPaymentEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_payubiz_error', __('This Payment Method Can\'t be Use with your Default Currency'), ['id' => 'enable_payubiz_error','class' => 'text-danger','style' => 'display : none']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('payubiz_mode') ? ' has-error' : '' }}">
                            {!! Form::label('payubiz_mode', __('PayUbiz Mode:')) !!}
                            {!! Form::select('payubiz_mode', ['test'=>__('Test'), 'secure'=>__('Live')], config('payu.env'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('payubiz_merchant_key') ? ' has-error' : '' }}">
                            {!! Form::label('payubiz_merchant_key', __('PayUbiz Merchant Key:')) !!}
                            {!! Form::text('payubiz_merchant_key', config('payu.accounts.payubiz.key'), ['class'=>'form-control', 'placeholder'=>__('Enter PayUbiz Merchant Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('payubiz_merchant_salt') ? ' has-error' : '' }}">
                            {!! Form::label('payubiz_merchant_salt', __('PayUbiz Merchant Salt:')) !!}
                            {!! Form::text('payubiz_merchant_salt', config('payu.accounts.payubiz.salt'), ['class'=>'form-control', 'placeholder'=>__('Enter PayUbiz Merchant Key')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="bank_transfer">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentBankTransfer', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Bank Transfer Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_bank_transfer') ? ' has-error' : '' }}">
                            {!! Form::label('enable_bank_transfer', __('Bank Transfer:')) !!}
                            {!! Form::select('enable_bank_transfer', [true=>__('Enable'), false=>__('Disable')], config('banktransfer.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                            {!! Form::label('bank_transfer_account_number', __('Account Number:')) !!}
                            {!! Form::text('bank_transfer_account_number', config('banktransfer.account_number'), ['class'=>'form-control', 'placeholder'=>__('Enter Account Number')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('branch_code') ? ' has-error' : '' }}">
                            {!! Form::label('bank_transfer_branch_code', __('Branch Code:')) !!}
                            {!! Form::text('bank_transfer_branch_code', config('banktransfer.branch_code'), ['class'=>'form-control', 'placeholder'=>__('Enter Branch Code')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('branch_code_label') ? ' has-error' : '' }}">
                            {!! Form::label('bank_transfer_branch_code_label', __('Branch Code Label:')) !!}
                            {!! Form::text('bank_transfer_branch_code_label', config('banktransfer.branch_code_label'), ['class'=>'form-control', 'placeholder'=>__('Enter Branch Code Label')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('bank_transfer_name', __('Name:')) !!}
                            {!! Form::text('bank_transfer_name', config('banktransfer.name'), ['class'=>'form-control', 'placeholder'=>__('Enter Name')])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="cashback">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePaymentCashback', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('Cashback Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_cashback') ? ' has-error' : '' }}">
                            {!! Form::label('enable_cashback', __('Cashback System:')) !!}
                            {!! Form::select('enable_cashback', [true=>__('Enable'), false=>__('Disable')], config('cashback.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>
                        <div class="form-group{{ $errors->has('cashback_type') ? ' has-error' : '' }}">
                            {!! Form::label('cashback_type', __('Cashback Type:')) !!}
                            {!! Form::select('cashback_type', ['FLAT'=>__('FLAT'), 'PERCENT'=>__('PERCENT')], config('cashback.type'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('order_max_amt') ? ' has-error' : '' }}">
                            {!! Form::label('order_max_amt', __('Order Minimum Amount')) !!}
                            {!! Form::number('order_max_amt', config('cashback.max_order_amt'), ['class'=>'form-control', 'placeholder'=>__('Enter Minimun Order Amount')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('max_user_usage') ? ' has-error' : '' }}">
                            {!! Form::label('max_user_usage', __('Maximum User Usage:')) !!}
                            {!! Form::text('max_user_usage', config('cashback.max_usage'), ['class'=>'form-control', 'placeholder'=>__('Enter Maximum User Usage')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('cashback_amt') ? ' has-error' : '' }}">
                            {!! Form::label('cashback_amt', __('Cashback Amount:')) !!}
                            {!! Form::text('cashback_amt', config('cashback.amount'), ['class'=>'form-control', 'placeholder'=>__('Enter Cashback Amount')])!!}
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
