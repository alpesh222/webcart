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
  'm_id' => '',
  'm_key' => '',
  'industry_type_id' => 'Retail',
  'channel_id' => 'WEB',
  'website' => 'WEBSTAGING',
  'callback_url' => '/paytm/payment/status',
  'paytm_refund_url' => '',
  'enable' => '0',
) ;