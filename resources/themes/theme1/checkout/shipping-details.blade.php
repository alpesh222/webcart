@extends('layouts.front')

@section('title')
    @lang('Shipping Details')
@endsection

@section('styles')
    @include('partials.phone_style')
@endsection

@section('scripts')
    @include('partials.phone_script')
    <script>
        var existingAddress = $('#existing-address');
        var panel = $('.panel');
        var existingAddresses = $('.existing-addresses');

        existingAddresses.hide();
        $(document).ready(function() {
            existingAddress.on('change', function() {
                if(existingAddress.is(':checked')) {
                    panel.hide();
                    existingAddresses.fadeIn();
                } else {
                    panel.fadeIn();
                    existingAddresses.hide();
                }  
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
	<ul class="breadcrumb">
		<li><a href="{{url('/')}}">@lang('Home')</a></li>
		<li>@lang('Shipping Details') </li>
	</ul>
</div>
    <div class="container">
        <div class="col-xs-12">
            @if(session()->has('payment_fail'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <strong>&nbsp;@lang('Error:')</strong> {{session('payment_fail')}}
                </div>
            @endif
            @include('includes.form_errors')

            @if(count($addresses) > 0)
                <div class="checkbox">
                    <label>
                        <input id="existing-address" type="checkbox"> @lang('Use Existing Address')
                    </label>
                </div>

                <div class="existing-addresses">
                    {!! Form::open(['method'=>'post', 'action'=>'FrontCustomersController@startPaymentSession', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                    <div class="row">
                    @foreach($addresses as $key => $address)
                            <div class="col-xs-12 col-md-4 custom_shipping_select">
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="address_option" name="address_option" value="{{$address->id}}">
                                        <span class="address-header">{{$key+1}}. @lang('Shipping Address')</span>
                                    </label>
                                </div>
                                <strong>{{$address->first_name . ' ' . $address->last_name}}</strong>,<br>
                                {{$address->address}}<br>
                                {{$address->city . ', ' . $address->state . ' - ' . $address->zip}}<br>
                                {{$address->country}}.<br>
                                <strong>@lang('Phone:')</strong> {{$address->phone}}<br>
                                <strong>@lang('Email:')</strong> {{$address->email}}<br>

                            </div>

                    @endforeach
                    </div>
                    <div class="text-right">
                        <div class="form-group">
                            <button type="submit" name="submit_button" class="btn btn-primary">@lang('Proceed to Payment')</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>

            @endif

            <div class="panel panel-primary shipping-details-form">
				<h2 class="circle-icon-header"><span> <i class="fa fa-truck"></i> @lang('Shipping Details') </span></h2>
				<div class="panel-body">

                    {!! Form::open(['method'=>'post', 'action'=>'FrontCustomersController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
							{!! Form::label('first_name', __('First Name:')) !!}
							{!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder'=>__('Enter first name'), 'required'])!!}
						</div>

						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
							{!! Form::label('last_name', __('Last Name:')) !!}
							{!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder'=>__('Enter last name'), 'required'])!!}
						</div>

						<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
							{!! Form::label('address', __('Address:')) !!}
							{!! Form::textarea('address', null, ['class'=>'form-control', 'placeholder'=>__('Enter address'), 'rows'=>'6', 'required'])!!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
							{!! Form::label('city', __('City:')) !!}
							{!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter city'), 'required'])!!}
						</div>

						<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
							{!! Form::label('state', __('State:')) !!}
							{!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter state'), 'required'])!!}
						</div>

						<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
							{!! Form::label('zip', __('Zip:')) !!}
							{!! Form::text('zip', null, ['class'=>'form-control', 'placeholder'=>__('Enter zip'), 'required'])!!}
						</div>
						
						@include('partials.countries_field')

						<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
							{!! Form::label('phone-number', __('Phone:')) !!}
							{!! Form::text('phone-number', null, ['class'=>'form-control', 'placeholder'=>__('Enter your phone number'), 'required'])!!}
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							{!! Form::label('email', __('Email:')) !!}
							{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter your email address'), 'required'])!!}
						</div>
					</div>
                </div>
                <div class="panel-footer text-right">
                    <div class="form-group">
                        <button type="submit" name="submit_button" class="btn btn-primary">@lang('Proceed to Payment')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
