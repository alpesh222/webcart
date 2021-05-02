<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Events\Order\OrderPlacedEvent;
use App\Helpers\OrderHelper;
use App\Helpers\PaystackHelper;
use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaystackController extends Controller
{
    public function getPaystackCheckout()
    {
        $cart = OrderHelper::getCheckoutData();
        $user_email = $cart['user_email'];
        $order_id   = $cart['invoice_id'];
        $order_amt  = $cart['total'];

        $response = PaystackHelper::handlePaystackRequest($user_email, $order_id, $order_amt);
        if($response['type'] == 'error') {
            session()->flash('payment_fail', __('Error processing Paystack payment for Order No. #:order_id', ['order_id'=>$cart['invoice_id']]));
            // Send Email for Payment Failed
            try {
                $order = Order::findOrFail($cart['invoice_id'] - 10000);
                Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
            } catch (\Exception $e) {}

            return redirect(route('front.cart.index'));
        } else {
            session(['cart_data' => $cart]);
            return redirect($response['paystack_link']);
        }
    }

    public function getExpressCheckoutSuccess($payment_data)
    {
        if (in_array(strtoupper($payment_data->data->status), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $order_id = $payment_data->data->metadata->invoice_id;
            $orderId = $order_id - 10000;
            $order = Order::findOrFail($orderId);
            try {
                DB::beginTransaction();
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    // Perform transaction on Paystack
                    $status = $payment_data->data->gateway_response;
                    if($status == "Successful") {
                        foreach($order->products as $product) {
                            $product->decreaseStock($product->pivot->quantity, $order->id);
                        }

                        $order->transaction_id = $payment_data->data->reference;
                        $order->paid = 1;
                        $order->payment_date = Carbon::now();
                        $order->save();
                        $order->createVendorPayments();

                        DB::commit();
                        OrderHelper::clearCart();
                        session()->flash('payment_success', __('Your order has been successfully placed. Order No. #:order_id', ['order_id'=>$order->getOrderId()]));

                        // Send Email for Order Placed
                        try {
                            Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
                        } catch (\Exception $e) {}

                        // Order Placed Event
                        event(new OrderPlacedEvent($order));
                    } else {
                        session()->flash('payment_fail', __('Error processing payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
                        DB::rollBack();

                        // Send Email for Payment Failed
                        try {
                            Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
                        } catch (\Exception $e) {}
                    }
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $exception) {
                session()->flash('payment_fail', __("Sorry, your order was not placed successfully."));
                DB::rollBack();
                OrderHelper::clearCart();
            }
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
            return redirect('/');
        }
    }

    public function paystackWebhook( Request $request ) {
        if($paystack_keys = PaystackHelper::getPaystackKeys()) {
            define('PAYSTACK_SECRET_KEY',$paystack_keys['paystack_secret_key']);
            define('PAYSTACK_PUBLIC_KEY',$paystack_keys['paystack_secret_key']);

            $body = @file_get_contents("php://input");
            $signature = (isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE']) ? $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] : '');

            if (!$signature) {
                exit();
            }

            if( $signature !== hash_hmac('sha512', $body, PAYSTACK_SECRET_KEY) ){
                exit();
            }

            http_response_code(200);
            $event = json_decode($body);
            switch($event->event){
                case 'charge.success':
                    break;
            }

            exit();
        } else {
            $cart = session('cart_data');
            OrderHelper::getExpressCheckoutCancel($cart['invoice_id']);
        }
    }

    public function paystackCallback(Request $request) {
        $paystack_keys = PaystackHelper::getPaystackKeys();
        define('PAYSTACK_SECRET_KEY', $paystack_keys['paystack_secret_key']);
        define('PAYSTACK_PUBLIC_KEY', $paystack_keys['paystack_secret_key']);

        $cart = session('cart_data');
        $curl = curl_init();
        $reference = isset($request['reference']) ? $request['reference'] : '';
        if(!$reference){
            OrderHelper::getExpressCheckoutCancel($cart['invoice_id']);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . PAYSTACK_SECRET_KEY,
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err) {
            return OrderHelper::getExpressCheckoutCancel($cart['invoice_id']);
        }

        $tranx = json_decode($response);

        if(!$tranx->status) {
            return OrderHelper::getExpressCheckoutCancel($tranx->data->metadata->invoice_id);
        }

        if('success' == $tranx->data->status) {
            return $this->getExpressCheckoutSuccess($tranx);
        }
	session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
        return redirect('/');
    }
}
