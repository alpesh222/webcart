@extends('layouts.manage')

@section('title')@lang('Vendor Dashboard') - {{config('app.name')}}@endsection

@section('styles')
	<style>
		.action-btn {
			margin-bottom: 5px;
		}
		#message {
			resize: vertical;
		}
		.payout-submission-message {
			margin-top: 25px;
		}
	</style>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('success'))
            toastr.success("{{session('success')}}");
        @endif
    </script>
    @endif
@endsection

@section('page-header-title')
	@lang('Vendor Dashboard')
@endsection

@section('page-header-description')
    @lang('View your earnings and payouts')
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">
			@include('includes.form_errors')
            @if(session()->has('success'))
                <div class="text-center alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('success')}}</strong>
                </div>
            @endif

			<div class="row">
				<div class="col-md-8">
					<h3>
						{{$vendor->name}}
						<small><a target="_blank" href="{{route('front.vendor.profile')}}"><i class="fa fa-edit"></i></a></small>
					</h3>
					<span><strong>@lang('Shop Name:')</strong> {{$vendor->shop_name}}</span><br>
					<span>
						<strong>@lang('Shop URL:')</strong>
						<a class="text-primary" target="blank" href="{{url('/shop')}}/{{$vendor->slug}}">{{url('/shop')}}/{{$vendor->slug}}</a>
					</span><br>
					<span><strong>@lang('Phone:')</strong> {{$vendor->phone}}</span><br>
					<span><strong>@lang('Address:')</strong> {{$vendor->address}}</span><br>
					<span><strong>@lang('City:')</strong> {{$vendor->city}}</span><br>
					<span><strong>@lang('State:')</strong> {{$vendor->state}}</span><br>
				</div>
				<div class="col-md-4">
					<br>
					<a href="{{route('manage.products.create')}}" class="action-btn btn btn-primary">@lang('Add Product')</a>
					<a href="{{route('manage.products.index')}}" class="action-btn btn btn-success">@lang('Views Products')</a>
				</div>
			</div>
			{!!$vendor->description!!}
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h4>@lang('Vendor Earnings')</h4>
		</div>
		<div class="col-md-12 table-responsive">
			<table class="table table-striped table-hover well">
				<thead>
					<tr>
						<th>@lang('Product')</th>
						<th>@lang('Quantity')</th>
						<th>@lang('Total Price')</th>
						<th>@lang('Vendor Amount')</th>
						<th>@lang('Status')</th>
						<th>@lang('Date')</th>
					</tr>
				</thead>
				<tbody>
					@if(count($vendor_amounts))
						@foreach($vendor_amounts as $vendor_amount)
					<tr>
						<td>{{$vendor_amount->product_name}}</td>
						<td>{{ucwords($vendor_amount->product_quantity)}}</td>
						<td>{{ucwords($vendor_amount->total_price)}}</td>
						<td>{{ucwords($vendor_amount->vendor_amount)}}</td>
						<td>{{ucwords($vendor_amount->status)}}</td>
						<td>
							@if($vendor_amount->status == 'outstanding')
								{{$vendor_amount->outstanding_date->format('d-m-Y h:i A')}}
							@elseif($vendor_amount->status == 'earned')
								{{$vendor_amount->earned_date->format('d-m-Y h:i A')}}
							@elseif($vendor_amount->status == 'paid')
								{{$vendor_amount->payment_date->format('d-m-Y h:i A')}}
							@elseif($vendor_amount->status == 'cancelled')
								{{$vendor_amount->cancel_date->format('d-m-Y h:i A')}}
							@endif
						</td>
					</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			{{$vendor_amounts->links()}}
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h4>@lang('Overall Summary')</h4>
			<ul class="list-group">
				<li class="list-group-item"><strong>@lang('Outstanding Amount:') </strong>{{currency_format($outstanding_amount)}}</li>
				<li class="list-group-item"><strong>@lang('Amount Earned:') </strong>{{currency_format($amount_earned)}}
				@if(!$allow_payout_request)
				<div class="text-danger">
					@lang('Minimum amount :amount is required before you can request for payout.', ['amount' => currency_format($minimum_amount_for_request)])
				</div>
				@endif
				</li>
				<li class="list-group-item"><strong>@lang('Amount Paid:') </strong>{{currency_format($amount_paid)}}</li>
			</ul>
		</div>
		<div class="col-md-6">
		@if(!$has_pending_request && $allow_payout_request)
			<h4>@lang('Submit Payout Request')</h4>
			<form action="{{route('manage.vendor.submit-payout-request')}}" method="post" id="submit-payout-request-form">
				{{csrf_field()}}
				<div class="form-group">
					<textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="@lang('Enter your message')"></textarea>
				</div>

				<button type="submit" class="btn btn-primary btn-sm submit-payout-request" onclick="
                                    if(confirm('@lang('Are you sure to submit a payout request?')')) {
                                    event.preventDefault();
                                    $('#submit-payout-request-form').submit();
                                    } else {
                                    event.preventDefault();
                                    }
                                    ">
					@lang('Submit Payout Request')
				</button>
			</form>
		@elseif($has_pending_request)
			<div class="payout-submission-message well text-primary text-center">@lang('You submitted a payout request on <strong>:date_time</strong>.', ['date_time' => $payout_request_date_time])</div>
		@endif
		</div>
	</div>
@endsection
