@extends('layouts.front')

@section('title')@lang('Vendor Profile') - {{config('app.name')}}@endsection

@section('page-header-title')
	@if($vendor)
		@lang('Vendor Profile')
	@else
		@lang('Register your Vendor Profile')
	@endif
@endsection

@section('page-header-description')
	@lang('View your Vendor Profile')
@endsection

@section('sidebar')
    <div>
        @include('partials.front.sidebar')
    </div>
@endsection

@section('styles')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
    @include('partials.phone_style')
    <style>
        #page-inner {
        	background-color: #f5f5f5 !important;
        }
    </style>
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

@section('content')
<div id="page-wrapper">
    <div id="page-inner">
        <div class="page-title">
            <h2>
				@if($vendor)
					@lang('Vendor Profile')
				@else
					@lang('Register as Vendor')
				@endif
            </h2>
            <hr>
            @if(isset($vendor->approved) && !$vendor->approved)
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @lang('Your vendor profile is pending for approval by an administrator.')
            </div>
            @elseif($vendor->approved)
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="well">@lang('Status:') <strong>@lang('Approved')</strong>&nbsp;&nbsp;
                        <a target="_blank" href="{{route('manage.vendor.dashboard')}}" class="btn btn-sm btn-primary pull-right">@lang('Vendor Dashboard')</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            @endif
            <hr>
            @if(session()->has('profile_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('profile_updated')}}
                </div>
            @endif
            @include('includes.form_errors')

            <div class="col-lg-6 col-md-8 col-sm-12">
                {!! Form::model($vendor, ['method'=>'patch', 'action'=>['FrontVendorController@updateProfile'], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;', 'id'=>'update-profile-form']) !!}

                @if($vendor->approved)
                <label>@lang('Shop URL:')</label>
                <div class="well">
                    <small>
                        <a target="blank" href="{{url('/shop')}}/{{$vendor->slug}}">{{url('/shop')}}/{{$vendor->slug}}</a> 
                    </small>
                </div>
                @endif

                <label class="text-muted">@lang('Shop Name:')</label>&nbsp;
                <span>
                    {{$vendor->shop_name}}
                </span>
                <br>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', __('Company Name:') ) !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter company name'), 'required'])!!}
                </div>

				<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
					{!! Form::label('phone-number', __('Phone:') ) !!}
					{!! Form::text('phone-number', null, ['class'=>'form-control', 'placeholder'=>__('Enter phone number'), 'required'])!!}
				</div>

				<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
					{!! Form::label('description', __('Description:') ) !!}
					{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter description'), 'rows'=>'6'])!!}
				</div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    {!! Form::label('address', __('Address:') ) !!}
                    {!! Form::text('address', null, ['class'=>'form-control', 'placeholder'=>__('Enter address')])!!}
                </div>

                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                    {!! Form::label('city', __('City:') ) !!}
                    {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter city') ])!!}
                </div>

                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                    {!! Form::label('state', __('State:') ) !!}
                    {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter state') ])!!}
                </div>

                <div class="form-group">
                    {!! Form::submit($vendor ? $vendor->profile_completed ? __('Update Profile') : __('Complete Profile') : __('Register as Vendor'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button', 'id'=>'update_btn']) !!}
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection