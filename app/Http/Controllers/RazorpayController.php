<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use Session;
use Redirect;
use DB;
use App\Product;
use App\Order;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Events\Order\OrderPlacedEvent;

class RazorpayController extends Controller
{ 
    public function payment()
    {
        $order = Order::createOrder(true);
        //Input items of form
        $input = Input::all();
        //get API Configuration 
        $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));

        try {
            DB::beginTransaction();
            $is_stock_available = Product::isStockAvailable($order->products);
            if($is_stock_available) {
                //Fetch payment information by razorpay_payment_id
                $payment = $api->payment->fetch($input['razorpay_payment_id']);

                if(count($input) && !empty($input['razorpay_payment_id'])) {
                    try {
                        // throw new \Exception();
                        $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

                    } catch (\Exception $e) {
                        session()->flash('payment_fail', __('Error processing Razorpay payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));
                        DB::rollBack();

                        // Send Email for Payment Failed
                        try {
                            Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
                        } catch (\Exception $e) {}

                        return redirect('/');
                    }

                    // Do something here for store payment details in database...
                    foreach($order->products as $product) {
                        $product->decreaseStock($product->pivot->quantity, $order->id);
                    }
                    $order = Order::findOrFail($order->id);
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
                }
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

    private function clearCart()
    {
        Cart::destroy();
        session()->forget('customer_id');
        session()->forget('payment_method');
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
    }
}
