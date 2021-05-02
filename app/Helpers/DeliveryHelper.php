<?php

namespace App\Helpers;
use App\Mail\OrderPackaged;
use App\Mail\OrderPlaced;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Exception;


class DeliveryHelper {
    public static function checkDeliveryServicePinCodeAvailability($pin_code) {
        $delivery_enable    = config('delivery.enable') ? config('delivery.enable') : 0;
        $delivery_service   = config('delivery.service') ? config('delivery.service') : 'delhivery';

        if( $delivery_enable ) {
            $service_enable =  config($delivery_service.'.enable');
            if( empty(config('delivery.service')) || ( isset($service_enable) && config($delivery_service.'.enable') == 0 ) ) {
                $response = array(
                    'status'    => 'error',
                    'data'      => __('Delivery Service is Disabled. Please Contact Our Support Team!')
                );
                return $response;
            }

            $headers = array();
            $service_mode   = config($delivery_service.'.mode');
            $Api_Key        = config($delivery_service.'.api_key.'.$service_mode);
            $pin_code_url   = config($delivery_service.'.available_pin_codes.'.$service_mode);

            $headers = array(
                'accept: application/json',
                'authorization:'.$Api_Key
            );

            switch ($delivery_service) {
                case 'delhivery':
                    $arr_params = array( 'token' => $Api_Key, 'filter_codes' => $pin_code );
                    $result = self::checkPinCodeAvailability($pin_code_url, $arr_params, $headers);
                    break;
                default:
                    break;
            }
            if (!empty($result)){
                $response = array(
                    'status'    => $result['status'],
                    'data'      => $result['data']
                );
            }else{
                $response = array(
                    'status'    => 'error',
                    'data'      => __('Delivery Service is Temporarily Down. Please Contact Our Support Team!')
                );
            }
        }else{
            $response = array(
                'status'    => 'success',
                'data'      => __('Delivery Service In Disabled.')
            );
        }
        return $response;
    }

    public static function checkPinCodeAvailability($url, $arr_params, $headers = array('Content-Type: application/json')) {
        $response = array();
        $final_url_data = '';
        $get_request = '';
        foreach ($arr_params as $key => $value){
            if ($get_request == ''){
                $get_request .= $key . '=' . $value;
            }else{
                $get_request .= '&' . $key . '=' . $value;
            }
        }
        $final_url_data = $url.$get_request;
        if( !empty($final_url_data) && !empty($headers) && !empty($get_request) ) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $final_url_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response       = json_decode(curl_exec($ch));
            $delivery_codes = !empty($response->delivery_codes) ? $response->delivery_codes : array();
            $err = curl_error($ch);
            if ($err) {
                return array(
                    'status'    => 'error',
                    'data'      => __("Delivery Service is Temporarily Down. Please Contact Our Support Team!")
                );
            }
            curl_close($ch);
            if (count($delivery_codes) > 0){
                return array(
                    'status'    => 'success',
                    'data'      => __("Shipping Available To Entered Pincode")
                );
            }else{
                return array(
                    'status'    => 'error',
                    'data'      => __("Shipping Not Available To Entered Pincode")
                );
            }
        }else{
           return array(
                'status'    => 'success',
                'data'      => __("Delivery Service is keys are Missing. Please Contact Our Support Team!")
            );
        }
    }

    public static function addOrderDelivery($order_details) {
        $delivery_enable    = config('delivery.enable') ? config('delivery.enable') : 0;
        $delivery_service   = config('delivery.service') ? config('delivery.service') : 'delhivery';

        if( $delivery_enable ) {
            $service_enable =  config($delivery_service.'.enable');
            if( empty(config('delivery.service')) || ( isset($service_enable) && config($delivery_service.'.enable') == 0 ) ) {
                return false;
            }

            $headers = array();
            $service_mode       = config($delivery_service.'.mode');
            $Api_Key            = config($delivery_service.'.api_key.'.$service_mode.'_token');
            $order_create_url   = config($delivery_service.'.order_create.'.$service_mode);
            $client_name        = config($delivery_service.'.client_name.'.$service_mode);

            $headers = array(
                'authorization:'.$Api_Key,
                'Content-Type: application/json',
            );
            $pickup_location = array(
                "name"      => config($delivery_service.'.warehouse_name'),
                "city"      => config($delivery_service.'.warehouse_city'),
                "pin"       => config($delivery_service.'.warehouse_pin'),
                "country"   => config($delivery_service.'.warehouse_country'),
                "phone"     => config($delivery_service.'.warehouse_phone'),
                "add"       => config($delivery_service.'.warehouse_address')
            );
            switch ($delivery_service) {
                case 'delhivery':
                    $order_details['client'] = !empty($client_name) ? $client_name : '';
                    $arr_params = array( 'shipments' => [$order_details], 'pickup_location' => $pickup_location );
                    $json_params = json_encode($arr_params);
                    $parameter_format = 'format=json&data='.$json_params;
                    $response = self::createOrderDeliveryService($order_create_url, $parameter_format, $headers);
                    if($response) {
                        try{
                            if (!empty($response->packages)) {
                                $order = Order::where('id', ($order_details['order'] - 10000) )->first();
                                $order->tracking_id         = !empty($response->packages[0]->waybill) ? $response->packages[0]->waybill : '';
                                $order->updated_at          = date('Y-m-d h:i:s', time());
                                $order->delivery_service    = config('delivery.service');
                                $order->save();
                            }
                        }catch (\Exception $e){
                            return false;
                        }
                    }
                    break;
                default:
                    break;
            }
            try{
                Mail::to($order->customer->email)->send(new OrderPackaged($order));
            }catch (\Exception $e){}
            try{
                $tracking_data = '';
                if( !empty ( $order->tracking_id ) ):
                    $tracking_data = ' '. __('You can Track your Order using tracking id :tracking_id', ['tracking_id' => $order->tracking_id]) .'.';
                endif;
                $mobile = $order_details['phone'] ? $order_details['phone'] : '';
                $message = config('sms.messages.order_packaged') . ' ' . __('Your Order Number is :order_number.',[ 'order_number' => $order->getOrderId() ]) . $tracking_data .' '.__('You can manage your order at :url Thank You!', ['url' => url('/orders')]);
                SmsHelper::send($mobile, $message);
            }catch (\Exception $e){}
        }
        return;
    }

    public static function createOrderDeliveryService($url, $json_params, $headers = array('Content-Type: application/json')) {
        try{
            if( !empty($url) && !empty($headers) && !empty($json_params) ) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_params);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $err = curl_error($ch);
                if ($err) {
                    return false;
                }
                curl_close($ch);
                return json_decode($response);
            }
        }catch (\Exception $e){
            return false;
        }
        return false;
    }



}
