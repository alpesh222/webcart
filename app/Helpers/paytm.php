<?php
 return array (
  'mode' => 'TEST',
  'test' => 
  array (
    'txn_url' => 'https://securegw-stage.paytm.in/order/process',
    'txn_status_url' => 'https://securegw-stage.paytm.in/order/status',
  ),
  'prod' => 
  array (
    'txn_url' => 'https://securegw-stage.paytm.in/theia/processTransaction',
    'txn_status_url' => 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus',
  ),
  'm_id' => 'DIY12386817555501617',
  'm_key' => 'bKMfNxPPf_QdZppa',
  'industry_type_id' => 'Retail',
  'channel_id' => 'WEB',
  'website' => 'WEBSTAGING',
  'callback_url' => '/manage/paytm/paytm-callback',
  'paytm_refund_url' => '',
  'enable' => '1',
  'currency_support' => 
  array (
    0 => 'INR',
  ),
) ;