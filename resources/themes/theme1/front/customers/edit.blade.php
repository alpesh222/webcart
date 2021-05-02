@extends('layouts.front')

@section('title')@lang('Shipping Details') - {{config('app.name')}}@endsection

@section('styles')
    @include('partials.phone_style')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    @include('partials.phone_script')
    <script>
        @if($customer->country)
        $('#country').val("{{$customer->country}}");
        @endif
    </script>
@endsection

@section('content')
    <div class="wrapper wrapper-sticky col-md-10">
        @include('partials.front.sidebar')
        <div class="content col-md-9">
            <div class="page-title">
                <h2>@lang('Shipping Address')</h2>
            </div>
            @if(session()->has('address_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('address_updated')}}
                </div>
            @endif
            @include('includes.form_errors')
            <div class="content-panel col-sm-8 col-sm-offset-2 shipping-address-form">
                <div class="panel-body">
                    {!! Form::model($customer, ['method'=>'patch', 'action'=>['FrontCustomersController@update', $customer->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait') . '"; return true;']) !!}

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
                        {!! Form::text('phone-number', $customer->phone, ['class'=>'form-control', 'placeholder'=>__('Enter your phone number'), 'required'])!!}
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', __('Email:')) !!}
                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter your email address'), 'required'])!!}
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-block" name="submit_button" id="update_btn">@lang('Update Address')
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
