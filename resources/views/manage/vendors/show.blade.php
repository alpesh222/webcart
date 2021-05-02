@extends('layouts.manage')

@section('title')@lang('Vendor') - {{config('app.name')}}@endsection

@section('page-header-title')
	@lang('View Vendor')
    @if (Auth::user()->can('read', App\Vendor::class))
        <a class="btn btn-sm btn-info" href="{{route('manage.vendors.index')}}">@lang('View All')</a>
    @endif
@endsection

@section('page-header-description')
    @lang("View Vendor's earnings and payouts")
@endsection

@section('styles')
    <link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        @if(session()->has('payment_error'))
            toastr.error("{{session('payment_error')}}");
        @endif
        @if(session()->has('payment_success'))
            toastr.success("{{session('payment_success')}}");
        @endif
        var bankDetail = $('#bank-transfer-detail');
        $(document).on('change', '.payment_method_status', function() {
        	if(this.value == 'Bank Transfer') {
        		bankDetail.fadeIn();
        	} else {
        		bankDetail.hide();
        	}
        });
    </script>
    @endif
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script>
    	$('#filter_by_month').datepicker({
		    format: "mm-yyyy",
		    viewMode: "months", 
		    minViewMode: "months"
    	});
    </script>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
            @if(session()->has('payment_success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('payment_success')}}</strong>
                </div>
            @endif
            @if(session()->has('payment_error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('payment_error')}}</strong>
                </div>
            @endif
			<h3>{{$vendor->name}}</h3>
			<span><strong>@lang('Shop Name:')</strong> {{$vendor->shop_name}}</span><br>
			<span>
				<strong>@lang('Shop URL:')</strong>
				<a class="text-primary" target="blank" href="{{url('/shop')}}/{{$vendor->slug}}">{{url('/shop')}}/{{$vendor->slug}}</a>
			</span><br>
			<span><strong>@lang('Phone:')</strong> {{$vendor->phone}}</span><br>
			<span><strong>@lang('Address:')</strong> {{$vendor->address}}</span><br>
			<span><strong>@lang('City:')</strong> {{$vendor->city}}</span><br>
			<span><strong>@lang('State:')</strong> {{$vendor->state}}</span><br>
			{!!$vendor->description!!}
		</div>
	</div>

	<hr>

	@if($vendor_request)
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning">
				@lang('Vendor has requested for payout on <strong>:date_time</strong>.', ['date_time' => $vendor_request->created_at->format('d-m-Y h:i A')])
			</div>
			<div class="well">
				<strong>@lang('Message:')</strong> {{$vendor_request->message}}
			</div>
		</div>
	</div>
	@endif

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
			{{$vendor_amounts->appends(request()->input())->links()}}
		</div>
	</div>

	<hr>

	<div class="well">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 well">
				<form method="get" action="">
					<label for="filter_by_month"><strong>@lang('Filter by Month:')</strong></label>
					<div class="form-group">
						<input type="text" name="month" class="form-control" id="filter_by_month" value="{{$date_filter ? Carbon\Carbon::parse($date_filter)->format('m-Y') : ''}}">
					</div>
					<button class="btn btn-primary" type="submit">@lang('Filter')</button>
				</form>
				@if($date_filter)
				<div>
					<br>
					@lang('Results filtered for:') <strong>{{Carbon\Carbon::parse($date_filter)->format('F Y')}}</strong><br>
					<a href="{{route('manage.vendors.show', ['id' => $vendor->id])}}">@lang('Clear Filter')</a>
				</div>
				@endif
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h4>@lang('Overall Summary')</h4>
				<ul class="list-group">
					<li class="list-group-item"><strong>@lang('Outstanding Amount:') </strong>{{currency_format($outstanding_amount)}}</li>
					<li class="list-group-item"><strong>@lang('Amount Earned:') </strong>{{currency_format($amount_earned)}}</li>
					<li class="list-group-item"><strong>@lang('Amount Paid:') </strong>{{currency_format($amount_paid)}}</li>
	                @if($amount_earned > 0)
					<li class="list-group-item">
						<strong><span class="text-primary">@lang('Amount Payable:')</span>&nbsp;{{currency_format($amount_earned)}}</strong>
						<br><br>
						@if(count($amount_earned_ids))
						<form action="{{route('manage.vendor.payment')}}" method="post">
							{{csrf_field()}}
							<input type="hidden" name="vendor" value="{{$vendor->id}}">
							<input type="hidden" name="amount" value="{{$amount_earned}}">
							<input type="hidden" name="payment_ids" value="{{$amount_earned_ids_string}}">
							@if($date_filter)
							<input type="hidden" name="month" value="{{Carbon\Carbon::parse($date_filter)->format('m-Y')}}">
							@endif
							@if(isset($payment_paypal['enable']) && $payment_paypal['enable'] && !empty($payment_paypal['email']))
							<label><strong>@lang('Payment Method:')</strong></label><br>
							<label><input type="radio" name="payment_method" value="paypal" checked> @lang('Paypal') ({{$payment_paypal['email']}})</label><br><br>
							<button class="btn btn-primary">@lang('Pay Now')</button>
							@endif
						</form>
						@endif
					</li>
	            	@endif
				</ul>
			</div>
			@if($amount_earned > 0)
			<div class="col-md-6">
	    		@include('includes.form_errors')
				<h4>@lang('Update Payment Status')</h4>
				<small>@lang('This will mark the payment status of') <strong><span class="text-primary">@lang('Amount Payable:')</span>&nbsp;{{currency_format($amount_earned)}}</strong> @lang('as') <strong>@lang('"Paid"')</strong>.</small>
				<form action="{{route('manage.vendor.updatePaymentStatus')}}" method="post">
					{{csrf_field()}}
					<input type="hidden" name="vendor" value="{{$vendor->id}}">
					<input type="hidden" name="amount" value="{{$amount_earned}}">
					<input type="hidden" name="payment_ids" value="{{$amount_earned_ids_string}}">
					<div class="form-group">
						<br>
						<label><strong>@lang('Payment Method:')</strong></label><br>
						<label><input type="radio" name="payment_method" value="Paypal" class="payment_method_status" checked> @lang('Paypal')</label><br>
						<label><input type="radio" name="payment_method" value="Bank Transfer" class="payment_method_status" id="bank-transfer-radio"> @lang('Bank Transfer')</label>
						<div id="bank-transfer-detail" style="display: none;">
							<strong>@lang('Branch / IFSC Code:')</strong> {{isset($payment_bank_transfer['account_number']) ? $payment_bank_transfer['account_number'] : ''}}<br>
							<strong>@lang('Account Number:')</strong> {{isset($payment_bank_transfer['account_number']) ? $payment_bank_transfer['account_number'] : ''}}<br>
							<strong>@lang('Name:')</strong> {{isset($payment_bank_transfer['name']) ? $payment_bank_transfer['name'] : ''}}<br>
						</div>
					</div>
					<div class="form-group">
						<label for="transaction_id"><strong>@lang('Transaction ID:')</strong></label>
						<input type="text" class="form-control" name="transaction_id" required>
					</div>
					<button class="btn btn-success" type="submit" onclick="return confirm(__('Please confirm.'));">@lang('Mark as Paid')</button>
				</form>
			</div>
			@endif
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h4>@lang('Last Payouts')</h4>
		</div>
		<div class="col-md-12 table-responsive">
			<table class="table table-striped table-hover well">
				<thead>
					<tr>
						<th>@lang('Transaction ID')</th>
						<th>@lang('Amount')</th>
						<th>@lang('Payment Method')</th>
						<th>@lang('Date')</th>
					</tr>
				</thead>
				<tbody>
					@if(count($vendor_payments))
						@foreach($vendor_payments as $vendor_payment)
					<tr>
						<td>{{$vendor_payment->payment_id}}</td>
						<td>{{currency_format($vendor_payment->amount, $vendor_payment->currency)}}</td>
						<td>{{$vendor_payment->payment_method}}</td>
						<td>{{$vendor_payment->created_at->format('d-m-Y h:i A')}}</td>
					</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			{{$vendor_payments->appends(request()->input())->links()}}
		</div>
	</div>
@endsection