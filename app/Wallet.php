<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id','transaction_code','transaction_amt','credit_amt','debit_amt','wallet_balance','transaction_description','transaction_currency','wallet_amt_status'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function walletTransaction($amount, $action, $txn_code, $user_id, $txn_des){
        if ($action == 'credit'){   $cr_amt = $amount ? $amount : 0;    $dr_amt = 0.00; }
        else{   $cr_amt = 0.00; $dr_amt = $amount ? $amount : 0;    }
        try{
            $user_data = User::findOrFail($user_id);
            $left_wallet_bal = (float)$user_data->wallet_balance + (float)$amount;
            self::create([
                'user_id'           => $user_id,
                'transaction_code'  => $txn_code,
                'transaction_amt'   => $amount ? $amount : 0,
                'credit_amt'        => $cr_amt,
                'debit_amt'         => $dr_amt,
                'wallet_balance'    => $left_wallet_bal,
                'transaction_description'   => $txn_des,
                'transaction_currency'      => config('currency.default'),
                'wallet_amt_status'         => 1,
            ]);

            $user_data->wallet_balance = $left_wallet_bal;
            $user_data->save();
            return true;
        }
        catch (\Exception $e){
            return false;
        }



    }

}
