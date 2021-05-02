<?php

namespace App\Http\Controllers;

use App\Country;
use App\Events\Order\OrderCheckoutProcessEvent;
use App\Helpers\DeliveryHelper;
use App\Helpers\OrderHelper;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Customer;
use App\Order;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Events\Order\OrderPlacedEvent;

class CheckoutController extends Controller
{
    public function shipping()
    {
        if(Cart::count() < 1) {
            return redirect(route('front.cart.index'));
        }
        if (!session('shipping_availability') && config('settings.enable_zip_code')){
            session()->flash('payment_fail', __("Shipping Not Available To Entered Pincode"));
            return redirect(url('/cart'));
        }
        if(!session()->has('customer_id')) {
            $user = Auth::user();
            $addresses = $user->customers()->get();
            $countries = Country::getAllActiveCountries();
            return view('checkout.shipping-details', compact('addresses','countries'));
        }

        return redirect(route('checkout.payment'));
    }

    public function payment()
    {
        if (!session('shipping_availability') && config('settings.enable_zip_code')){
            session()->flash('payment_fail', __("Shipping Not Available To Entered Pincode"));
            session()->forget('customer_id');
            return redirect(url('/checkout/shipping-details'));
        }

        if(!session()->has('customer_id')) {
            session()->flash('payment_fail', __("Please provide shipping address."));
            return redirect(route('checkout.shipping'));
        }

        if(Cart::count() < 1) {
            session()->flash('payment_fail', __("There is no product in your cart."));
            return redirect(route('front.cart.index'));
        }

        $customer = Customer::findOrFail(session('customer_id'));
        $cartItems = Cart::content();
        // (Check Pin Code Availability)
        $customer_pin_code = !empty($customer->zip) ? $customer->zip : '';
        $delivery_zip_response = DeliveryHelper::checkDeliveryServicePinCodeAvailability($customer_pin_code);
        if ($delivery_zip_response['status'] == 'error'){
            session()->flash('payment_fail', $delivery_zip_response['data']);
            session()->forget('customer_id');
            return redirect(url('/checkout/shipping-details'));
        }

        return view('checkout.payment', compact('cartItems', 'customer'));
    }

    public function refreshCheckoutPage(Request $request){
        if ($request->has('wallet_used')){
            if ($request->get('wallet_used') == 1){
                session()->put('wallet_used',$request->get('wallet_used'));
                session()->put('wallet_used_amt',$request->get('wallet_used_amt'));
            }else{
                session()->put('wallet_used',0);
                session()->put('wallet_used_amt',0);
            }
//            print_r($request->get('wallet_used_amt'). ' >>>>>>>>>>>>>>>>>' . session('wallet_used_amt'));exit;
        }

        if(Cart::count() < 1) {
            session()->flash('payment_fail', __("There is no product in your cart."));
            return 0;
        }
        $cartItems = Cart::content();
        return view('partials.front.includes.checkout', compact('cartItems'));
    }

