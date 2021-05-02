<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use App\Order;
use DB;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Events\Order\OrderPlacedEvent;
use Tzsk\Payu\Facade\Payment;
use Illuminate\Http\Request;

class PayUController extends Controller
{
	public function payment($amount)
	{
    	$order = Order::createOrder(true);

		$attributes = [
		    'txnid' => substr(hash('sha256', mt_rand() . microtime()), 0, 20), # Transaction ID.
		    'amount' => $amount, # Amount to be charged.
		    'productinfo' => "Order Total",
		    'firstname' => Auth::user()->name, # Payee Name.
		    'email' => Auth::user()->email, # Payee Email Address.
		    'phone' => $order->address->phone, # Payee Phone Number.
		];

        try {
            DB::beginTransaction();
			$is_stock_available = Product::isStockAvailable($order->products);
			if($is_stock_available) {
				session(['order_id' => $order->id]);
				return Payment::make($attributes, function ($then) {
		    		$then->redirectAction('PayUController@status');
				});
			} else {
				throw new \Exception();
			}
        } catch (\Exception $exception) {
			session()->flash('payment_fail', __("Sorry, your order was not placed successfully."));
            DB::rollBack();
            $this->clearCart();
        }

        return redirect('/');
	}

	public function status()
	{
		$payment = Payment::capture();

        if($payment->isCaptured()) {
	        $order = Order::findOrFail(session('order_id'));
			foreach($order->products as $product) {
				$product->decreaseStock($product->pivot->quantity, $order->id);
			}
	        $order->paid = 1;
	        $order->payment_date = Carbon::now();
	        $order->save();
            $order->createVendorPayments();

	        DB::commit();
	        $this->clearCart();

	        session()->flash('payment_success', __('Your order has been successfully placed. Order No. #:order_id', ['order_id'=>$order->getOrderId()]));

	        // Send Email for Order Placed
	        try {
		        Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
	        } catch (\Exception $e) {}

            // Order Placed Event
            event(new OrderPlacedEvent($order));

	        return redirect('/');

        } else {
	        $order = Order::findOrFail(session('order_id'));

	        session()->flash('payment_fail', __('Error processing PayU payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
	        DB::rollBack();
	        // Send Email for Payment Failed
	        try {
		        Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
	        } catch (\Exception $e) {}
	        session()->forget('payment_method');
	        session()->forget('order_id');
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
	        return redirect(route('front.cart.index'));
        }
	}

    private function clearCart()
    {
        Cart::destroy();
        session()->forget('customer_id');
	    session()->forget('payment_method');
	    session()->forget('order_id');
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
    }
}
