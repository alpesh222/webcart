<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use App\Order;
use DB;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Events\Order\OrderPlacedEvent;

class InstamojoController extends Controller
{
    public function createRequest($amount) {
		$ch = curl_init();

		if(config('instamojo.mode') == 'live') {
			$url = 'https://www.instamojo.com/api/1.1/payment-requests/';
		} elseif(config('instamojo.mode') == 'test') {
			$url = 'https://test.instamojo.com/api/1.1/payment-requests/';
		} else {
			return back();
		}

	    $api_key = 'X-Api-Key:'.config('instamojo.instamojo_api_key');
	    $auth_token = 'X-Auth-Token:'.config('instamojo.instamojo_auth_token');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($api_key, $auth_token));
		$payload = Array(
		    'purpose' => 'Order Total',
		    'amount' => $amount,
		    'buyer_name' => Auth::user()->name,
		    'redirect_url' => url('/instamojo/payment/response'),
		    'webhook' => url('/instamojo/payment/webhook/'),
		    'send_email' => false,
		    'send_sms' => false,
		    'email' => Auth::user()->email,
		    'allow_repeated_payments' => false
		);

	    $order = Order::createOrder(true);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
		$response = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($response, true);
		if($data['success']) {
	        try {
	            DB::beginTransaction();
				$is_stock_available = Product::isStockAvailable($order->products);
				if($is_stock_available) {
					session(['order_id' => $order->id]);
					return redirect($data['payment_request']['longurl']);
				} else {
					throw new \Exception();
				}
	        } catch (\Exception $exception) {
				session()->flash('payment_fail', __("Sorry, your order was not placed successfully."));
	            DB::rollBack();
	            $this->clearCart();
	        }
		} else {
			session()->flash('payment_fail', __('Error processing Instamojo payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
			DB::rollBack();

			// Send Email for Payment Failed
			try {
				Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
			} catch (\Exception $e) {}

			return redirect(route('front.cart.index'));
		}
        return redirect('/');
    }

    public function response(Request $request) {
        $order = Order::findOrFail(session('order_id'));
        if($request->payment_id) {
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
	        session()->flash('payment_fail', __('Error processing Instamojo payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
	        DB::rollBack();
	        // Send Email for Payment Failed
	        try {
		        Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
	        } catch (\Exception $e) {}
		    session()->forget('payment_method');
		    session()->forget('order_id');
	        return redirect(route('front.cart.index'));
        }
    }

    private function clearCart()
    {
        Cart::destroy();
        session()->forget('customer_id');
	    session()->forget('payment_method');
	    session()->forget('order_id');
    }
}
