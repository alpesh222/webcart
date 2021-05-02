<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use Illuminate\Support\Facades\Mail;
use App\Customer;
use App\Order;
use DB;
use App\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use App\Events\Order\OrderPlacedEvent;

class PaypalController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function getExpressCheckout()
    {
        $cart = $this->getCheckoutData();
        try {
            $response = $this->provider->setExpressCheckout($cart);
            session(['cart_data' => $cart]);
            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            session()->flash('payment_fail', __('Error processing PayPal payment for Order No. #:order_id', ['order_id'=>$cart['invoice_id']]));

            // Send Email for Payment Failed
            try {
                $order = Order::findOrFail($cart['invoice_id'] - 10000);
                Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
            } catch (\Exception $e) {}

            return redirect(route('front.cart.index'));
        }
    }

    public function getExpressCheckoutSuccess(Request $request)
    {
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $cart = session('cart_data');

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $orderId = $cart['invoice_id'] - 10000;
            $order = Order::findOrFail($orderId);
            try {
                DB::beginTransaction();
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    // Perform transaction on PayPal
                    $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                    $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                    if($status == "Completed") {
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
                    } else {
                        session()->flash('payment_fail', __('Error processing PayPal payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
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
                $this->clearCart();
            }
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
            return redirect('/');
        }
    }

    public function getExpressCheckoutCancel(Request $request)
    {
        $cart = session('cart_data');

        session()->flash('payment_fail', __('Error processing PayPal payment for Order No. #:order_id', ['order_id'=>$cart['invoice_id']]));

        // Send Email for Payment Failed
        try {
            $order = Order::findOrFail($cart['invoice_id'] - 10000);
            Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
        } catch (\Exception $e) {}
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
        return redirect(route('front.cart.index'));
    }

    protected function getCheckoutData()
    {
        $order = Order::createOrder(true);
        $data = [];
        $data['items'] = [];
        $total =  $order->total - $order->wallet_amount - $order->coupon_amount + (($order->total * $order->tax) / 100) + $order->shipping_cost;
        if(config('currency.default') == 'USD') {
            $total = round($total, 2);
        } else {
            $total = round($this->convertCurrency($total, config('currency.default'), "USD"), 2);
        }
        array_push($data['items'], [
            'name'  => 'Cart total',
            'price' => $total,
            'qty'   => 1,
        ]);

        $data['invoice_id'] = $order->getOrderId();
        $data['invoice_description'] = "Invoice for Order #".$data['invoice_id'];
        $data['return_url'] = url('/paypal/ec-checkout-success');
        $data['cancel_url'] = url('/paypal/ec-checkout-cancel');
        $data['total'] = $total;

        return $data;
    }

    private function convertCurrency($amount, $from, $to) {
        return \App\Helpers\Helper::convertCurrency($amount, $from, $to);
    }

    private function clearCart()
    {
        Cart::destroy();
        session()->forget('customer_id');
        session()->forget('payment_method');
        session()->forget('cart_data');
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
    }
}
