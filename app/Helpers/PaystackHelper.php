<?php

namespace App\Helpers;

class PaystackHelper {

    public static function getPaystackKeys(){
        if(config('paystack.mode') == 'sandbox' && config('paystack.enable') == '1') {
            return [
                'paystack_secret_key' => config('paystack.sandbox')['secret_key'],
                'paystack_public_key' => config('paystack.sandbox')['public_key'],
            ];

        } elseif(config('paystack.mode') == 'live' && config('paystack.enable') == '1') {
            return [
                'paystack_secret_key' => config('paystack.live')['secret_key'],
                'paystack_public_key' => config('paystack.live')['public_key'],
            ];

        } else {
            return FALSE;
        }
    }

    public static function handlePaystackRequest($user_email, $order_id, $order_amt){
        if($paystack_keys = PaystackHelper::getPaystackKeys()){
            define('SECRET_KEY',$paystack_keys['paystack_secret_key']);
            define('PUBLIC_KEY',$paystack_keys['paystack_secret_key']);
        }else{
            $message = 'Payment Failed! Error in using Paystack Payments! Please Try Again Later.';
            return [
                'type'    => 'error',
                'message' => $message,
            ];
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount'    => $order_amt*100,
                'email'     => $user_email,
                "metadata"  => [
                    'invoice_id'    => $order_id,
                    'custom_fields' => [
                        [
                            "display_name" => "Currency",
                            "variable_name" => "currency",
                            "value" => 'USD'
                        ]
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer ".SECRET_KEY, //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);


        if($err){
            $message = 'Curl returned error: ' . $err;
            return [
                'type'    => 'error',
                'message' => $message,
            ];
        }

        $tranx = json_decode($response, true);
        if(!$tranx['status']){
            $message = 'API returned error: ' . $tranx['message'];
            return [
                'type'    => 'error',
                'message' => $message,
            ];
        }else{
            $message = $tranx['data']['authorization_url'];
            return [
                'type'          => 'success',
                'paystack_link' => $message,
            ];
        }
    }
}
