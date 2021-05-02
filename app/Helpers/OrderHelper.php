<?php

namespace App\Helpers;

use App\Customer;
use App\Mail\PaymentFailed;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderHelper {
    public static function getCheckoutData()
    {
        $order = Order::createOrder(true);
        $customer_id = $order->customer_id;
        $user_data = Customer::select('phone','email')->where('id',$customer_id)->get()->first();
        $data = [];
        $data['items'] = [];
        $total =  $order->total - $order->wallet_amount - $order->coupon_amount + (($order->total * $order->tax) / 100) + $order->shipping_cost;
        $total = round($total, 2);
        array_push($data['items'], [
            'name'  => 'Cart total',
            'price' => $total,
            'qty'   => 1,
        ]);

        $data['invoice_id']             = $order->getOrderId();
        $data['invoice_description']    = "Invoice for Order #".$data['invoice_id'];
        $data['total']                  = $total;
        $data['user_id']                = $customer_id;
        $data['user_email']             = $user_data->email;
        $data['user_phone']             = $user_data->phone;

        return $data;
    }

    public static function getExpressCheckoutCancel($order_id)
    {
        session()->flash('payment_fail', __('Error processing payment for Order No. #:order_id', ['order_id'=>$order_id]));
        // Send Email for Payment Failed
        try {
            $order = Order::findOrFail($order_id - 10000);
            Mail::to(Auth::user()->email)->send(new PaymentFailed($order));
        } catch (\Exception $e) {}

        return redirect(route('front.cart.index'));
    }

    public static function clearCart()
    {
        Cart::destroy();
        session()->forget('customer_id');
        session()->forget('payment_method');
        session()->forget('cart_data');
    }






}