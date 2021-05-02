<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Helpers\SmsHelper;
use Illuminate\Http\Request;
use App\Other;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use Nexmo\Laravel\Facade\Nexmo;

class ManageTestController extends Controller
{
    public function testSMS(Request $request) {
		if(\Illuminate\Support\Facades\Request::ajax()) {
			if(Auth::user()->can('update-sms-settings', Other::class)) {
		        $this->validate($request, [
		            'sms_test_number' => 'required',
		            'sms_test_message' => 'required'
		        ]);

		        $mobile = $request->sms_test_number;
		        $message = $request->sms_test_message;

		        if(empty(config('sms.carrier'))) {
		            return response()->json(['sent' => false, 'mobile' => $mobile, 'permission' => true]);
		        }

		        $carrier = config('sms.carrier');

		        switch ($carrier) {
		            case 'msgclub':
		                $response = $this->msgclub($mobile, $message);
		                $response = json_decode($response, true);

		                if(!isset($response) || !array_key_exists('responseCode', $response) || $response['responseCode'] == '3009') {
	                		return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
		                }
		                break;
		            case 'pointsms':
		                $response = $this->pointsms($mobile, $message);

		                if(!$response) {
	                		return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
		                }
		                break;
		            case 'nexmo':
		                $response = $this->nexmo($mobile, $message);

		                if(!$response) {
	                		return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
		                }
		                break;
		            case 'textlocal':
						$response = $this->textlocal($mobile, $message);
						$response = json_decode($response, true);

						if(!isset($response) || !array_key_exists('status', $response) || $response['status'] != 'success') {
							return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
						}
		            	break;
					case 'ebulk':
						$response['status'] = $this->ebulk($mobile, $message);
						if(!isset($response) || !array_key_exists('status', $response) || $response['status'] != 'SUCCESS') {
							return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
						}
		            	break;
					case 'twilio':
						$response = $this->twilio($mobile, $message);
						if (!empty($response)){
                            $output['status'] = $response->status;
                            $output['sid'] = $response->sid;
                            $output['accountSid'] = $response->accountSid;
                            if(!isset($output) || !in_array($output['status'],['sent','queued']) || empty($output['sid']) || empty($output['accountSid'])) {
                                return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
                            }
                        }else{
                            return response()->json(['sent' => false, 'mobile' => $mobile, 'invalid_api' => true, 'permission' => true]);
                        }
		            	break;
		            default:
		                break;
		        }

		        return response()->json(['sent' => true, 'mobile' => $mobile, 'permission' => true]);
	        } else {
	            return response()->json(['sent' => false, 'mobile' => $mobile, 'permission' => false]);
	        }
        }
    }

    public function testEmail(Request $request) {
		if(\Illuminate\Support\Facades\Request::ajax()) {
			if(Auth::user()->can('update-email-settings', Other::class)) {
		        $this->validate($request, [
		            'email_test_address' => 'required',
		            'email_test_message' => 'required'
		        ]);

		        $address = $request->email_test_address;
		        $message = $request->email_test_message;

	            // Send Email
	            try {
	                Mail::to($address)->send(new TestEmail($message));
		        	return response()->json(['sent' => true, 'address' => $address, 'permission' => true]);
	            } catch (\Exception $e) {
	            	return response()->json(['sent' => false, 'address' => $address, 'permission' => true]);
	            }

	        } else {
	            return response()->json(['sent' => false, 'address' => $address, 'permission' => false]);
	        }
    	}
    }

    private function msgclub($mobile, $message) {
        try {
            $AUTH_KEY = config('sms.msgclub.auth_key');
            $message = urlencode($message);
            $senderId = config('sms.msgclub.senderId');
            $mobileNos = $mobile;
            $routeId = config('sms.msgclub.routeId');
            $sms_content_type = config('sms.msgclub.sms_content_type');

            if(!empty($AUTH_KEY) && !empty($message) && !empty($mobileNos) && !empty($senderId) && !empty($routeId) && !empty($sms_content_type)) {

                $uri = "AUTH_KEY=$AUTH_KEY&message=$message&senderId=$senderId&routeId=$routeId&mobileNos=$mobileNos&smsContentType=$sms_content_type";
                $url = "http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?".$uri;

                $response = file_get_contents($url);

                return $response;
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }

    private function pointsms($mobile, $message) {
	    try {
            $username = config('sms.pointsms.username');
            $password = config('sms.pointsms.password');
            $senderId = config('sms.pointsms.senderId');
            $channel = config('sms.pointsms.channel');
            $route = config('sms.pointsms.route');

            if(!empty($username) && !empty($password) && !empty($senderId)) {

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
	        return false;

	    } catch (\Exception $e) {
	        return false;
	    }
    }

    private function nexmo($mobile, $message) {
        try {
            Nexmo::message()->send([
                'to'   => $mobile,
                'from' => config('sms.nexmo.from') ? config('sms.nexmo.from') : '16105552344',
                'text' => $message
            ]);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    private function textlocal($mobile, $message) {
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

    private function ebulk($mobile, $message) {
	    try {
	        $apiKey     = config('sms.ebulk.api_key');
	        $user_name  = config('sms.ebulk.user_name');
	        $json_url   = config('sms.ebulk.json_url');
	        $flash      = config('sms.ebulk.flash');

	        if(!empty($apiKey) && !empty($message) && !empty($mobile) && !empty($user_name)) {
	           $response =  SmsHelper::sendEbulkSms($json_url,$user_name,$apiKey,$flash,$user_name,$message,$mobile);
	            return $response;
	        }
	        return;

	    } catch (\Exception $e) {
	        return;
	    }
    }

    private function twilio($mobile, $message) {
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
}
