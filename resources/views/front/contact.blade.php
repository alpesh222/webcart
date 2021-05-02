@extends('layouts.front')

@section('title'){{"Contact Us - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('If you have any query, then please use the form below to contact us. We will get back to you as soon as possible.')">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{'Contact Us - '.config('app.name')}}" />
    <meta property="og:description" content="@lang('If you have any query, then please use the form below to contact us. We will get back to you as soon as possible.')" />
@endsection

@section('styles')
	<style>
		#map {
		  height: 400px;
		  width: 100%;
		}
		.contact-info {
			font-size: 1.33em;
			margin-left: 10px;
		}
		textarea { resize: vertical; }
	</style>
@endsection

@section('scripts')
	@if(config('googlemap.api_key') && config('googlemap.location_name'))
    <script>
      var geocoder;
      var map;
      var address = "{{config('googlemap.location_name')}}";
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: {{config('googlemap.zoom') ? config('googlemap.zoom') : 17}},
          center: {lat: -34.397, lng: 150.644}
        });
        geocoder = new google.maps.Geocoder();
        codeAddress(geocoder, map);
      }

      function codeAddress(geocoder, map) {
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });
          } else {
            alert('@lang('Geocode was not successful for the following reason:') ' + status);
          }
        });
      }
    </script>
	<script async defer
	src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap.api_key')}}&callback=initMap">
	</script>
	@endif
@endsection

@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="well">
			<h1 class="text-center">@lang('Contact Us')</h1>
		</div>
		@if(config('googlemap.api_key') && config('googlemap.location_name'))
		<div class="col-md-6">
			<div id="map"></div>
		</div>
		@elseif(config('googlemap.embed_code'))
		<div class="col-md-6">
			{!! config('googlemap.embed_code') !!}
		</div>
		@endif
		<div class="col-md-6 {{!(config('googlemap.embed_code') || (config('googlemap.api_key') && config('googlemap.location_name'))) ? 'col-md-offset-3' : ''}}">
			<ul class="list-group">
				@if(config('settings.contact_number'))
				<li class="list-group-item"><i class="fa fa-phone fa-2x"></i><span class="contact-info">{{config('settings.contact_number')}}</span></li>
				@endif
				@if(config('settings.contact_email'))
				<li class="list-group-item"><i class="fa fa-envelope fa-2x"></i><span class="contact-info">{{config('settings.contact_email')}}</span></li>
				@endif
			</ul>
			<p class="text-muted">@lang('If you have any query, then please use the form below to contact us.')</p>
			<br>
	        @if(session()->has('message_sent'))
	            <div class="alert alert-success alert-dismissible" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                {{session('message_sent')}}
	            </div>
	        @endif

            @if(session()->has('message_not_sent'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('message_not_sent')}}
                </div>
            @endif

		    @include('includes.form_errors')

		    {!! Form::open(['method'=>'post', 'action'=>'FrontContactFormController@sendEmail', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

		    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		        {!! Form::label('name', __('Your Name:')) !!}
		        {!! Form::text('name', Auth::check() ? Auth::user()->name : null, ['class'=>'form-control', 'placeholder'=>__('Enter your name'), 'required']) !!}
		    </div>

		    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		        {!! Form::label('email', __('Your Email:')) !!}
		        {!! Form::email('email', Auth::check() ? Auth::user()->email : null, ['class'=>'form-control', 'placeholder'=>__('Enter your email address'), 'required']) !!}
		    </div>

	        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
	            {!! Form::label('message',__('Your Message:')) !!}
	            {!! Form::textarea('message', null, ['class'=>'form-control', 'placeholder'=>__('Enter your message'), 'rows'=>6, 'required']) !!}
	        </div>

            <br>
	        <img id="captcha" src="{{url('/secure/captcha')}}"><br><br>
		    <div class="form-group{{ $errors->has('security_code') ? ' has-error' : '' }}">
		        {!! Form::label('security_code', __('Enter as shown in above image:')) !!}
		        <input type="text" name="security_code" class="form-control" placeholder="@lang('Enter as shown in above image')" required="">
		    </div>

		    <hr>
		    <div class="form-group">
		        {!! Form::submit(__('Submit'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
		    </div>

		    {!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
