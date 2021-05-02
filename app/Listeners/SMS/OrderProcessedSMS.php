<?php

namespace App\Listeners\SMS;

use Aloha\Twilio\Twilio;
use App\Events\Order\OrderProcessedEvent;
use App\Helpers\SmsHelper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nexmo\Laravel\Facade\Nexmo;

class OrderProcessedSMS
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
     * @param  SMSOrderProcessed  $event
     * @return void
     */
    public function handle(OrderProcessedEvent $event)
    {
        $order = $event->order;

        $mobile = $order->address->phone ? $order->address->phone : '';
        $message = config('sms.messages.order_processed') . ' ' . __('Your Order Number is :order_number. You can manage your order at :url Thank You!', ['order_number' => $order->getOrderId(), 'url' => url('/orders')]);

        SmsHelper::send($mobile, $message);

        return;
    }
}
