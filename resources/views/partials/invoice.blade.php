<div id="invoice">
	<style>
		.invoice-title h2, .invoice-title h3 {
			display: inline-block;
		}
		.table > tbody > tr > .no-line {
			border-top: none;
		}
		.table > thead > tr > .no-line {
			border-bottom: none;
		}
		.table > tbody > tr > .thick-line {
			border-top: 2px solid;
		}
		#invoice-logo {
			width: 70px;
			height: auto;
		}
	</style>
	<div class="row">
		<div class="col-xs-12">
			<div class="invoice-title">
				<h2>@lang('Invoice')</h2>
				@if(!empty(config('settings.site_logo')))
				&nbsp;<img class="img-responsive" id="invoice-logo" src="{{url('/img/'.config('settings.site_logo'))}}">
				@endif
				<h3 class="pull-right">@lang('Order') # {{$order->getOrderId()}}</h3>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<address>
					<strong>@lang('Billed To:')</strong><br>
						{{$order->address->first_name}} {{$order->address->last_name}}<br>
						<strong>@lang('Phone:')</strong> {{$order->address->phone}}<br>
						<strong>@lang('Email:')</strong> {{$order->address->email}}
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
					<strong>@lang('Shipping Address:')</strong><br>
						{{$order->address->first_name}} {{$order->address->last_name}}<br>
						{{$order->address->address}}<br>
						{{$order->address->city}}, {{$order->address->state}} - {{$order->address->zip}}<br>
						{{$order->address->country}}.
					</address>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>@lang('Payment Method:')</strong><br>
						{{$order->payment_method}}<br>
						{{$order->address->email}}
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
						<strong>@lang('Order Date:')</strong><br>
						{{$order->created_at->toFormattedDateString()}}<br><br>
						@if(!($order->is_processed))
						<strong>@lang('Order Status:')</strong><br>
	                        @if($order->stock_regained)
	                            <strong class="text-primary">@lang('Cancelled')</strong>
	                        @elseif($order->payment_method != 'Cash on Delivery' && $order->paid == 0)
	                            <strong class="text-warning">@lang('Failed')</strong>
	                        @else
	                            <strong class="text-danger">@lang('Pending')</strong>
	                        @endif
                        @endif
					</address>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>@lang('Order summary')</strong></h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed table-bordered">
							<thead>
								<tr>
									<td><strong>@lang('Item')</strong></td>
									<td class="text-center"><strong>@lang('Price')</strong></td>
									<td class="text-center"><strong>@lang('Quantity')</strong></td>
									<td class="text-right"><strong>@lang('Total')</strong></td>
								</tr>
							</thead>
							<tbody>
								@foreach($order->products as $product)
									<tr>
										<td>{{$product->name}}
										    @if($product->pivot->spec && ($specs = unserialize($product->pivot->spec)))
										        <br>
										        @foreach($specs as $key => $spec)
										            <em>{{$spec['name']}}:</em> {{$spec['value']}}@if(!$loop->last), @endif
										        @endforeach
										    @endif
										</td>
										<td class="text-center">{{currency_format($product->pivot->unit_price, $order->currency)}}</td>
										<td class="text-center">{{$product->pivot->quantity}}</td>
										<td class="text-right">{{currency_format($product->pivot->total, $order->currency)}}</td>
									</tr>
								@endforeach
								<tr>
									<td class="thick-line"></td>
									<td class="thick-line"></td>
									<td class="thick-line text-center"><strong>@lang('Subtotal')</strong></td>
									<td class="thick-line text-right">{{currency_format($order->total, $order->currency)}}</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>@lang('Tax')</strong></td>
									<td class="no-line text-right">+ {{$order->tax}} %</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>@lang('Shipping Cost')</strong></td>
									<td class="no-line text-right">{{isset($order->shipping_cost) ? currency_format($order->shipping_cost, $order->currency) : currency_format(0, $order->currency)}}</td>
								</tr>
                                @if($order->coupon_amount && $order->coupon_amount > 0)
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>@lang('Coupon Discount')</strong></td>
									<td class="no-line text-right">{{ currency_format($order->coupon_amount, $order->currency) }} </td>
								</tr>
								@endif

								@if($order->wallet_amount && $order->wallet_amount > 0)
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>@lang('Wallet Used')</strong></td>
									<td class="no-line text-right">{{ currency_format($order->wallet_amount, $order->currency) }} </td>
								</tr>
								@endif
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>@lang('Total')</strong></td>
									<td class="no-line text-right">{{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<button class="btn btn-success pull-right" type="button" onClick="printInvoice('invoice')"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;@lang('Print')</button>
</div>
<hr>

<script>
    function printInvoice(id) {
        let restorePage = document.body.innerHTML;
        let content = document.getElementById(id).innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = restorePage;
    }
</script>