<?php
 return array (
  'mailgun' => 
  array (
    'domain' => env('MAILGUN_DOMAIN', ''),
    'secret' => env('MAILGUN_SECRET', ''),
  ),
  'ses' => 
  array (
    'key' => NULL,
    'secret' => NULL,
    'region' => 'us-east-1',
  ),
  'sparkpost' => 
  array (
    'secret' => NULL,
  ),
  'stripe' => 
  array (
    'model' => 'App\\User',
    'key' => NULL,
    'secret' => NULL,
  ),
 'paytm-wallet' => [
     'env'              => config('paytm.mode'),
     'merchant_id'      => config('paytm.m_id'),
     'merchant_key'     => config('paytm.m_key'),
     'merchant_website' => config('paytm.website'),
     'channel'          => config('paytm.channel_id'),
     'industry_type'    => config('paytm.industry_type_id'),
 ],
) ;