<?php
 return array (
  'enable' => '0',
  'mode' => 'sandbox',
  'api_key' => 
  array (
    'sandbox' => NULL,
    'sandbox_token' => NULL,
    'live' => NULL,
    'live_token' => NULL,
  ),
  'client_name' => 
  array (
    'sandbox' => NULL,
    'live' => NULL,
  ),
  'warehouse_name' => NULL,
  'warehouse_city' => NULL,
  'warehouse_pin' => NULL,
  'warehouse_country' => NULL,
  'warehouse_phone' => NULL,
  'warehouse_address' => NULL,
  'return_name' => NULL,
  'return_city' => NULL,
  'return_pin' => NULL,
  'return_country' => NULL,
  'return_phone' => NULL,
  'return_state' => NULL,
  'return_address' => NULL,
  'available_pin_codes' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/c/api/pin-codes/json/?',
    'live' => 'https://track.delhivery.com/c/api/pin-codes/json/?',
  ),
  'way_bill' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/waybill/api/bulk/json/?',
    'live' => 'https://track.delhivery.com/waybill/api/bulk/json/?',
  ),
  'order_create' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/api/cmu/create.json',
    'live' => 'https://track.delhivery.com/api/cmu/create.json',
  ),
  'warehouse_creation' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/api/backend/clientwarehouse/create/',
    'live' => 'https://track.delhivery.com/api/backend/clientwarehouse/create/',
  ),
  'pickup_location' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/fm/request/new/',
    'live' => 'https://track.delhivery.com/fm/request/new/',
  ),
  'track_order' => 
  array (
    'sandbox' => 'https://staging-express.delhivery.com/api/packages/json/?',
    'live' => 'https://track.delhivery.com/api/packages/json/?',
  ),
) ;