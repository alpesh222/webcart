<?php
 return array (
  'enable' => '0',
  'mode' => 'SANDBOX',
  'consumer_key' => NULL,
  'consumer_secret' => NULL,
  'type' => 'MERCHANT',
  'currency' => 'KES',
  'ipn' => 'PesapalController@paymentConfirmation',
  'live' => false,
  'callback_route' => 'pesapal.paymentSuccess',
  'currency_support' => 
  array (
    0 => 'KES',
  ),
) ;