<div class="row">

    <div class="col-lg-12">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageRolesController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "Please Wait..."; return true;']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Role:') !!}
                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter role name', 'required'])!!}
            </div>
        </div>

        @if(count($permissions) > 0)

            <hr>

            <div class="row">

                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Staff Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'users')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>


                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Role Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'roles')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Page Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'pages')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Section Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'sections')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Testimonial Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'testimonials')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Review Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'reviews')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Product Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'products')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Vendor Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'vendors')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Category Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'categories')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Brand Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'brands')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Order Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'orders')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Discount Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'discounts')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Coupon Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'coupons')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Banner Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'banners')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Deal Permissions')</strong></label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'deals')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-lg-2">
                            <label for="permissions"><strong>@lang('Shipment Permissions')</label>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'shipments')
                                    <div class="checkbox">
                                        <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 col-lg-offset-4">
                                    <label for="permissions"><strong>@lang('Other Permissions')</label>
                                </div>
                            </div>
                            @foreach($permissions as $permission)
                                @if($permission->for == 'other')
                                    <div class="col-lg-4">
                                        <div class="checkbox">
                                            <label><input name="permission[]" type="checkbox" value="{{$permission->id}}">{{$permission->name}}</label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                    
                    <hr>

                </div>

            </div>

        @endif

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 form-group">
                {!! Form::submit('Add Role', ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>
</div>