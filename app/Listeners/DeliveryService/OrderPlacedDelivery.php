<?php

namespace App\Listeners\DeliveryService;

use App\Events\Order\OrderPlacedEvent;
use App\Helpers\DeliveryHelper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlacedDelivery
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPlacedEvent  $event
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
        $order = $event->order;
        $order_amt = $order->total;
        if ($order->payment_method == 'Cash on Delivery'){
            $payment_method = 'cod';
            $cod_amt = $order_amt;
        }else{
            $payment_method = 'Prepaid';
            $cod_amt = 0;
        }
        $total_qty = !empty($order->quantity) ? $order->quantity : 0;
        $return_add = $return_city = $return_country = $return_name = $return_phone = $return_pin = $return_state = '';
        $delivery_enable    = config('delivery.enable');
        $service_name       = config('delivery.service');
        if ($delivery_enable != 0 && !empty($service_name)) {
            $service_enable = config($service_name.'enable');
            if ($service_enable != 0){
                $return_add     = config($service_name.'return_add') != NULL ? config($service_name.'return_add') : '';
                $return_city    = config($service_name.'return_city') != NULL ? config($service_name.'return_city') : '';
                $return_country = config($service_name.'return_country') != NULL ? config($service_name.'return_country') : '';
                $return_name    = config($service_name.'return_name') != NULL ? config($service_name.'return_name') : '';
                $return_phone   = config($service_name.'return_phone') != NULL ? config($service_name.'return_phone') : '';
                $return_pin     = config($service_name.'return_pin') != NULL ? config($service_name.'return_pin') : '';
                $return_state   = config($service_name.'return_state') != NULL ? config($service_name.'return_state') : '';
            }
        }

        $order_details = array(
            'order'             => $order->getOrderId(),
            'invoice_reference' => $order->getOrderId(),
            "order_date"        => $order->created_at->toDateTimeString(),
            "add"               => $order->address->address,
            "phone"             => $order->address->phone,
            "payment_mode"      => $payment_method,
            "name"              => $order->address->first_name.' '.$order->address->last_name,
            "city"              => $order->address->city,
            "state"             => $order->address->state,
            "country"           => $order->address->country,
            "pin"               => $order->address->zip,
            "return_add"        => $return_add,
            "return_city"       => $return_city,
            "return_country"    => $return_country,
            "return_name"       => $return_name,
            "return_phone"      => $return_phone,
            "return_pin"        => $return_pin,
            "return_state"      => $return_state,
            "quantity"          => $total_qty,
            "cod_amount"        => $cod_amt,
            "total_amount"      => $order_amt,
        );
        DeliveryHelper::addOrderDelivery($order_details);
        return;
    }
}
