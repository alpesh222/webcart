<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\PaymentFailed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use Stripe\Charge;
use App\Order;
use DB;
use App\Product;
use Carbon\Carbon;
use App\Events\Order\OrderPlacedEvent;

class StripeController extends Controller
{
    public function payment()
    {
        $order = Order::createOrder(true);
        $amount = session('stripe_amount');
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey(config('stripe.stripe_secret'));

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = request()->stripeToken;

        try {
            DB::beginTransaction();
            $is_stock_available = Product::isStockAvailable($order->products);
            if($is_stock_available) {
                try {
                    // throw new \Exception();
                    // Charge the user's card:
                    $charge = Charge::create(array(
                        "amount" => $amount,
                        "currency" => "USD",
                        "description" => "Total Order Value",
                        "source" => $token,
                    ));
                } catch (\Exception $e) {
                    session()->flash('payment_fail', __('Error processing Stripe payment for Order No. #:order_id', ['order_id'=>$order->getOrderId()]));

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
                session()->flash('payment_success',  __('Your order has been successfully placed. Order No. #:order_id', ['order_id' => $order->getOrderId()]));

                // Send Email for Order Placed
                try {
                    Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
                } catch (\Exception $e) {}

                // Order Placed Event
                event(new OrderPlacedEvent($order));
            } else {
                throw new \Exception();
            }

        } catch (\Exception $exception) {
            session()->flash('payment_fail', __('Sorry, your order was not placed successfully.'));
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
        session()->forget('stripe_amount');
        session()->forget('wallet_used');
        session()->forget('wallet_used_amt');
    }
}