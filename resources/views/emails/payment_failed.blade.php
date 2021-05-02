@component('mail::message')
# {{ config('custom.mail_message_title_payment_failed') }}

![]({{asset('/img/'.config('custom.mail_logo'))}})

{{ config('custom.mail_message_payment_failed') }} @lang('Your Order Number is :order_id', ['order_id'=>$order->getOrderId()]).
<hr>
@component('mail::table')
| @lang('Item')      | @lang('Price')                                   | @lang('Quantity')             | 
@lang('Total')                                                                                   |
| :----------------: | :----------------------------------------------: | :---------------------------: | :----------------------------------------------------------------------------------------------: |
@foreach($order->products as $product)
| {{$product->name}} | {{currency_format($product->pivot->unit_price)}} | {{$product->pivot->quantity}} | {{currency_format($product->pivot->total, $order->currency)}}                                                      |
@endforeach
|                    |                                                  | **@lang('Subtotal')**         | {{currency_format($order->total, $order->currency)}}                                                               |
|                    |                                                  | **@lang('Tax')**              | + {{$order->tax}} %                                                                              |
|                    |                                                  | **@lang('Shipping Cost')**    | {{isset($order->shipping_cost) ? currency_format($order->shipping_cost, $order->currency) : currency_format(0, $order->currency)}}   |
@if($order->coupon_amount && $order->coupon_amount > 0)
|                    |                                                  | **@lang('Coupon Discount')**  | - {{currency_format($order->coupon_amount, $order->currency)}}                                                     |
@endif
@if($order->wallet_amount && $order->wallet_amount > 0)
|                    |                                                  | **@lang('Wallet Used')**      | - {{currency_format($order->wallet_amount, $order->currency)}}                                                     |
@endif
|                    |                                                  | **@lang('Total')**            | {{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}} |
|                    |                                                  | **@lang('Payment Method')**   | {{$order->payment_method}} |
|                    |                                                  | **@lang('Payment Status')**   | {{$order->paid ? __('Paid') : __('Unpaid')}} |
@endcomponent

@component('mail::panel')
**@lang('Shipping Info')**<br>
<hr>
**{{$order->address->first_name . ' ' . $order->address->last_name}}**,<br>
{{$order->address->address}}<br>
{{$order->address->city . ', ' . $order->address->state . ' - ' . $order->address->zip}}<br>
{{$order->address->country}}.<br>
**@lang('Phone:')** {{$order->address->phone}}<br>
**@lang('Email:')** {{$order->address->email}}<br>
@endcomponent

@component('mail::button', ['url' => url('/orders')])
@lang('View Your Orders')
@endcomponent

@lang('Thanks,')<br>
{{ config('app.name') }}
@endcomponent
