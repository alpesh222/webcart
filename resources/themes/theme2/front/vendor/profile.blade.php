@extends('layouts.front')

@section('title')
    @if($vendor)
        @lang('Vendor Profile') - {{config('app.name')}}
    @else
        @lang('Register as Vendor')
    @endif
@endsection

@section('page-header-title')
    @if($vendor)
        @lang('Vendor Profile')
    @else
        @lang('Register your Vendor Profile')
    @endif
@endsection

@section('page-header-description')
    @if($vendor)
        @lang('Vendor Profile')
    @else
        @lang('Register your Vendor Profile')
    @endif
@endsection

@section('styles')
    @include('partials.phone_style')
    <style>
        textarea {
            height: unset !important;
        }
    </style>
@endsection

@section('sidebar')
    @include('includes.user-account-sidebar')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Vendor Profile')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="col-md-9 user_account">
        <div class="shopping-cart user_account_dashboard">
            <div class="page-title">
                <h2>
                    @if($vendor)
                        @lang('Vendor Profile')
                    @else
                        @lang('Register as Vendor')
                    @endif
                </h2>
            </div>
            <div class="content-panel">
                <div class="col-md-12">
                    @if(isset($vendor->approved) && !$vendor->approved)
                        <div class="alert alert-warning text-center" role="alert">
                            @lang('Your vendor profile is pending for approval by an administrator.')
                        </div>
                    @elseif($vendor->approved)
                        <div class="text-center">
                            <div class="well">
                                <label class="f-20 pt-5">@lang('Status:') <strong>@lang('Approved')</strong></label>
                                <a target="_blank" href="{{route('manage.vendor.dashboard')}}" class="btn btn-sm btn-primary pull-right">@lang('Vendor Dashboard')</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    @endif
                    @if(session()->has('profile_updated'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{session('profile_updated')}}
                        </div>
                    @endif
                    @include('includes.form_errors')
                </div>

                <div class="col-sm-12 profile-setting-form">
                    {!! Form::model($vendor, ['method'=>'patch', 'action'=>['FrontVendorController@updateProfile'], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;', 'id'=>'update-profile-form']) !!}

                    @if($vendor->approved)
                        <label>@lang('Shop URL:')</label>
                        <div class="well">
                            <small>
                                <a class="f-15" target="blank" href="{{url('/shop')}}/{{$vendor->slug}}">{{url('/shop')}}/{{$vendor->slug}}</a>
                            </small>
                        </div>
                    @endif

                    <label class="text-muted">@lang('Shop Name:')</label>&nbsp;
                    <span>
                        {{$vendor->shop_name}}
                    </span>
                    <br><br>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', __('Company Name:')) !!}
                        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter company name'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        {!! Form::label('phone-number', __('Phone:')) !!}
                        {!! Form::text('phone-number', isset( $vendor->phone ) ? $vendor->phone : null, ['class'=>'form-control', 'placeholder'=>__('Enter phone number'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        {!! Form::label('description', __('Description:')) !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter description'), 'rows'=>'6'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', __('Address:')) !!}
                        {!! Form::text('address', null, ['class'=>'form-control', 'placeholder'=>__('Enter address')])!!}
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        {!! Form::label('city', __('City:')) !!}
                        {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter city')])!!}
                    </div>

                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                        {!! Form::label('state', __('State:')) !!}
                        {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter state')])!!}
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn  btn-block" name="submit_button" id="update_btn">
                            {{$vendor ? $vendor->profile_completed ? __('Update Profile') : __('Complete Profile') : __('Register as Vendor')}}
                        </button>
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script>
        var editor_config = {
            path_absolute : APP_URL + "/",
            selector: "textarea",
            resize: false,
            plugins: [
                "advlist autolink lists link charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    @include('partials.phone_script')
@endsection

