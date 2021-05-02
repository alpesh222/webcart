<?php

namespace App\Helpers;

class CurrencySupportHelper {
    public static function checkCurrencySupport($currency,$payMethod) {
        $payMethod = $payMethod.'CurrencySupport';
        $currency_support = CurrencySupportHelper::$payMethod();
        if(in_array($currency,$currency_support)) {
            return true;
        } else {
            return false;
        }
    }

    protected static function delhiveryCurrencySupport(){
        $currency_support = array ('INR');
        return $currency_support;
    }

    protected static function paypalCurrencySupport(){
        $currency_support = array ('AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'INR', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD',
                                    'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD');
        return $currency_support;
    }

    protected static function stripeCurrencySupport(){
        $currency_support = array ('USD','AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BIF','BMD',
                                    'BND','BOB','BRL','BSD','BWP','BZD','CAD','CDF','CHF','CLP','CNY','COP','CRC','CVE','CZK','DJF','DKK',
                                    'DOP','DZD','EGP','ETB','EUR','FJD','FKP','GBP','GEL','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK',
                                    'HTG','HUF','IDR','ILS','INR','ISK','JMD','JPY','KES','KGS','KHR','KMF','KRW','KYD','KZT','LAK','LBP',
                                    'LKR','LRD','LSL','MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRO','MUR','MVR','MWK','MXN','MYR','MZN',
                                    'NAD','NGN','NIO','NOK','NPR','NZD','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB',
                                    'RWF','SAR','SBD','SCR','SEK','SGD','SHP','SLL','SOS','SRD','STD','SZL','THB','TJS','TOP','TRY','TTD',
                                    'TWD','TZS','UAH','UGX','UYU','UZS','VND','VUV','WST','XAF','XCD','XOF','XPF','YER','ZAR','ZMW');
        return $currency_support;
    }

    protected static function razorpayCurrencySupport(){
        $currency_support = array ('AED','ALL','AMD','ARS','AUD','AWG','BBD','BDT','BMD','BND','BOB','BSD','BWP','BZD','CAD','CHF','CNY','COP',
                                    'CRC','CUP','CZK','DKK','DOP','DZD','EGP','ETB','EUR','FJD','GBP','GIP','GHS','GMD','GTQ','GYD','HKD','HNL',
                                    'HRK','HTG','HUF','IDR','ILS','INR','JMD','KES','KGS','KHR','KYD','KZT','LAK','LBP','LKR','LRD','LSL','MAD',
                                    'MDL','MKD','MMK','MNT','MOP','MUR','MVR','MWK','MXN','MYR','NAD','NGN','NIO','NOK','NPR','NZD','PEN','PGK',
                                    'PHP','PKR','QAR','RUB','SAR','SCR','SEK','SGD','SLL','SOS','SSP','SVC','SZL','THB','TTD','TZS','USD','UYU','UZS','YER','ZAR');
        return $currency_support;
    }

    protected static function instamojoCurrencySupport(){
        $currency_support = array ('INR');
        return $currency_support;
    }

    protected static function payumoneyCurrencySupport(){
        $currency_support = array ('USD','EUR','GBP','AUD','AED','SGD','BHD','NZD','INR','PLN','CZK','DKK','NOK','SEK');
        return $currency_support;
    }

    protected static function payubizCurrencySupport(){
        $currency_support = array ('USD','EUR','GBP','AUD','AED','SGD','BHD','NZD','INR','PLN','CZK','DKK','NOK','SEK');
        return $currency_support;
    }

    protected static function paytmCurrencySupport(){
        $currency_support = array ('INR');
        return $currency_support;
    }

    protected static function paystackCurrencySupport(){
        $currency_support = array ('NGN');
        return $currency_support;
    }

    protected static function pesapalCurrencySupport(){
        $currency_support = array ('KES');
        return $currency_support;
    }
}
