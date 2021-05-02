<?php

namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Events\Order\OrderPlacedEvent;
use App\Helpers\OrderHelper;
use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaytmController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function getPaytmCheckout()
    {
        $cart = OrderHelper::getCheckoutData();

        $customer_id    = $cart['user_id'];
        $customer_phone = $cart['user_phone'];
        $customer_email = $cart['user_email'];
        $order_id       = $cart['invoice_id'];
        $order_amount   = $cart['total'];

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => $order_id,
            'user' => $customer_id,
            'mobile_number' => $customer_phone,
            'email' => $customer_email,
            'amount' => $order_amount,
            'callback_url' => url('/paytm/payment/status')
        ]);
        try {
            return $payment->receive();
        } catch(Exception $e) {
            session()->flash('payment_fail', __('Error processing Paytm payment for Order No. #:order_id', ['order_id'=>$cart['invoice_id']]));
            // Send Email for Payment Failed
            try {
                $order = Order::findOrFail($cart['invoice_id'] - 10000);
                Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
            } catch (\Exception $e) {}

            return redirect(route('front.cart.index'));
        }
    }

    public function getExpressCheckoutSuccess($payment_data)
    {
        if (in_array(strtoupper($payment_data['STATUS']), ['SUCCESS', 'TXN_SUCCESS'])) {
            $order_id = $payment_data['ORDERID'];
            $orderId = $order_id - 10000;
            $order = Order::findOrFail($orderId);
            try {
                DB::beginTransaction();
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    $status = $payment_data['RESPMSG'];
                    if($status == "Txn Success") {
                        foreach($order->products as $product) {
                            $product->decreaseStock($product->pivot->quantity, $order->id);
                        }
                        $order->transaction_id = $payment_data['TXNID'];
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

            return redirect('/');
        } else {
            OrderHelper::getExpressCheckoutCancel($payment_data['ORDERID']);
        }
    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        if($transaction->isSuccessful()){
            $this->getExpressCheckoutSuccess($response);
        } else if($transaction->isFailed()){
            OrderHelper::getExpressCheckoutCancel($transaction->getOrderId());
        } else if($transaction->isOpen()){
            OrderHelper::getExpressCheckoutCancel($transaction->getOrderId());
        }
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
        return redirect('/');
    }
}
