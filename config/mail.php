<?php
 return array (
  'driver' => env('MAIL_DRIVER', 'smtp'),
  'host' => env('MAIL_HOST', ''),
  'port' => env('MAIL_PORT', ''),
  'from' => 
  array (
    'address' => env('MAIL_FROM_ADDRESS', 'noreply@domain.com'),
    'name' => env('MAIL_FROM_NAME', 'Weblizar SHOP'),
  ),
  'encryption' => env('MAIL_ENCRYPTION', 'tls'),
  'username' => env('MAIL_USERNAME', ''),
  'password' => env('MAIL_PASSWORD', ''),
  'sendmail' => '/usr/sbin/sendmail -bs',
  'markdown' => 
  array (
    'theme' => 'default',
    'paths' => 
    array (
      0 => 'C:\\xampp\\htdocs\\laravel\\webcart\\resources\\views/vendor/mail',
    ),
  ),
) ;