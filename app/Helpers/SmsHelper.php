<?php

namespace App\Helpers;

use Aloha\Twilio\Twilio;
use Nexmo\Laravel\Facade\Nexmo;

class SmsHelper {
    public static function send($mobile, $message, $otp = false) {
        $send_sms = $otp ? config('settings.phone_otp_verification') : config('sms.enable');

        if($send_sms) {
            if(empty(config('sms.carrier'))) {
                return;
            }

            $carrier = config('sms.carrier');

            switch ($carrier) {
                case 'msgclub':
                    self::msgclub($mobile, $message);
                    break;
                case 'pointsms':
                    self::pointsms($mobile, $message);
                    break;
                case 'nexmo':
                    self::nexmo($mobile, $message);
                    break;
                case 'textlocal':
                    self::textlocal($mobile, $message);
                    break;
                case 'twilio':
                    self::twilio($mobile, $message);
                    break;
                case 'ebulk':
                    self::ebulk($mobile, $message);
                    break;
                default:
                    break;
            }
        }
    }

    private static function msgclub($mobile, $message) {
        try {
            $AUTH_KEY = config('sms.msgclub.auth_key');
            $message = urlencode($message);
            $mobileNos = $mobile;
            $senderId = config('sms.msgclub.senderId');
            $routeId = config('sms.msgclub.routeId');
            $sms_content_type = config('sms.msgclub.sms_content_type');

            if(!empty($AUTH_KEY) && !empty($message) && !empty($mobileNos) && !empty($senderId) && !empty($routeId) && !empty($sms_content_type)) {

                $uri = "AUTH_KEY=$AUTH_KEY&message=$message&senderId=$senderId&routeId=$routeId&mobileNos=$mobileNos&smsContentType=$sms_content_type";
                $url = "http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?".$uri;

                $response = file_get_contents($url);
            }
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    private static function pointsms($mobile, $message) {
        try {
            $username = config('sms.pointsms.username');
            $password = config('sms.pointsms.password');
            $senderId = config('sms.pointsms.senderId');
            $channel = config('sms.pointsms.channel');
            $route = config('sms.pointsms.route');

            if(!empty($username) && !empty($password) && !empty($senderId) && !empty($channel) && !empty($route)) {

                $data = array(
                    "user"     => $username,
                    "password" => $password,
                    "number"   => $mobile,
                    "senderid" => $senderId,
                    "channel"  => $channel,
                    "DCS"      => 0,
                    "flashsms" => 0,
                    "text"     => $message,
                    "route"    => $route,
                );

                $url = 'http://sms.infigosoftware.in/api/mt/SendSMS';

                $query_str = http_build_query($data);

                return file_get_contents("{$url}?{$query_str}");
            }
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    private static function nexmo($mobile, $message) {
        try {
            Nexmo::message()->send([
                'to'   => $mobile,
                'from' => config('sms.nexmo.from') ? config('sms.nexmo.from') : '16105552344',
                'text' => $message
            ]);
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    private static function textlocal($mobile, $message) {
        try {
            $apiKey = config('sms.textlocal.api_key');
            $sender = config('sms.textlocal.sender');
            $message = urlencode($message);
            $sender = urlencode($sender);

            if(!empty($apiKey) && !empty($message) && !empty($mobile) && !empty($sender)) {

                $data = array('apikey' => $apiKey, 'numbers' => $mobile, "sender" => $sender, "message" => $message);

                $ch = curl_init('https://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                return $response;
            }
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    private static function ebulk($mobile, $message) {
        try {
            $apiKey    = config('sms.ebulk.api_key');
            $user_name = config('sms.ebulk.user_name');
            $json_url  = config('sms.ebulk.json_url');
            $flash     = config('sms.ebulk.flash');

            if(!empty($apiKey) && !empty($message) && !empty($mobile) && !empty($user_name)) {
                $response =  self::sendEbulkSms($json_url,$user_name,$apiKey,$flash,$user_name,$message,$mobile);
                return $response;
            }
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    private static function twilio($mobile, $message) {
        try {
            $SID            = config('sms.twilio.senderId');
            $auth_token     = config('sms.twilio.auth_token');
            $from_number    = '+'.config('sms.twilio.from');

            if(!empty($SID) && !empty($message) && !empty($mobile) && !empty($auth_token)) {
                $twilio = new Twilio($SID,$auth_token,$from_number);
                $response = $twilio->message($mobile,$message);
                return $response;
            }
            return;

        } catch (\Exception $e) {
            return;
        }
    }

    public static function sendEbulkSms($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
        $gsm = array();
        $arr_recipient = explode(',', $recipients);
        foreach ($arr_recipient as $recipient) {
            $mobilenumber = trim($recipient);
            if (substr($mobilenumber, 0, 1) == '0'){
                $mobilenumber = substr($mobilenumber, 1);
            }
            elseif (substr($mobilenumber, 0, 1) == '+'){
                $mobilenumber = substr($mobilenumber, 1);
            }
            $generated_id = uniqid('int_', false);
            $generated_id = substr($generated_id, 0, 30);
            $gsm['gsm'][] = array('msidn' => $mobilenumber, 'msgid' => $generated_id);
        }
        $message = array(
            'sender' => $sendername,
            'messagetext' => $messagetext,
            'flash' => "{$flash}",
        );

        $request = array('SMS' => array(
            'auth' => array(
                'username' => $username,
                'apikey' => $apikey
            ),
            'message' => $message,
            'recipients' => $gsm
        ));
        $json_data = json_encode($request);
        if ($json_data) {
            $response = self::doEbulkPostRequest($url, $json_data, array('Content-Type: application/json'));
            $result = json_decode($response);
            // Check If Sms Delivered Successfully or not
            $http_get_url = config('sms.ebulk.http_get_url');
            $response = self::useEbulkHTTPGet($http_get_url, $username, $apikey, $flash, $sendername, $messagetext, $recipients);
            return $response;
        } else {
            $response = 'No Response From the Server!';
            return $response;
        }
    }

    public static function useEbulkHTTPGet($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
        $query_str = http_build_query(array('username' => $username, 'apikey' => $apikey, 'sender' => $sendername, 'messagetext' => $messagetext, 'flash' => $flash, 'recipients' => $recipients));
        return file_get_contents("{$url}?{$query_str}");
    }

    public static function doEbulkPostRequest($url, $arr_params, $headers = array('Content-Type: application/x-www-form-urlencoded')) {
        $response = array();
        $final_url_data = $arr_params;
        if (is_array($arr_params)) {
            $final_url_data = http_build_query($arr_params, '', '&');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_url_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response['body'] = curl_exec($ch);
        $response['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response['body'];
    }
}
