<?php

namespace App\Http\Controllers;

use App\Events\Order\OrderPlacedEvent;
use App\Helpers\OrderHelper;
use App\Helpers\PaytmHelper;
use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Knox\Pesapal\Facades\Pesapal;

class PesapalController extends Controller
{
    public function getPaytmCheckout()
    {
        $cart = OrderHelper::getCheckoutData();
        $order_details = array(
            'amount'        => $cart['total'],
            'description'   => "Payment For Order Number : #".$cart['invoice_id'].' | Order Amount : '.currency_format($cart['total'],config('currency.default')),
            'type'          => config('pesapal.type'),
            'email'         => $cart['user_email'],
            'phonenumber'   => $cart['user_phone'],
            'reference'     => $cart['invoice_id'],
            'currency'      => config('currency.default'),
            'height'        => '800px',
        );

        $iFrame = Pesapal::makePayment($order_details);
        if(empty($iFrame)){
            session()->flash('payment_fail', __('Error processing Paytm payment for Order No. #:order_id', ['order_id'=>$cart['invoice_id']]));
            // Send Email for Payment Failed
            try {
                $order = Order::findOrFail($cart['invoice_id'] - 10000);
                Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
            } catch (\Exception $e) {}

            return redirect(route('front.cart.index'));
        }else{
            session(['cart_data' => $cart]);

            return view( 'partials.front.pesapal.pesapalPaymentForm', compact( 'iFrame'));
        }
    }

    public function paymentSuccess(Request $request)//just tells u payment has gone thru..but not confirmed // Callback Url
    {
        $tracking_id    = $request->input('tracking_id'); //Txn id
        $order_id       = $request->input('merchant_reference');

        $order = Order::where('id',$order_id - 10000)->first();
        $order->transaction_id = $tracking_id;
        $order->status = 'Payment in Pending Stage';
        $order->save();
        //go back home
        return view('partials.front.pesapal.pesapalPaymentConfirmation');
    }

    public function paymentConfirmation(Request $request)
    {
        $tracking_id                = $request->input('pesapal_transaction_tracking_id');
        $merchant_reference         = $request->input('pesapal_merchant_reference'); // Order Id
        $pesapal_notification_type  = $request->input('pesapal_notification_type');

        //use the above to retrieve payment status now..
        $this->checkPaymentStatus($tracking_id,$merchant_reference,$pesapal_notification_type);
        return redirect('/');
    }

    //Confirm status of transaction and update the DB
    public function checkPaymentStatus($tracking_id,$merchant_reference,$pesapal_notification_type){
        $status         = Pesapal::getMerchantStatus($merchant_reference);
        $order_data     = Order::where('transaction_id',$tracking_id)->first();
        if($status == 'COMPLETE'){
            $order_data->Order_Status = 'COMPLETE';
            $this->getExpressCheckoutSuccess($order_data);
        }else{
            OrderHelper::getExpressCheckoutCancel();
        }
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
        return redirect('/');
    }

    public function getExpressCheckoutSuccess($payment_data)
    {

        if (in_array(strtoupper($payment_data->Order_Status), ['SUCCESS', 'COMPLETE'])) {
            $orderId = $payment_data->id;
            $order = Order::findOrFail($orderId);
            try {
                DB::beginTransaction();
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    // Perform transaction on PayPal
                    $status = $payment_data->Order_Status;
                    if($status == "COMPLETE") {
                        foreach($order->products as $product) {
                            $product->decreaseStock($product->pivot->quantity, $order->id);
                        }
                        $order->status          = 'To be dispatched.';
                        $order->paid            = 1;
                        $order->payment_date    = Carbon::now();
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
        }else{
            OrderHelper::getExpressCheckoutCancel();
        }
    }

}
