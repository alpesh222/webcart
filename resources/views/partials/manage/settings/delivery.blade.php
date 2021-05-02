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
        <ul id="delivery-nav-tabs" class="nav nav-tabs" role="tablist">
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
        </ul>

        <div class="tab-content text-justify">
            <div role="tabpanel" class="tab-pane active" id="template">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateDeliveryTemplate', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center custom_delivery_h4">@lang('Delivery Service')</h4>

                        <div class="form-group{{ $errors->has('enable_delivery') ? ' has-error' : '' }}">
                            {!! Form::select('enable_delivery', [true=>__('Enable'), false=>__('Disable')], config('delivery.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group custom_submit_btn">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane" id="configuration">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        <h4 class="text-center custom_delivery_h4">@lang('Delivery Configuration')</h4>
                        <select id="select-driver" class="form-control selectpicker" data-style="btn-default">
                            <option {{config('delivery.service') == 'delhivery' ? 'selected' : ''}} value="delhivery">@lang('Delhivery Service')</option>
                        </select>
                        <hr>
                    </div>
                </div>

                <div class="row delhivery">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
     
                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateDeliveryDelhivery', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        
                        <h4 class="text-center custom_delivery_h4">@lang('Delhivery Services Settings')</h4>

                        <div class="form-group{{ $errors->has('enable_delhivery') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('enable_delhivery', __('Delhivery Services:')) !!}
                            {!! Form::select('enable_delhivery', [true=>__('Enable'), false=>__('Disable')], config('delhivery.enable'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'onchange'=>'checkDeliveryEnable(this.id,this.value)']) !!}
                            {!! Form::label('enable_delhivery_error', __('This Delivery Service Can\'t be Use with your Default Currency'), ['id' => 'enable_delhivery_error','class' => 'text-danger','style' => 'display : none;position:absolute;']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('delhivery_mode') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('delhivery_mode', __('Delhivery Mode:')) !!}
                            {!! Form::select('delhivery_mode', ['sandbox'=>__('Sandbox'), 'live'=>__('Live')], config('delhivery.mode'), ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('delhivery_sandbox_api_key') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('delhivery_sandbox_api_key', __('Delhivery Sandbox API Key:')) !!}
                            {!! Form::text('delhivery_sandbox_api_key', config('delhivery.api_key.sandbox'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Sandbox API Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('delhivery_sandbox_client_name') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('delhivery_sandbox_client_name', __('Delhivery Sandbox Client Name:')) !!}
                            {!! Form::text('delhivery_sandbox_client_name', config('delhivery.client_name.sandbox'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Sandbox Client Name')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('delhivery_live_api_key') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('delhivery_live_api_key', __('Delhivery Live API Key:')) !!}
                            {!! Form::text('delhivery_live_api_key', config('delhivery.api_key.live'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Live API Key')])!!}
                        </div>

                        <div class="form-group{{ $errors->has('delhivery_live_client_name') ? ' has-error' : '' }} col-md-6">
                            {!! Form::label('delhivery_live_client_name', __('Delhivery Live Client Name:')) !!}
                            {!! Form::text('delhivery_live_client_name', config('delhivery.client_name.live'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Live Client Name')])!!}
                        </div>


                        <div class="card col-md-5 custom_card_box_css">
                            <div class="card-header">
                                <h4>@lang('WareHouse Details')</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group{{ $errors->has('warehouse_name') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_name', __('Delhivery Warehouse Name:')) !!}
                                    {!! Form::text('warehouse_name', config('delhivery.warehouse_name'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse Name')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('warehouse_city') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_city', __('Delhivery Warehouse City:')) !!}
                                    {!! Form::text('warehouse_city', config('delhivery.warehouse_city'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse City')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('warehouse_pin') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_pin', __('Delhivery Warehouse Pin Code:')) !!}
                                    {!! Form::text('warehouse_pin', config('delhivery.warehouse_pin'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse Pin Code')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('warehouse_country') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_country', __('Delhivery Warehouse Country:')) !!}
                                    {!! Form::text('warehouse_country', config('delhivery.warehouse_country'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse Country')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('warehouse_phone') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_phone', __('Delhivery Warehouse Phone:')) !!}
                                    {!! Form::text('warehouse_phone', config('delhivery.warehouse_phone'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse Phone')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('warehouse_address') ? ' has-error' : '' }}">
                                    {!! Form::label('warehouse_address', __('Delhivery Warehouse Address:')) !!}
                                    {!! Form::textarea('warehouse_address', config('delhivery.warehouse_address'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Warehouse Address')])!!}
                                </div>
                            </div>
                        </div>

                        <div class="card col-md-6 custom_card_box_css">
                            <div class="card-header">
                                <h4>@lang('Return Details')</h4>
                                <small>
                                    *@lang('Note') : <br>
                                    1. @lang('If you are passing the return keys then shipment will be delivered to return address.')
                                    <br>2. @lang('if you are not passing the return keys then shipment will be delivered to the warehouse address.')
                                </small>
                            </div>
                            <br>
                            <div class="card-body">
                                <div class="form-group{{ $errors->has('return_name') ? ' has-error' : '' }}">
                                    {!! Form::label('return_name', __('Delhivery Return Name:')) !!}
                                    {!! Form::text('return_name', config('delhivery.return_name'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return Name')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_city') ? ' has-error' : '' }}">
                                    {!! Form::label('return_city', __('Delhivery Return City:')) !!}
                                    {!! Form::text('return_city', config('delhivery.return_city'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return City')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_state') ? ' has-error' : '' }}">
                                    {!! Form::label('return_state', __('Delhivery Return State:')) !!}
                                    {!! Form::text('return_state', config('delhivery.return_state'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return State')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_pin') ? ' has-error' : '' }}">
                                    {!! Form::label('return_pin', __('Delhivery Return Pin Code:')) !!}
                                    {!! Form::text('return_pin', config('delhivery.return_pin'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return Pin Code')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_country') ? ' has-error' : '' }}">
                                    {!! Form::label('return_country', __('Delhivery Return Country:')) !!}
                                    {!! Form::text('return_country', config('delhivery.return_country'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return Country')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_phone') ? ' has-error' : '' }}">
                                    {!! Form::label('return_phone', __('Delhivery Return Phone:')) !!}
                                    {!! Form::text('return_phone', config('delhivery.return_phone'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return Phone')])!!}
                                </div>

                                <div class="form-group{{ $errors->has('return_address') ? ' has-error' : '' }}">
                                    {!! Form::label('return_address', __('Delhivery Return Address:')) !!}
                                    {!! Form::textarea('return_address', config('delhivery.return_address'), ['class'=>'form-control', 'placeholder'=>__('Enter Delhivery Return Address')])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom_submit_btn col-md-12">
                            {!! Form::submit(__('Save Settings'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
