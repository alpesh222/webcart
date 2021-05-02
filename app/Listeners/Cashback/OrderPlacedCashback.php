<?php

namespace App\Listeners\Cashback;


use App\Events\Order\OrderPlacedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlacedCashback
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  OrderPlacedEvent  $event
     * @return void
     */
    public function handle(OrderPlacedEvent $event){}
}
