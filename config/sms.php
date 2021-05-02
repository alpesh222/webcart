<?php
 return array (
  'enable' => 0,
  'carrier' => 'pointsms',
  'msgclub' => 
  array (
    'auth_key' => NULL,
    'senderId' => NULL,
    'routeId' => '1',
    'sms_content_type' => 'Unicode',
  ),
  'pointsms' => 
  array (
    'username' => NULL,
    'password' => NULL,
    'senderId' => NULL,
    'channel' => 'Trans',
    'route' => '02',
  ),
  'nexmo' => 
  array (
    'from' => '16105552344',
  ),
  'textlocal' => 
  array (
    'api_key' => NULL,
    'sender' => 'TXTLCL',
  ),
  'twilio' => 
  array (
    'senderId' => NULL,
    'auth_token' => NULL,
    'from' => NULL,
  ),
  'ebulk' => 
  array (
    'user_name' => NULL,
    'api_key' => NULL,
    'json_url' => 'http://api.ebulksms.com:8080/sendsms.json',
    'xml_url' => 'http://api.ebulksms.com:8080/sendsms.xml',
    'http_get_url' => 'http://api.ebulksms.com:8080/sendsms',
    'flash' => '0',
  ),
  'messages' => 
  array (
    'order_placed' => 'We have received your order.',
    'order_processed' => 'Order Delivered.',
    'order_packaged' => 'Your Order is Packed and ready to shipped.',
  ),
) ;