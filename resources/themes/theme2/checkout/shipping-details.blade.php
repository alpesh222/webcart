@extends('layouts.front')

@section('meta-tags')
    <meta name="description" content="@lang('Shipping Addresses And Details')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Shipping Details') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Shipping Addresses And Details')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('title')
    @lang('Shipping Details')
@endsection

@section('styles')
    @include('partials.phone_style')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Shipping Details')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="shipping-details">
        @if(count($addresses) > 0)
            <div class="checkbox">
                <label>
                    <input id="existing-address" type="checkbox"> @lang('Use Existing Address')
                </label>
            </div>
            <div class="existing-addresses">
                {!! Form::open(['method'=>'post', 'action'=>'FrontCustomersController@startPaymentSession', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}
                <div class="row shipping-addresses">
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
            <h2 class="circle-icon-header pl-30"><span> <i class="fa fa-ship"></i> @lang('Shipping Details') </span></h2>
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