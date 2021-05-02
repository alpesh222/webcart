<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="paypalPayment" id="paypalPayment">
	<input type="hidden" name="business" value="{{isset($payment_paypal['email']) ? $payment_paypal['email'] : ''}}">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="cancel_return" value="{{route('manage.vendor.payment.paypal.cancel')}}"> 
	<input type="hidden" name="return" value="{{route('manage.vendor.payment.paypal.return', ['id' => $vendor->id])}}">
    <input type="hidden" name="custom" value="{{$vendor->id}}">
	<input type="hidden" name="item_name" value="Vendor Payment">
	<input type="hidden" name="item_number" value="{{$vendor->id}}">
	<input type="hidden" name="amount" value="{{$amount_earned}}">
</form>
<script>document.paypalPayment.submit();</script>