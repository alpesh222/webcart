
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
        <ul id="css-editor-nav-tabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#admin"
                aria-controls="admin"
                role="tab"
                data-toggle="tab"
                >@lang('Admin Panel Customization')</a>
            </li>
            <li role="presentation">
                <a href="#panel"
                aria-controls="panel"
                role="tab"
                data-toggle="tab"
                >@lang('Store Theme Customization')</a>
            </li>
        </ul>

        <div class="tab-content text-justify">

            <div role="tabpanel" class="tab-pane active" id="admin">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updateAdminCSS', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('CSS Editor - Admin Panel Customization')</h4>

                        <div class="css_editor_div_css col-md-12 ">
                            <h4 class="mt-2">@lang('Panel Colors')</h4>
                            <div id="cp2" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('manage_panel_main_color') ? ' has-error' : '' }}">
                                <label for="manage_panel_main_color"><strong>@lang('Manage Panel Main Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="manage_panel_main_color" value="{{config('customcss.manage_panel_main_color')}}" name="manage_panel_main_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp3" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('manage_panel_side_color') ? ' has-error' : '' }}">
                                <label for="manage_panel_side_color"><strong>@lang('Manage Panel Sidebar Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="manage_panel_side_color" value="{{config('customcss.manage_panel_side_color')}}" name="manage_panel_side_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp4" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('manage_panel_title_color') ? ' has-error' : '' }}">
                                <label for="manage_panel_title_color"><strong>@lang('Manage Panel Title Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="manage_panel_title_color" value="{{config('customcss.manage_panel_title_color')}}" name="manage_panel_title_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp4" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('manage_panel_text_color') ? ' has-error' : '' }}">
                                <label for="manage_panel_text_color"><strong>@lang('Manage Panel Text Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="manage_panel_text_color" value="{{config('customcss.manage_panel_text_color')}}" name="manage_panel_text_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp4" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('manage_panel_hover_color') ? ' has-error' : '' }}">
                                <label for="manage_panel_hover_color"><strong>@lang('Manage Panel Hover Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="manage_panel_hover_color" value="{{config('customcss.manage_panel_hover_color')}}" name="manage_panel_hover_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp10" class="col-md-8 input-group {{ $errors->has('admin_css') ? ' has-error' : '' }}">
                                <label for="admin_css"><strong>@lang('Custom Front Panel Css')</strong></label>
                                <div class="form-group pl-0">
                                    {!! Form::textarea('admin_css', config('customcss.css_manage'), ['id'=>'admin_css', 'class'=>'form-control', 'placeholder'=>__('Enter CSS'), 'rows'=>10, 'cols'=>10])!!}
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

            <div role="tabpanel" class="tab-pane" id="panel">

                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-12 col-lg-12">

                        {!! Form::open(['method'=>'patch', 'action'=>'ManageAppSettingsController@updatePanelCSS', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                        <h4 class="text-center">@lang('CSS Editor - Store Theme Customization')</h4>

                        <div class="css_editor_div_css col-md-12 form-group{{ $errors->has('panel_css') ? ' has-error' : '' }}">

                            <div class="">
                                <label>
                                    <input type="checkbox" name="front_header_full_width"
                                           @if(config('customcss.front_header_full_width'))
                                                checked
                                            @endif
                                    >
                                    <strong>@lang('Front Panel Header Full Width')</strong>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="front_footer_full_width"
                                           @if(config('customcss.front_footer_full_width'))
                                                checked
                                            @endif
                                    >
                                    <strong>@lang('Front Panel Footer Full Width')</strong>
                                </label>
                            </div>

                            <h4 class="mt-2">@lang('Panel Colors')</h4>
                            <div id="cp2" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('panel_css') ? ' has-error' : '' }}">
                                <label for="store_primary_color"><strong>@lang('Main Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="store_primary_color" value="{{config('customcss.css_front_primary')}}" name="panel_css" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp3" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('panel_css_secondary') ? ' has-error' : '' }}">
                                <label for="store_secondary_color"><strong>@lang('Background Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="store_secondary_color" value="{{config('customcss.css_front_secondary')}}" name="panel_css_secondary" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp4" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('panel_btn_color') ? ' has-error' : '' }}">
                                <label for="panel_btn_color"><strong>@lang('Button Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="panel_btn_color" value="{{config('customcss.panel_btn_color')}}" name="panel_btn_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp5" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('panel_btn_hover_color') ? ' has-error' : '' }}">
                                <label for="panel_btn_hover_color"><strong>@lang('Button Hover Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="panel_btn_hover_color" value="{{config('customcss.panel_btn_hover_color')}}" name="panel_btn_hover_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp6" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('head_foot_text_color') ? ' has-error' : '' }}">
                                <label for="head_foot_text_color"><strong>@lang('Header And Footer Text Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="head_foot_text_color" value="{{config('customcss.head_foot_text_color')}}" name="head_foot_text_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp7" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('head_foot_icon_color') ? ' has-error' : '' }}">
                                <label for="head_foot_icon_color"><strong>@lang('Header And Footer Icons Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="head_foot_icon_color" value="{{config('customcss.head_foot_icon_color')}}" name="head_foot_icon_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>

                            <div id="cp8" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('link_hover_color') ? ' has-error' : '' }}">
                                <label for="link_hover_color"><strong>@lang('Anchor Link Hover Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="link_hover_color" value="{{config('customcss.link_hover_color')}}" name="link_hover_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>

                            <div id="cp10" class="col-md-4 input-group colorpicker colorpicker-component {{ $errors->has('header_text_color') ? ' has-error' : '' }}">
                                <label for="header_text_color"><strong>@lang('Header Text Color')</strong></label>
                                <div class="form-group custom_css_edit_div">
                                    <input type="text" id="header_text_color" value="{{config('customcss.header_text_color')}}" name="header_text_color" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>

                            <div id="cp9" class="col-md-8 input-group {{ $errors->has('store_css') ? ' has-error' : '' }}">
                                <label for="store_css"><strong>@lang('Custom Front Panel Css')</strong></label>
                                <div class="form-group pl-0">
                                    {!! Form::textarea('store_css', config('customcss.css_front'), ['id'=>'store_css', 'class'=>'form-control', 'placeholder'=>__('Enter CSS'), 'rows'=>10, 'cols'=>10])!!}
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

        </div>
    </div>
</div>
@section('colorPickerJs')

    <script src="{{asset('css/colorpicker/colorpicker.js')}}"></script>
    <script type="text/javascript">
        $('.colorpicker').colorpicker();
    </script>
@endsection
