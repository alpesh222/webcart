@extends('layouts.manage')

@section('title')@lang('Vendor Payments') - {{config('app.name')}}@endsection

@section('page-header-title')
	@lang('Vendor Payments')
@endsection

@section('page-header-description')
    @lang('View payouts and set preferred methods to receive your payments')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-8">
					<h3>
						{{$vendor->name}}
						<small><a target="_blank" href="{{route('front.vendor.profile')}}"><i class="fa fa-edit"></i></a></small>
					</h3>
					<span><strong>@lang('Phone:')</strong> {{$vendor->phone}}</span><br>
				</div>
				<div class="col-md-4">
					<br>
					<a href="{{route('manage.products.create')}}" class="action-btn btn btn-primary">@lang('Add Product')</a>
					<a href="{{route('manage.products.index')}}" class="action-btn btn btn-success">@lang('Views Products')</a>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h4>@lang('Payment Methods')</h4>
		</div>

		<div class="col-md-12">
    		@include('includes.form_errors')
            @if(session()->has('payments_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('payments_updated')}}</strong>
                </div>
            @endif
		</div>

		<div class="col-md-6">
			<form action="{{route('manage.vendor.settings.payments')}}" method="post">
				<div class="well">
					{{csrf_field()}}
					<div class="form-group">
						<div class="checkbox">
							<label><input type="checkbox" name="bank_transfer" @if(isset($payment_bank_transfer['enable']) && $payment_bank_transfer['enable']) checked @endif> @lang('Bank Transfer')</label>
						</div>
					</div>
					<div id="bank-transfer-payment">
						<div class="form-group">
							<label for="bank_transfer_ifsc_code"><strong>@lang('Branch / IFSC Code:')</strong></label>
							<input type="text" name="ifsc_code" id="bank_transfer_ifsc_code" class="form-control" value="{{isset($payment_bank_transfer['ifsc_code']) ? $payment_bank_transfer['ifsc_code'] : ''}}">
						</div>
						<div class="form-group">
							<label for="bank_transfer_account_number"><strong>@lang('Account Number:')</strong></label>
							<input type="text" name="account_number" id="bank_transfer_account_number" class="form-control" value="{{isset($payment_bank_transfer['account_number']) ? $payment_bank_transfer['account_number'] : ''}}">
						</div>
						<div class="form-group">
							<label for="bank_transfer_name"><strong>@lang('Name:')</strong></label>
							<input type="text" name="name" id="bank_transfer_name" class="form-control" value="{{isset($payment_bank_transfer['name']) ? $payment_bank_transfer['name'] : ''}}">
						</div>
					</div>
					<input type="hidden" name="payment_method" value="bank_transfer">
					<div class="text-right">
						<button type="submit" class="btn btn-primary">@lang('Update')</button>
					</div>
				</div>
			</form>
		</div>

		<div class="col-md-6">
			<form action="{{route('manage.vendor.settings.payments')}}" method="post">
				<div class="well">
					{{csrf_field()}}
					<div class="form-group">
						<div class="checkbox">
							<label><input type="checkbox" name="paypal" @if(isset($payment_paypal['enable']) && $payment_paypal['enable']) checked @endif>@lang('Paypal')</label>
						</div>
					</div>
					<div id="paypal-payment">
						<div class="form-group">
							<label for="paypal_email"><strong>@lang('PayPal Business Email:')</strong></label>
							<input type="email" name="paypal_email" id="paypal_email" class="form-control" value="{{isset($payment_paypal['email']) ? $payment_paypal['email'] : ''}}">
						</div>
					</div>
					<input type="hidden" name="payment_method" value="paypal">
					<div class="text-right">
						<button type="submit" class="btn btn-primary">@lang('Update')</button>
					</div>
				</div>
			</form>
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
			{{$vendor_payments->links()}}
		</div>
	</div>
@endsection
