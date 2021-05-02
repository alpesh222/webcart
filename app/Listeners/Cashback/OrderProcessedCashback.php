<?php

namespace App\Listeners\Cashback;

use App\Events\Order\OrderProcessedEvent;
use App\Wallet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderProcessedCashback
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
     * @param  OrderProcessedEvent  $event
     * @return void
     */
    public function handle(OrderProcessedEvent $event)
    {
        $cashback_max_order_amt = (float)config('cashback.max_order_amt');
        $order_data         = $event->order;
        if(config('cashback.enable') &&  $order_data->total >= $cashback_max_order_amt){
            $cashback_amt       = config('cashback.amount');
            $cashback_type      = config('cashback.type');
            $cashback_max_usage = config('cashback.max_usage');

            $user_id            = $order_data->user_id;
            $wallet_cashback    = wallet::where('user_id',$user_id)
                                        ->where('transaction_code','tr_cashback_code')
                                        ->get()->toArray();
            if(count($wallet_cashback) < $cashback_max_usage){
                if($cashback_type == 'FLAT'){ $amount = (int)$cashback_amt; }
                else{
                    $cashback_percent = (int)$cashback_amt;
                    $amount = ($cashback_percent * (float)$order_data->total)/100;
                }
                $wallet     = new Wallet();
                $action     = 'credit';
                $txn_code   = 'tr_cashback_code';
                $txn_des    = 'Cr. W.A. '.$amount.'/- | Cashback For Order Number : #'. ($order_data->id + 1000);
                $wallet->walletTransaction($amount, $action, $txn_code, $user_id, $txn_des);
            }
        }
        return;
    }
}
