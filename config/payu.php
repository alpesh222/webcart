<?php
 return array (
  'required_fields' => 
  array (
    0 => 'txnid',
    1 => 'amount',
    2 => 'productinfo',
    3 => 'firstname',
    4 => 'email',
    5 => 'phone',
  ),
  'optional_fields' => 
  array (
    0 => 'udf1',
    1 => 'udf2',
    2 => 'udf3',
    3 => 'udf4',
    4 => 'udf5',
    5 => 'udf6',
    6 => 'udf7',
    7 => 'udf8',
    8 => 'udf9',
    9 => 'udf10',
  ),
  'additional_fields' => 
  array (
    0 => 'lastname',
    1 => 'address1',
    2 => 'address2',
    3 => 'city',
    4 => 'state',
    5 => 'country',
    6 => 'zipcode',
  ),
  'endpoint' => 'payu.in/_payment',
  'redirect' => 
  array (
    'surl' => 'tzsk/payment/success',
    'furl' => 'tzsk/payment/failed',
  ),
  'enable' => '0',
  'env' => 'test',
  'default' => 'payumoney',
  'accounts' => 
  array (
    'payubiz' => 
    array (
      'key' => NULL,
      'salt' => NULL,
      'money' => false,
      'auth' => NULL,
    ),
    'payumoney' => 
    array (
      'key' => NULL,
      'salt' => NULL,
      'money' => true,
      'auth' => NULL,
    ),
  ),
  'driver' => 'session',
  'table' => 'payu_payments',
) ;