    public function processPayment(Request $request)
    {
        if(Cart::count() < 1) {
            session()->flash('payment_fail', __("There is no product in your cart."));
            return redirect(route('front.cart.index'));
        }

        if(!(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())) {
            session()->forget('coupon_amount');
            session()->forget('coupon_valid_above_amount');
        }


        $user = Auth::user();
        if(!(config('wallet.enable') && session()->has('wallet_used') && session()->get('wallet_used') == 1  && session()->has('wallet_used_amt') && session('wallet_used_amt') <= $user->walletBalance())) {
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
        }

        if(!session()->has('customer_id')) {
            session()->flash('payment_fail', __("Session expired."));
            return redirect(route('checkout.shipping'));
        }

        session(['tax_rate' => config('settings.tax_rate')]);
        
        if(config('settings.shipping_cost_valid_below') > Cart::total()) {
            session(['shipping_cost' => config('settings.shipping_cost')]);
        } else {
            session(['shipping_cost' => 0]);
        }

        $coupon_amount = session()->has('coupon_amount') ? session('coupon_amount') : 0;
        $wallet_used_amt = session()->has('wallet_used_amt') ? session('wallet_used_amt') : 0;

        if($request->options == 'cod' && config('cod.enable')) {

            session(['payment_method' => 'Cash on Delivery']);
            try {
                DB::beginTransaction();
                $order = Order::createOrder(true);
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    foreach($order->products as $product) {
                        $product->decreaseStock($product->pivot->quantity, $order->id);
                    }

                    DB::commit();
                    Cart::destroy();
                    session()->forget('customer_id');
                    session()->forget('payment_method');
                    session()->flash('payment_success', __("Your order has been successfully placed. Order No. #:order_id", ['order_id'=>$order->getOrderId()]));
                    // Send Email
                    try {
                        Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
                    } catch (\Exception $e) {}

                    // Order Placed Event
                    event(new OrderPlacedEvent($order));
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $exception) {
                session()->flash('payment_fail', __("Sorry, your order was not placed successfully."));
                DB::rollBack();
                Cart::destroy();
                session()->forget('payment_method');
            }
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
            return redirect('/');

        } elseif($request->options == 'banktransfer' && config('banktransfer.enable')) {

            $bank_transfer_reference_id = $request->bank_transfer_reference_id;
            if(!$bank_transfer_reference_id) {
                return redirect()->back()->withErrors(['bank_transfer_reference_id' => __('Please provide reference transaction ID.')])->withInput($request->input());
            }

            session(['payment_method' => 'Bank Transfer']);
            try {
                DB::beginTransaction();
                $order = Order::createOrder(true);
                $is_stock_available = Product::isStockAvailable($order->products);
                if($is_stock_available) {
                    foreach($order->products as $product) {
                        $product->decreaseStock($product->pivot->quantity, $order->id);
                    }

                    $order->saveTransactionID($bank_transfer_reference_id);

                    DB::commit();
                    Cart::destroy();
                    session()->forget('customer_id');
                    session()->forget('payment_method');
                    session()->flash('payment_success', __("Your order has been successfully placed. Order No. #:order_id", ['order_id'=>$order->getOrderId()]));
                    // Send Email
                    try {
                        Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
                    } catch (\Exception $e) {}

                    // Order Placed Event
                    event(new OrderPlacedEvent($order));
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $exception) {
                session()->flash('payment_fail', __("Sorry, your order was not placed successfully."));
                DB::rollBack();
                Cart::destroy();
                session()->forget('payment_method');
            }
            session()->forget('wallet_used');
            session()->forget('wallet_used_amt');
            return redirect('/');

        } elseif($request->options == 'paypal' && config('paypal.enable')) {

            session(['payment_method' => 'Paypal']);
            $paypalController = new PaypalController();
            return $paypalController->getExpressCheckout();

        } elseif($request->options == 'paytm' && config('paytm.enable')) {

            session(['payment_method' => 'Paytm']);
            $paytmController = new PaytmController();
            return $paytmController->getPaytmCheckout();

        } elseif($request->options == 'pesapal' && config('pesapal.enable')) {

            session(['payment_method' => 'Pesapal']);
            $pesapalController = new PesapalController();
            return $pesapalController->getPaytmCheckout();

        }  elseif($request->options == 'paystack' && config('paystack.enable')) {

            session(['payment_method' => 'Paystack']);
            $paystackController = new PaystackController();
            return $paystackController->getPaystackCheckout();

        } elseif($request->options == 'razorpay' && config('razorpay.enable')) {

            session(['payment_method' => 'Razorpay']);
            if(config('currency.default') == 'INR') {

                $amount = round((((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100) * 100); // in paisa
            } else {
                $amount = round(
                    $this->convertCurrency(((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100, config('currency.default'), "INR")
                    * 100); // in paisa
            }
            return view('checkout.pay_with_razorpay', compact('amount'));

        } elseif($request->options == 'stripe' && config('stripe.enable')) {

            session(['payment_method' => 'Stripe']);
            if(config('currency.default') == 'USD') {
                $amount = round((((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100) * 100);
            } else {
                $amount = round(
                    $this->convertCurrency(((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100, config('currency.default'), "USD")
                    * 100);
            }
            session(['stripe_amount' => $amount]);
            return view('checkout.pay_with_stripe', compact('amount'));

        } elseif($request->options == 'instamojo' && config('instamojo.enable')) {

            session(['payment_method' => 'Instamojo']);
            if(config('currency.default') == 'INR') {

                $amount = round((((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100));
            } else {
                $amount = round(
                    $this->convertCurrency(((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100, config('currency.default'), "INR"));
            }
	        $instamojoController = new InstamojoController();
	        return $instamojoController->createRequest($amount);

        } elseif(($request->options == 'payumoney' || $request->options == 'payubiz') && config('payu.enable')) {

            if($request->options == 'payumoney') {
                session(['payment_method' => 'PayUmoney']);
            } elseif($request->options == 'payubiz') {
                session(['payment_method' => 'PayUbiz']);
            } else {
                return back();
            }
            if(config('currency.default') == 'INR') {

                $amount = round((((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100));
            } else {
                $amount = round(
                    $this->convertCurrency(((config('settings.shipping_cost_valid_below') > Cart::total()) ? config('settings.shipping_cost') : 0) + Cart::total() - $wallet_used_amt - $coupon_amount + (Cart::total() * config('settings.tax_rate')) / 100, config('currency.default'), "INR"));
            }
            $payuController = new PayUController();
            return $payuController->payment($amount);

        } else {
            return back();
        }
    }

    public function processPaymentGet() {
        return redirect(route('checkout.payment'));
    }

    public function changeShippingAddress()
    {
        session()->forget('customer_id');
        return redirect(route('checkout.shipping'));
    }

    private function convertCurrency($amount, $from, $to) {
        return \App\Helpers\Helper::convertCurrency($amount, $from, $to);
    }
}
