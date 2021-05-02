@extends('layouts.front')

@section('title')@lang('Webcart Activation') - {{config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('Activate your 15-days trial')">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Webcart Activation') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Activate your 15-days trial')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('styles')
	<style>
		.container {
			margin-bottom: 120px;
		}
	</style>
@endsection

@section('scripts')

@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h2>@lang('Please activate your package')</h2>
				<p>
					@lang('Please activate this package with a purchase code. If you don’t have a purchase code yet, you can purchase it from') <a target="_blank" href="https://codecanyon.net/item/webcart-multi-store-ecommerce-shopping-cart-solution/22986124">@lang('here')</a>
				</p>
				<hr>
				@if(session()->has('webcart_not_activated'))
			        <div class="alert alert-danger alert-dismissible" role="alert">
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                <span aria-hidden="true">&times;</span>
			            </button>
			            {{session('webcart_not_activated')}}
			        </div>
			    @endif

				@include('includes.form_errors')

		        {!! Form::open(['method'=>'post', 'action'=>'WebcartActivationController@activate', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

	                <div class="form-group">
		                {!! Form::label('purchase_code', __('Your Purchase Code') ) !!} <a target="_blank" href="https://codecanyon.net/downloads">@lang('Click Here Get Your Purchase Code')</a>
		                {!! Form::text('purchase_code', null, ['class'=>'form-control', 'placeholder'=>__('Enter your purchase code'), 'required'])!!}
	                </div>

				    <div class="form-group">
						{!! Form::checkbox('demo_data', null, ['class'=>'form-control'])!!}
						{!! Form::label('demo_data', __('Do you want to import demo data ?') ) !!}
						<br><small class="text-danger">( @lang('Importing Demo data will override your old data !') )</small>
	                </div>



                	{!! Form::submit( __('Activate Now'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}

        		{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection