<?php
 return array (
  'default' => 'USD',
  'api_key' => '',
  'driver' => 'database',
  'cache_driver' => NULL,
  'drivers' => 
  array (
    'database' => 
    array (
      'class' => 'Torann\\Currency\\Drivers\\Database',
      'connection' => NULL,
      'table' => 'currencies',
    ),
    'filesystem' => 
    array (
      'class' => 'Torann\\Currency\\Drivers\\Filesystem',
      'disk' => NULL,
      'path' => 'currencies.json',
    ),
  ),
  'formatter' => NULL,
  'formatters' => 
  array (
    'php_intl' => 
    array (
      'class' => 'Torann\\Currency\\Formatters\\PHPIntl',
    ),
  ),
) ;