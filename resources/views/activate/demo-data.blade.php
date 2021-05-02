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
				<h2>@lang('Please select your template')</h2>
				<h4 class="text-danger">
					@lang('*Note :') @lang('Importing Demo data will override your old data !')
				</h4>
				<hr>
				@include('includes.form_errors')
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
				@if(session()->has('webcart_not_activated'))
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						{{session('webcart_not_activated')}}
					</div>
				@endif

		        {!! Form::open(['method'=>'post', 'action'=>'WebcartActivationController@importDemoData', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
				    <div class="form-group">
						{!! Form::radio('demo_template', 'default', ['class'=>'form-control'])!!}
						{!! Form::label('demo_template', __('Reset to default state') ) !!}
	                </div>
					<div class="form-group">
						{!! Form::radio('demo_template', 'template_1', ['class'=>'form-control'])!!}
						{!! Form::label('demo_template', __('Demo Import') ) !!}
	                </div>
                	{!! Form::submit( __('Import Now'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        		{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection