<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencySupportHelper;
use App\Http\Requests\AppDeliverySettingsUpdateRequest;
use App\Photo;
use App\Other;
use App\Setting;
use App\Helpers\Helper;
use App\Http\Requests\AppPaymentSettingsUpdateRequest;
use App\Http\Requests\AppBusinessSettingsUpdateRequest;
use App\Http\Requests\AppEmailSettingsUpdateRequest;
use App\Http\Requests\AppSMSSettingsUpdateRequest;
use http\Env;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ManageAppSettingsController extends Controller
{
    public function template() {
        if(Auth::user()->can('update-template-settings', Other::class)) {
            return view('manage.settings.template');
        } else {
            return view('errors.403');
        }
    }
    public function updateTemplate(Request $request) {
        if(Auth::user()->can('update-template-settings', Other::class)) {

            $this->validate($request, [
                'demo_template' => 'required'
            ]);
            try {
                Artisan::call("demo:template", [ 'template' => $request->demo_template ]);
                if ( $request->demo_template == 'default' ){
                    $message = __('Data Reset To Default State Successfully!');
                }else{
                    $message = __('Demo Data Imported Successfully!');
                }
                session()->flash('template_updated', $message);
            } catch (\Exception $e) {
                $this->error_message = $e->getMessage();
                session()->flash('template_not_updated', $this->error_message);
            }
            return redirect()->back();
        }else {
            return view('errors.403');
        }
    }

    public function delivery() {
    	if(Auth::user()->can('update-delivery-settings', Other::class)) {
    		return view('manage.settings.delivery');
        } else {
            return view('errors.403');
        }
    }

    public function updateDeliveryTemplate(AppDeliverySettingsUpdateRequest $request) {
        if(Auth::user()->can('update-delivery-settings', Other::class)) {
            $array = \Config::get('delivery');
            $array['enable'] = $request->enable_delivery ? 1 : 0;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/delivery.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }



    public function updateDeliveryDelhivery(AppDeliverySettingsUpdateRequest $request) {
        if(Auth::user()->can('update-delivery-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'delhivery') || $request->enable_delhivery == 0){
                $array = \Config::get('delhivery');
                $array['api_key']['sandbox']        = $request->delhivery_sandbox_api_key ? $request->delhivery_sandbox_api_key : NULL;
                $array['api_key']['sandbox_token']  = $request->delhivery_sandbox_api_key ? 'Token '.$request->delhivery_sandbox_api_key : NULL;
                $array['client_name']['sandbox']    = $request->delhivery_sandbox_client_name ? $request->delhivery_sandbox_client_name : NULL;
                $array['api_key']['live']           = $request->delhivery_live_api_key ? $request->delhivery_live_api_key : NULL;
                $array['api_key']['live_token']     = $request->delhivery_live_api_key ? 'Token '.$request->delhivery_live_api_key : NULL;
                $array['client_name']['live']       = $request->delhivery_live_client_name ? $request->delhivery_live_client_name : NULL;
                $array['warehouse_name']            = $request->warehouse_name ? $request->warehouse_name : NULL;
                $array['warehouse_city']            = $request->warehouse_city ? $request->warehouse_city : NULL;
                $array['warehouse_pin']             = $request->warehouse_pin ? $request->warehouse_pin : NULL;
                $array['warehouse_country']         = $request->warehouse_country ? $request->warehouse_country : NULL;
                $array['warehouse_phone']           = $request->warehouse_phone ? $request->warehouse_phone : NULL;
                $array['warehouse_address']         = $request->warehouse_address ? $request->warehouse_address : NULL;
                $array['return_name']               = $request->return_name ? $request->return_name : NULL;
                $array['return_city']               = $request->return_city ? $request->return_city : NULL;
                $array['return_state']              = $request->return_state ? $request->return_state : NULL;
                $array['return_pin']                = $request->return_pin ? $request->return_pin : NULL;
                $array['return_country']            = $request->return_country ? $request->return_country : NULL;
                $array['return_phone']              = $request->return_phone ? $request->return_phone : NULL;
                $array['return_address']            = $request->return_address ? $request->return_address : NULL;
                $array['mode']                      = $request->delhivery_mode ? $request->delhivery_mode : 'sandbox';
                $array['enable']                    = $request->enable_delhivery ? $request->enable_delhivery : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/delhivery.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this Delivery Service"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function payment() {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            return view('manage.settings.payment');
        } else {
            return view('errors.403');
        }
    }

    public function enablePaymentMethod($payment_method) {
        $payment_method_arr = explode('_', $payment_method);
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'), $payment_method_arr[1])) {
                return 1;
            }
        }
        return 0;
    }

    public function enableDeliveryMethod($delivery_method) {
        $delivery_method_arr = explode('_', $delivery_method);
        if(Auth::user()->can('update-delivery-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'), $delivery_method_arr[1])) {
                return 1;
            }
        }
        return 0;
    }

    public function updatePaymentCOD(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            $array = \Config::get('cod');
            $array['enable'] = $request->enable_cod ? $request->enable_cod : '0';
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/cod.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPaypal(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'paypal') || $request->enable_paypal == 0){
                $array = \Config::get('paypal');
                $array['sandbox']['username'] = $request->paypal_sandbox_api_username ? $request->paypal_sandbox_api_username : NULL;
                $array['sandbox']['password'] = $request->paypal_sandbox_api_password ? $request->paypal_sandbox_api_password : NULL;
                $array['sandbox']['secret'] = $request->paypal_sandbox_api_secret ? $request->paypal_sandbox_api_secret : NULL;
                $array['live']['username'] = $request->paypal_live_api_username ? $request->paypal_live_api_username : NULL;
                $array['live']['password'] = $request->paypal_live_api_password ? $request->paypal_live_api_password : NULL;
                $array['live']['secret'] = $request->paypal_live_api_secret ? $request->paypal_live_api_secret : NULL;
                $array['mode'] = $request->paypal_mode ? $request->paypal_mode : 'sandbox';
                $array['enable'] = $request->enable_paypal ? $request->enable_paypal : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/paypal.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPaystack(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'paystack') || $request->enable_paystack == 0){
                $array = \Config::get('paystack');
                $array['sandbox']['secret_key']     = $request->paystack_sandbox_api_secret ? $request->paystack_sandbox_api_secret : NULL;
                $array['sandbox']['public_key']     = $request->paystack_sandbox_api_public ? $request->paystack_sandbox_api_public : NULL;
                $array['live']['secret_key']        = $request->paystack_live_api_secret ? $request->paystack_live_api_secret : NULL;
                $array['live']['public_key']        = $request->paystack_live_api_public ? $request->paystack_live_api_public : NULL;
                $array['mode']                      = $request->paystack_mode ? $request->paystack_mode : 'sandbox';
                $array['enable']                    = $request->enable_paystack ? $request->enable_paystack : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/paystack.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPaytm(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'paytm') || $request->enable_paytm == 0){
                $array = \Config::get('paytm');
                $array['m_id']              = $request->paytm_merchant_id ? $request->paytm_merchant_id : NULL;
                $array['m_key']             = $request->paytm_merchant_key ? $request->paytm_merchant_key : NULL;
                $array['industry_type_id']  = $request->paytm_industry_type_id ? $request->paytm_industry_type_id : NULL;
                $array['channel_id']        = $request->paytm_channel_id ? $request->paytm_channel_id : NULL;
                $array['website']           = $request->paytm_website ? $request->paytm_website : NULL;
                $array['mode']              = $request->paytm_mode ? $request->paytm_mode : 'TEST';
                $array['enable']            = $request->enable_paytm ? $request->enable_paytm : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/paytm.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPesapal(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'pesapal') || $request->enable_pesapal == 0){
                if (!empty($request->pesapal_mode) && $request->pesapal_mode == 'LIVE' ) {
                    $live = true;
                }
                $array = \Config::get('pesapal');
                $array['consumer_key']      = $request->pesapal_consumer_key ? $request->pesapal_consumer_key : NULL;
                $array['consumer_secret']   = $request->pesapal_consumer_secret_key ? $request->pesapal_consumer_secret_key : NULL;
                $array['currency']          = config('currency.default');
                $array['live']              = !empty($live) ? $live : false;
                $array['mode']              = $request->pesapal_mode ? $request->pesapal_mode : 'SANDBOX';
                $array['enable']            = $request->enable_pesapal ? $request->enable_pesapal : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/pesapal.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentWallet(AppPaymentSettingsUpdateRequest $request) {
    	if(Auth::user()->can('update-payment-settings', Other::class)) {
            $array = \Config::get('wallet');
            $array['percent']   = $request->wallet_use_percent ? $request->wallet_use_percent : '10';
            $array['enable']    = $request->enable_wallet ? $request->enable_wallet : '0';
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/wallet.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentStripe(AppPaymentSettingsUpdateRequest $request) {
    	if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'stripe') || $request->enable_stripe == 0){
                $array = \Config::get('stripe');
                $array['stripe_key'] = $request->stripe_key ? $request->stripe_key : NULL;
                $array['stripe_secret'] = $request->stripe_secret ? $request->stripe_secret : NULL;
                $array['enable'] = $request->enable_stripe ? $request->enable_stripe : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/stripe.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }

        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentRazorpay(AppPaymentSettingsUpdateRequest $request) {
    	if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'razorpay') || $request->enable_razorpay == 0){
                $array = \Config::get('razorpay');
                $array['razor_key'] = $request->razor_key ? $request->razor_key : NULL;
                $array['razor_secret'] = $request->razor_secret ? $request->razor_secret : NULL;
                $array['enable'] = $request->enable_razorpay ? $request->enable_razorpay : '0';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/razorpay.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }

        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentInstamojo(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'instamojo') || $request->enable_instamojo == 0){
                $array = \Config::get('instamogo');
                $array['instamojo_api_key'] = $request->instamojo_api_key ? $request->instamojo_api_key : NULL;
                $array['instamojo_auth_token'] = $request->instamojo_auth_token ? $request->instamojo_auth_token : NULL;
                $array['enable'] = $request->enable_instamojo ? $request->enable_instamojo : '0';
                $array['mode'] = $request->instamojo_mode ? $request->instamojo_mode : 'test';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/instamojo.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }

        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPayUmoney(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'payumoney') || $request->enable_payumoney == 0){
                $array = \Config::get('payu');
                $array['accounts']['payumoney']['key'] = $request->payumoney_merchant_key ? $request->payumoney_merchant_key : NULL;
                $array['accounts']['payumoney']['salt'] = $request->payumoney_merchant_salt ? $request->payumoney_merchant_salt : NULL;
                $array['accounts']['payumoney']['auth'] = $request->payumoney_auth_token ? $request->payumoney_auth_token : NULL;
                $array['env'] = $request->payumoney_mode ? $request->payumoney_mode : 'test';
                $array['enable'] = $request->enable_payumoney ? $request->enable_payumoney : '0';
                $array['default'] = 'payumoney';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/payu.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentPayUbiz(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            if(CurrencySupportHelper::checkCurrencySupport(config('currency.default'),'payubiz') || $request->enable_payubiz == 0){
                $array = \Config::get('payu');
                $array['accounts']['payubiz']['key'] = $request->payubiz_merchant_key ? $request->payubiz_merchant_key : NULL;
                $array['accounts']['payubiz']['salt'] = $request->payubiz_merchant_salt ? $request->payubiz_merchant_salt : NULL;
                $array['env'] = $request->payubiz_mode ? $request->payubiz_mode : 'test';
                $array['enable'] = $request->enable_payubiz ? $request->enable_payubiz : '0';
                $array['default'] = 'payubiz';
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/payu.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }

                session()->flash('settings_saved', __("The settings has been saved."));
                return redirect()->back();
            }else{
                session()->flash('settings_not_saved', __("Error saving the settings. The Default Currency Does not support this payment method"));
                return redirect()->back();
            }

        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentBankTransfer(AppPaymentSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            $array = \Config::get('banktransfer');
            $array['account_number'] = $request->bank_transfer_account_number ? $request->bank_transfer_account_number : NULL;
            $array['branch_code'] = $request->bank_transfer_branch_code ? $request->bank_transfer_branch_code : NULL;
            $array['branch_code_label'] = $request->bank_transfer_branch_code_label ? $request->bank_transfer_branch_code_label : 'Branch Code';
            $array['name'] = $request->bank_transfer_name ? $request->bank_transfer_name : NULL;
            $array['enable'] = $request->enable_bank_transfer ? $request->enable_bank_transfer : '0';
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/banktransfer.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

	public function business() {
		if(Auth::user()->can('update-business-settings', Other::class)) {
			$timezones = $this->getTimezones();
			$currencies = $this->getCurrencies();
            $languages = Helper::supportedLanguages();
    		return view('manage.settings.business', compact('timezones', 'currencies', 'languages'));
        } else {
            return view('errors.403');
        }
    }

    public function updateBusiness(AppBusinessSettingsUpdateRequest $request, Factory $cache) {
		if(Auth::user()->can('update-business-settings', Other::class)) {
            if($request->admin_country_code) {
                $array = \Config::get('googlemap');
                $array['admin_country_code'] = $request->admin_country_code;
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/googlemap.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
            }
		    if($request->currency) {
				$array = \Config::get('currency');
		        $array['default'] = $request->currency;
		        $data = var_export($array, 1);
		        if(\File::put(base_path() . '/config/currency.php', "<?php\n return $data ;")) {
		        } else {
    	            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
        			return redirect()->back();
		        }
	    	}

	    	if($request->timezone || $request->name) {
				$array = \Config::get('app');
                $array['name'] = $request->name;
                $array['url'] = $request->url;
		        $array['locale'] = $request->language ? $request->language : 'en';
		        $array['timezone'] = $request->timezone;
		        $data = var_export($array, 1);
		        if(\File::put(base_path() . '/config/app.php', "<?php\n return $data ;")) {
		        } else {
    	            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
        			return redirect()->back();
		        }
	    	}

            if($request->google_analytics_script) {
                $array = \Config::get('analytics');
                $array['google_analytics_script'] = $request->google_analytics_script;
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/analytics.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
            }

            $array = \Config::get('custom');
            $array['meta_title'] = $request->title;
            $array['meta_description'] = $request->description;
            $array['meta_keywords'] = $request->keywords;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/custom.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            $setting = Setting::where('key', 'currencyconverterapi_key')->first();
            if($setting) {
                $setting->value = $request->currencyconverterapi_key;
                $setting->save();
            }

            $setting = Setting::where('key', 'terms_of_service_url')->first();
            if($setting) {
                $setting->value = $request->terms_of_service_url;
                $setting->save();
            }

            $setting = Setting::where('key', 'privacy_policy_url')->first();
            if($setting) {
                $setting->value = $request->privacy_policy_url;
                $setting->save();
            }

            $setting = Setting::where('key', 'copyright_text')->first();
            if($setting) {
                $setting->value = $request->copyright_text;
                $setting->save();
            }

            $setting = Setting::where('key', 'allow_multi_language')->first();
            if($setting) {
                $setting->value = $request->allow_multi_language;
                $setting->save();
            }

            $cache->forget('settings');

	        session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function email() {
    	if(Auth::user()->can('update-email-settings', Other::class)) {
    		return view('manage.settings.email');
        } else {
            return view('errors.403');
        }
    }

    public function updateEmailTemplate(AppEmailSettingsUpdateRequest $request) {
    	if(Auth::user()->can('update-email-settings', Other::class)) {

            $this->validate($request, [
                'mail_logo' => 'image'
            ]);

			$array = \Config::get('mail');
	        $array['from']['address'] = $request->mail_from_address;
			$array['from']['name'] = $request->mail_from_name;
			$array['markdown']['paths'][0] = resource_path('views/vendor/mail');
	        $data = var_export($array, 1);
	        if(\File::put(base_path() . '/config/mail.php', "<?php\n return $data ;")) {
	        } else {
	            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
    			return redirect()->back();
	        }

	        if($photo = $request->file('mail_logo')) {
	            $name = $photo->getClientOriginalName();
	            if(file_exists(public_path().'/img/'.'mail-logo.png')) {
	                unlink(public_path().'/img/'.'mail-logo.png');
	            }
	            $photo->move(Photo::getPhotoDirectoryName(), 'mail-logo.png');
	        }

			$array = \Config::get('custom');
            $array['mail_message_title_order_placed'] = $request->mail_message_title_order_placed ? $request->mail_message_title_order_placed : "";
            $array['mail_message_order_placed'] = $request->mail_message_order_placed ? $request->mail_message_order_placed : "";
            $array['mail_message_title_payment_failed'] = $request->mail_message_title_payment_failed ? $request->mail_message_title_payment_failed : "";
            $array['mail_message_payment_failed'] = $request->mail_message_payment_failed ? $request->mail_message_payment_failed : "";
            $array['mail_message_title_order_processed'] = $request->mail_message_title_order_processed ? $request->mail_message_title_order_processed : "";
            $array['mail_message_order_processed'] = $request->mail_message_order_processed ? $request->mail_message_order_processed : "";
	        $data = var_export($array, 1);
	        if(\File::put(base_path() . '/config/custom.php', "<?php\n return $data ;")) {
	        } else {
	            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
    			return redirect()->back();
	        }

	        session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateEmailSmtp(AppEmailSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-email-settings', Other::class)) {
            $array = \Config::get('mail');
            $array['username'] = $request->mail_username ? $request->mail_username : NULL;
            if($request->mail_password) {
                $array['password'] = $request->mail_password;
            }
            $array['host'] = $request->mail_host;
            $array['encryption'] = $request->mail_encryption ? $request->mail_encryption : NULL;
            $array['driver'] = $request->mail_driver;
            $array['port'] = $request->mail_port;
            $array['markdown']['paths'][0] = resource_path('views/vendor/mail');
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/mail.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateEmailMailgun(AppEmailSettingsUpdateRequest $request) {
    	if(Auth::user()->can('update-email-settings', Other::class)) {
            $array = \Config::get('mail');
            $array['host'] = $request->mail_host;
			$array['driver'] = $request->mail_driver;
			$array['markdown']['paths'][0] = resource_path('views/vendor/mail');
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/mail.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

			$array = \Config::get('services');
	        $array['mailgun']['domain'] = $request->mailgun_domain;
	        $array['mailgun']['secret'] = $request->mailgun_secret;
	        $data = var_export($array, 1);
	        if(\File::put(base_path() . '/config/services.php', "<?php\n return $data ;")) {
	        } else {
	            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
    			return redirect()->back();
	        }

	        session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function sms() {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            return view('manage.settings.sms');
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSTemplate(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['enable'] = $request->enable_sms ? 1 : 0;
            $array['messages']['order_placed'] = $request->sms_message_order_placed ? $request->sms_message_order_placed : "";
            $array['messages']['order_processed'] = $request->sms_message_order_processed ? $request->sms_message_order_processed : "";
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSOtp(AppSMSSettingsUpdateRequest $request, Factory $cache) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $setting = Setting::where('key', 'phone_otp_verification')->first();
            if($setting) {
                $setting->value = (bool) $request->phone_otp_verification;
                $setting->save();
            }
    
            $cache->forget('settings');

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSMsgClub(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['msgclub']['auth_key'] = $request->msgclub_auth_key;
            $array['msgclub']['senderId'] = $request->msgclub_senderId;
            $array['msgclub']['routeId'] = $request->msgclub_routeId;
            $array['msgclub']['sms_content_type'] = $request->msgclub_sms_content_type;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSPointSMS(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['pointsms']['username'] = $request->pointsms_username;
            if($request->pointsms_password) {
                $array['pointsms']['password'] = $request->pointsms_password;
            }
            $array['pointsms']['senderId'] = $request->pointsms_senderId;
            $array['pointsms']['channel'] = $request->pointsms_channel;
            $array['pointsms']['route'] = $request->pointsms_route;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSNexmo(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['nexmo']['from'] = $request->nexmo_from;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            $array = \Config::get('nexmo');
            $array['api_key'] = $request->nexmo_api_key;
            $array['api_secret'] = $request->nexmo_api_secret;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/nexmo.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSTextlocal(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['textlocal']['api_key'] = $request->textlocal_api_key;
            $array['textlocal']['sender'] = $request->textlocal_sender;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSTwilio(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['twilio']['senderId'] = $request->twilio_sender_id;
            $array['twilio']['auth_token'] = $request->twilio_auth_token;
            $array['twilio']['from'] = $request->twilio_from;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSMSeBulk(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-sms-settings', Other::class)) {
            $array = \Config::get('sms');
            $array['carrier'] = $request->sms_carrier;
            $array['ebulk']['user_name'] = $request->ebulk_user_name;
            $array['ebulk']['api_key'] = $request->ebulk_api_key;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/sms.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentCashback(AppSMSSettingsUpdateRequest $request) {
        if(Auth::user()->can('update-payment-settings', Other::class)) {
            $array = \Config::get('cashback');
            $array['type']          = $request->cashback_type ? $request->cashback_type : 'FLAT';
            $array['max_order_amt'] = $request->order_max_amt ? $request->order_max_amt : '0';
            $array['max_usage']     = $request->max_user_usage ? $request->max_user_usage : '0';
            $array['amount']        = $request->cashback_amt ? $request->cashback_amt : '0';
            $array['enable']        = $request->enable_cashback ? $request->enable_cashback : '0';
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/cashback.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

	public function cssEditor() {
		if(Auth::user()->can('update-css-settings', Other::class)) {
			return view('manage.settings.css-editor');
		} else {
			return view('errors.403');
		}
	}

	public function updateStoreCSS(Request $request) {
		if(Auth::user()->can('update-css-settings', Other::class)) {
			$array = \Config::get('customcss');
			$array['css_front'] = $request->store_css;
            $array['css_front_version'] = microtime();
			$data = var_export($array, 1);
			if(\File::put(base_path() . '/config/customcss.php', "<?php\n return $data ;")) {
			} else {
				session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
				return redirect()->back();
			}

            $css = $request->store_css ? $request->store_css : " ";
            if(\File::put(public_path() . '/css/custom/front.css', $css)) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
			session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
		} else {
			return view('errors.403');
		}
	}

	public function updateAdminCSS(Request $request) {
		if(Auth::user()->can('update-css-settings', Other::class)) {
			$array = \Config::get('customcss');
            $array['manage_panel_text_color']   = $request->manage_panel_text_color;
            $array['manage_panel_title_color']  = $request->manage_panel_title_color;
            $array['manage_panel_side_color']   = $request->manage_panel_side_color;
            $array['manage_panel_main_color']   = $request->manage_panel_main_color;
            $array['manage_panel_hover_color']  = $request->manage_panel_hover_color;
            $array['css_manage']                = $request->admin_css;
            $array['css_manage_version']        = microtime();
			$data = var_export($array, 1);
			if(\File::put(base_path() . '/config/customcss.php', "<?php\n return $data ;")) {
			} else {
				session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
				return redirect()->back();
			}

            $css = $request->admin_css ? $request->admin_css : " ";
            if(\File::put(public_path() . '/css/custom/manage.css', $css)) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
			session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
		} else {
			return view('errors.403');
		}
	}


	public function updatePanelCSS(Request $request) {
		if(Auth::user()->can('update-css-settings', Other::class)) {
			$array = \Config::get('customcss');
//			$array['css_manage'] = $request->panel_css;
            $array['css_front_primary']         = $request->panel_css;
            $array['css_front_secondary']       = $request->panel_css_secondary;
            $array['panel_btn_color']           = $request->panel_btn_color;
            $array['panel_btn_hover_color']     = $request->panel_btn_hover_color;
            $array['head_foot_text_color']      = $request->head_foot_text_color;
            $array['head_foot_icon_color']      = $request->head_foot_icon_color;
            $array['link_hover_color']          = $request->link_hover_color;
            $array['header_text_color']         = $request->header_text_color;
            $array['css_front']                 = $request->store_css;
            $array["front_header_full_width"]   = $request->front_header_full_width ? $request->front_header_full_width == "on" : false;
            $array["front_footer_full_width"]   = $request->front_footer_full_width ? $request->front_footer_full_width == "on" : false;
            $array['css_manage_version']        = microtime();
			$data                               = var_export($array, 1);
			if(\File::put(base_path() . '/config/customcss.php', "<?php\n return $data ;")) {
			} else {
				session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
				return redirect()->back();
			}

            $css = $request->store_css ? $request->store_css : " ";
            if(\File::put(public_path() . '/css/custom/front.css', $css)) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

			$panel_css_array = array(
			    'panel_primary_css'     => $request->panel_css,
			    'panel_secondary_css'   => $request->panel_css_secondary,
            );
            $setting = Setting::where('key', 'custom_panel_css')->first();
            if($setting) {
                $setting->value = serialize($panel_css_array);
                $setting->save();
            }else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }
			session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
		} else {
            session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
            return redirect()->back();
		}
	}

	public function subscribers() {
		if(Auth::user()->can('update-subscribers-settings', Other::class)) {
    		return view('manage.subscribers.settings');
        } else {
            return view('errors.403');
        }
    }

    public function updateSubscribers(Request $request) {
		if(Auth::user()->can('update-subscribers-settings', Other::class)) {
			if($request->mail_driver) {
                $array = \Config::get('subscribers');
                $array['email_carrier'] = $request->mail_driver;
                $array['email_carrier'] = $request->mail_driver;
                $array['from']['address'] = $request->mail_from_address;
                $array['from']['name'] = $request->mail_from_name;
                $array['mail_message_subscribed'] = $request->mail_message_subscribed;
                $data = var_export($array, 1);
                if(\File::put(base_path() . '/config/subscribers.php', "<?php\n return $data ;")) {
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
			}

	        session()->flash('settings_saved', __("The settings has been saved."));
			return redirect()->back();
        } else {
            return view('errors.403');
        }
	}

    public function updateMailChimp(Request $request) {
        if(Auth::user()->can('update-subscribers-settings', Other::class)) {
            $array = \Config::get('mailchimp');
            $array['enable'] = $request->mailchimp_enable ? $request->mailchimp_enable : NULL;
            $array['apikey'] = $request->mailchimp_api ? $request->mailchimp_api : 'MAILCHIMP_API_KEY';
            $array['list_id'] = $request->mailchimp_list_id ? $request->mailchimp_list_id : '';
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/mailchimp.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateSubsDetails(Request $request, Factory $cache) {
        if(Auth::user()->can('update-subscribers-settings', Other::class)) {
            $panel_subscribers_arr = array(
                'subscribers_title'             => $request->subscribers_title,
                'subscribers_description'       => $request->subscribers_description,
                'subscribers_btn_text'          => $request->subscribers_btn_text,
                'subscribers_placeholder_text'  => $request->subscribers_placeholder_text,
                'enable_subscribers'            => $request->subscribers_enable,
            );

            foreach($panel_subscribers_arr as $key => $subs_data){
                $setting = Setting::where('key', $key)->first();
                if($setting) {
                    $setting->value = $subs_data;
                    $setting->save();
                } else {
                    session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    return redirect()->back();
                }
            }

            $cache->forget('settings');

            $message = array(
                'subs_bg_img.image' => 'Subscriber Background Image Must Be Image File!'
            );
            $this->validate($request, [
                'subs_bg_img' => 'image'
            ],$message);

            if($photo = $request->file('subs_bg_img')) {
                $name = $photo->getClientOriginalName();
                if(file_exists(public_path().'/themes/theme1/img/'.'subscribers-img.jpg')) {
                    unlink(public_path().'/themes/theme1/img/'.'subscribers-img.jpg');
                }
                $photo->move(public_path().'/themes/theme1/img/', 'subscribers-img.jpg');
            }
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    private function getCurrencies() {
    	$currencies = array(
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'XAF' => 'Franc CFA (XAF)',
            'XOF' => 'Franc CFA (XOF)',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KES' => 'Kenyan Shilling',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'UGX' => 'Uganda Shilling',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
    	);

    	return $currencies;
    }

    private function getTimezones(){
		$timezones = array(
		    'Pacific/Midway' => '(UTC-11:00) Midway',
		    'Pacific/Niue' => '(UTC-11:00) Niue',
		    'Pacific/Pago_Pago' => '(UTC-11:00) Pago Pago',
		    'America/Adak' => '(UTC-10:00) Adak',
		    'Pacific/Honolulu' => '(UTC-10:00) Honolulu',
		    'Pacific/Johnston' => '(UTC-10:00) Johnston',
		    'Pacific/Rarotonga' => '(UTC-10:00) Rarotonga',
		    'Pacific/Tahiti' => '(UTC-10:00) Tahiti',
		    'Pacific/Marquesas' => '(UTC-09:30) Marquesas',
		    'America/Anchorage' => '(UTC-09:00) Anchorage',
		    'Pacific/Gambier' => '(UTC-09:00) Gambier',
		    'America/Juneau' => '(UTC-09:00) Juneau',
		    'America/Nome' => '(UTC-09:00) Nome',
		    'America/Sitka' => '(UTC-09:00) Sitka',
		    'America/Yakutat' => '(UTC-09:00) Yakutat',
		    'America/Dawson' => '(UTC-08:00) Dawson',
		    'America/Los_Angeles' => '(UTC-08:00) Los Angeles',
		    'America/Metlakatla' => '(UTC-08:00) Metlakatla',
		    'Pacific/Pitcairn' => '(UTC-08:00) Pitcairn',
		    'America/Santa_Isabel' => '(UTC-08:00) Santa Isabel',
		    'America/Tijuana' => '(UTC-08:00) Tijuana',
		    'America/Vancouver' => '(UTC-08:00) Vancouver',
		    'America/Whitehorse' => '(UTC-08:00) Whitehorse',
		    'America/Boise' => '(UTC-07:00) Boise',
		    'America/Cambridge_Bay' => '(UTC-07:00) Cambridge Bay',
		    'America/Chihuahua' => '(UTC-07:00) Chihuahua',
		    'America/Creston' => '(UTC-07:00) Creston',
		    'America/Dawson_Creek' => '(UTC-07:00) Dawson Creek',
		    'America/Denver' => '(UTC-07:00) Denver',
		    'America/Edmonton' => '(UTC-07:00) Edmonton',
		    'America/Hermosillo' => '(UTC-07:00) Hermosillo',
		    'America/Inuvik' => '(UTC-07:00) Inuvik',
		    'America/Mazatlan' => '(UTC-07:00) Mazatlan',
		    'America/Ojinaga' => '(UTC-07:00) Ojinaga',
		    'America/Phoenix' => '(UTC-07:00) Phoenix',
		    'America/Shiprock' => '(UTC-07:00) Shiprock',
		    'America/Yellowknife' => '(UTC-07:00) Yellowknife',
		    'America/Bahia_Banderas' => '(UTC-06:00) Bahia Banderas',
		    'America/Belize' => '(UTC-06:00) Belize',
		    'America/North_Dakota/Beulah' => '(UTC-06:00) Beulah',
		    'America/Cancun' => '(UTC-06:00) Cancun',
		    'America/North_Dakota/Center' => '(UTC-06:00) Center',
		    'America/Chicago' => '(UTC-06:00) Chicago',
		    'America/Costa_Rica' => '(UTC-06:00) Costa Rica',
		    'Pacific/Easter' => '(UTC-06:00) Easter',
		    'America/El_Salvador' => '(UTC-06:00) El Salvador',
		    'Pacific/Galapagos' => '(UTC-06:00) Galapagos',
		    'America/Guatemala' => '(UTC-06:00) Guatemala',
		    'America/Indiana/Knox' => '(UTC-06:00) Knox',
		    'America/Managua' => '(UTC-06:00) Managua',
		    'America/Matamoros' => '(UTC-06:00) Matamoros',
		    'America/Menominee' => '(UTC-06:00) Menominee',
		    'America/Merida' => '(UTC-06:00) Merida',
		    'America/Mexico_City' => '(UTC-06:00) Mexico City',
		    'America/Monterrey' => '(UTC-06:00) Monterrey',
		    'America/North_Dakota/New_Salem' => '(UTC-06:00) New Salem',
		    'America/Rainy_River' => '(UTC-06:00) Rainy River',
		    'America/Rankin_Inlet' => '(UTC-06:00) Rankin Inlet',
		    'America/Regina' => '(UTC-06:00) Regina',
		    'America/Resolute' => '(UTC-06:00) Resolute',
		    'America/Swift_Current' => '(UTC-06:00) Swift Current',
		    'America/Tegucigalpa' => '(UTC-06:00) Tegucigalpa',
		    'America/Indiana/Tell_City' => '(UTC-06:00) Tell City',
		    'America/Winnipeg' => '(UTC-06:00) Winnipeg',
		    'America/Atikokan' => '(UTC-05:00) Atikokan',
		    'America/Bogota' => '(UTC-05:00) Bogota',
		    'America/Cayman' => '(UTC-05:00) Cayman',
		    'America/Detroit' => '(UTC-05:00) Detroit',
		    'America/Grand_Turk' => '(UTC-05:00) Grand Turk',
		    'America/Guayaquil' => '(UTC-05:00) Guayaquil',
		    'America/Havana' => '(UTC-05:00) Havana',
		    'America/Indiana/Indianapolis' => '(UTC-05:00) Indianapolis',
		    'America/Iqaluit' => '(UTC-05:00) Iqaluit',
		    'America/Jamaica' => '(UTC-05:00) Jamaica',
		    'America/Lima' => '(UTC-05:00) Lima',
		    'America/Kentucky/Louisville' => '(UTC-05:00) Louisville',
		    'America/Indiana/Marengo' => '(UTC-05:00) Marengo',
		    'America/Kentucky/Monticello' => '(UTC-05:00) Monticello',
		    'America/Montreal' => '(UTC-05:00) Montreal',
		    'America/Nassau' => '(UTC-05:00) Nassau',
		    'America/New_York' => '(UTC-05:00) New York',
		    'America/Nipigon' => '(UTC-05:00) Nipigon',
		    'America/Panama' => '(UTC-05:00) Panama',
		    'America/Pangnirtung' => '(UTC-05:00) Pangnirtung',
		    'America/Indiana/Petersburg' => '(UTC-05:00) Petersburg',
		    'America/Port-au-Prince' => '(UTC-05:00) Port-au-Prince',
		    'America/Thunder_Bay' => '(UTC-05:00) Thunder Bay',
		    'America/Toronto' => '(UTC-05:00) Toronto',
		    'America/Indiana/Vevay' => '(UTC-05:00) Vevay',
		    'America/Indiana/Vincennes' => '(UTC-05:00) Vincennes',
		    'America/Indiana/Winamac' => '(UTC-05:00) Winamac',
		    'America/Caracas' => '(UTC-04:30) Caracas',
		    'America/Anguilla' => '(UTC-04:00) Anguilla',
		    'America/Antigua' => '(UTC-04:00) Antigua',
		    'America/Aruba' => '(UTC-04:00) Aruba',
		    'America/Asuncion' => '(UTC-04:00) Asuncion',
		    'America/Barbados' => '(UTC-04:00) Barbados',
		    'Atlantic/Bermuda' => '(UTC-04:00) Bermuda',
		    'America/Blanc-Sablon' => '(UTC-04:00) Blanc-Sablon',
		    'America/Boa_Vista' => '(UTC-04:00) Boa Vista',
		    'America/Campo_Grande' => '(UTC-04:00) Campo Grande',
		    'America/Cuiaba' => '(UTC-04:00) Cuiaba',
		    'America/Curacao' => '(UTC-04:00) Curacao',
		    'America/Dominica' => '(UTC-04:00) Dominica',
		    'America/Eirunepe' => '(UTC-04:00) Eirunepe',
		    'America/Glace_Bay' => '(UTC-04:00) Glace Bay',
		    'America/Goose_Bay' => '(UTC-04:00) Goose Bay',
		    'America/Grenada' => '(UTC-04:00) Grenada',
		    'America/Guadeloupe' => '(UTC-04:00) Guadeloupe',
		    'America/Guyana' => '(UTC-04:00) Guyana',
		    'America/Halifax' => '(UTC-04:00) Halifax',
		    'America/Kralendijk' => '(UTC-04:00) Kralendijk',
		    'America/La_Paz' => '(UTC-04:00) La Paz',
		    'America/Lower_Princes' => '(UTC-04:00) Lower Princes',
		    'America/Manaus' => '(UTC-04:00) Manaus',
		    'America/Marigot' => '(UTC-04:00) Marigot',
		    'America/Martinique' => '(UTC-04:00) Martinique',
		    'America/Moncton' => '(UTC-04:00) Moncton',
		    'America/Montserrat' => '(UTC-04:00) Montserrat',
		    'Antarctica/Palmer' => '(UTC-04:00) Palmer',
		    'America/Port_of_Spain' => '(UTC-04:00) Port of Spain',
		    'America/Porto_Velho' => '(UTC-04:00) Porto Velho',
		    'America/Puerto_Rico' => '(UTC-04:00) Puerto Rico',
		    'America/Rio_Branco' => '(UTC-04:00) Rio Branco',
		    'America/Santiago' => '(UTC-04:00) Santiago',
		    'America/Santo_Domingo' => '(UTC-04:00) Santo Domingo',
		    'America/St_Barthelemy' => '(UTC-04:00) St. Barthelemy',
		    'America/St_Kitts' => '(UTC-04:00) St. Kitts',
		    'America/St_Lucia' => '(UTC-04:00) St. Lucia',
		    'America/St_Thomas' => '(UTC-04:00) St. Thomas',
		    'America/St_Vincent' => '(UTC-04:00) St. Vincent',
		    'America/Thule' => '(UTC-04:00) Thule',
		    'America/Tortola' => '(UTC-04:00) Tortola',
		    'America/St_Johns' => '(UTC-03:30) St. Johns',
		    'America/Araguaina' => '(UTC-03:00) Araguaina',
		    'America/Bahia' => '(UTC-03:00) Bahia',
		    'America/Belem' => '(UTC-03:00) Belem',
		    'America/Argentina/Buenos_Aires' => '(UTC-03:00) Buenos Aires',
		    'America/Argentina/Catamarca' => '(UTC-03:00) Catamarca',
		    'America/Cayenne' => '(UTC-03:00) Cayenne',
		    'America/Argentina/Cordoba' => '(UTC-03:00) Cordoba',
		    'America/Fortaleza' => '(UTC-03:00) Fortaleza',
		    'America/Godthab' => '(UTC-03:00) Godthab',
		    'America/Argentina/Jujuy' => '(UTC-03:00) Jujuy',
		    'America/Argentina/La_Rioja' => '(UTC-03:00) La Rioja',
		    'America/Maceio' => '(UTC-03:00) Maceio',
		    'America/Argentina/Mendoza' => '(UTC-03:00) Mendoza',
		    'America/Miquelon' => '(UTC-03:00) Miquelon',
		    'America/Montevideo' => '(UTC-03:00) Montevideo',
		    'America/Paramaribo' => '(UTC-03:00) Paramaribo',
		    'America/Recife' => '(UTC-03:00) Recife',
		    'America/Argentina/Rio_Gallegos' => '(UTC-03:00) Rio Gallegos',
		    'Antarctica/Rothera' => '(UTC-03:00) Rothera',
		    'America/Argentina/Salta' => '(UTC-03:00) Salta',
		    'America/Argentina/San_Juan' => '(UTC-03:00) San Juan',
		    'America/Argentina/San_Luis' => '(UTC-03:00) San Luis',
		    'America/Santarem' => '(UTC-03:00) Santarem',
		    'America/Sao_Paulo' => '(UTC-03:00) Sao Paulo',
		    'Atlantic/Stanley' => '(UTC-03:00) Stanley',
		    'America/Argentina/Tucuman' => '(UTC-03:00) Tucuman',
		    'America/Argentina/Ushuaia' => '(UTC-03:00) Ushuaia',
		    'America/Noronha' => '(UTC-02:00) Noronha',
		    'Atlantic/South_Georgia' => '(UTC-02:00) South Georgia',
		    'Atlantic/Azores' => '(UTC-01:00) Azores',
		    'Atlantic/Cape_Verde' => '(UTC-01:00) Cape Verde',
		    'America/Scoresbysund' => '(UTC-01:00) Scoresbysund',
		    'Africa/Abidjan' => '(UTC+00:00) Abidjan',
		    'Africa/Accra' => '(UTC+00:00) Accra',
		    'Africa/Bamako' => '(UTC+00:00) Bamako',
		    'Africa/Banjul' => '(UTC+00:00) Banjul',
		    'Africa/Bissau' => '(UTC+00:00) Bissau',
		    'Atlantic/Canary' => '(UTC+00:00) Canary',
		    'Africa/Casablanca' => '(UTC+00:00) Casablanca',
		    'Africa/Conakry' => '(UTC+00:00) Conakry',
		    'Africa/Dakar' => '(UTC+00:00) Dakar',
		    'America/Danmarkshavn' => '(UTC+00:00) Danmarkshavn',
		    'Europe/Dublin' => '(UTC+00:00) Dublin',
		    'Africa/El_Aaiun' => '(UTC+00:00) El Aaiun',
		    'Atlantic/Faroe' => '(UTC+00:00) Faroe',
		    'Africa/Freetown' => '(UTC+00:00) Freetown',
		    'Europe/Guernsey' => '(UTC+00:00) Guernsey',
		    'Europe/Isle_of_Man' => '(UTC+00:00) Isle of Man',
		    'Europe/Jersey' => '(UTC+00:00) Jersey',
		    'Europe/Lisbon' => '(UTC+00:00) Lisbon',
		    'Africa/Lome' => '(UTC+00:00) Lome',
		    'Europe/London' => '(UTC+00:00) London',
		    'Atlantic/Madeira' => '(UTC+00:00) Madeira',
		    'Africa/Monrovia' => '(UTC+00:00) Monrovia',
		    'Africa/Nouakchott' => '(UTC+00:00) Nouakchott',
		    'Africa/Ouagadougou' => '(UTC+00:00) Ouagadougou',
		    'Atlantic/Reykjavik' => '(UTC+00:00) Reykjavik',
		    'Africa/Sao_Tome' => '(UTC+00:00) Sao Tome',
		    'Atlantic/St_Helena' => '(UTC+00:00) St. Helena',
		    'UTC' => '(UTC+00:00) UTC',
		    'Africa/Algiers' => '(UTC+01:00) Algiers',
		    'Europe/Amsterdam' => '(UTC+01:00) Amsterdam',
		    'Europe/Andorra' => '(UTC+01:00) Andorra',
		    'Africa/Bangui' => '(UTC+01:00) Bangui',
		    'Europe/Belgrade' => '(UTC+01:00) Belgrade',
		    'Europe/Berlin' => '(UTC+01:00) Berlin',
		    'Europe/Bratislava' => '(UTC+01:00) Bratislava',
		    'Africa/Brazzaville' => '(UTC+01:00) Brazzaville',
		    'Europe/Brussels' => '(UTC+01:00) Brussels',
		    'Europe/Budapest' => '(UTC+01:00) Budapest',
		    'Europe/Busingen' => '(UTC+01:00) Busingen',
		    'Africa/Ceuta' => '(UTC+01:00) Ceuta',
		    'Europe/Copenhagen' => '(UTC+01:00) Copenhagen',
		    'Africa/Douala' => '(UTC+01:00) Douala',
		    'Europe/Gibraltar' => '(UTC+01:00) Gibraltar',
		    'Africa/Kinshasa' => '(UTC+01:00) Kinshasa',
		    'Africa/Lagos' => '(UTC+01:00) Lagos',
		    'Africa/Libreville' => '(UTC+01:00) Libreville',
		    'Europe/Ljubljana' => '(UTC+01:00) Ljubljana',
		    'Arctic/Longyearbyen' => '(UTC+01:00) Longyearbyen',
		    'Africa/Luanda' => '(UTC+01:00) Luanda',
		    'Europe/Luxembourg' => '(UTC+01:00) Luxembourg',
		    'Europe/Madrid' => '(UTC+01:00) Madrid',
		    'Africa/Malabo' => '(UTC+01:00) Malabo',
		    'Europe/Malta' => '(UTC+01:00) Malta',
		    'Europe/Monaco' => '(UTC+01:00) Monaco',
		    'Africa/Ndjamena' => '(UTC+01:00) Ndjamena',
		    'Africa/Niamey' => '(UTC+01:00) Niamey',
		    'Europe/Oslo' => '(UTC+01:00) Oslo',
		    'Europe/Paris' => '(UTC+01:00) Paris',
		    'Europe/Podgorica' => '(UTC+01:00) Podgorica',
		    'Africa/Porto-Novo' => '(UTC+01:00) Porto-Novo',
		    'Europe/Prague' => '(UTC+01:00) Prague',
		    'Europe/Rome' => '(UTC+01:00) Rome',
		    'Europe/San_Marino' => '(UTC+01:00) San Marino',
		    'Europe/Sarajevo' => '(UTC+01:00) Sarajevo',
		    'Europe/Skopje' => '(UTC+01:00) Skopje',
		    'Europe/Stockholm' => '(UTC+01:00) Stockholm',
		    'Europe/Tirane' => '(UTC+01:00) Tirane',
		    'Africa/Tripoli' => '(UTC+01:00) Tripoli',
		    'Africa/Tunis' => '(UTC+01:00) Tunis',
		    'Europe/Vaduz' => '(UTC+01:00) Vaduz',
		    'Europe/Vatican' => '(UTC+01:00) Vatican',
		    'Europe/Vienna' => '(UTC+01:00) Vienna',
		    'Europe/Warsaw' => '(UTC+01:00) Warsaw',
		    'Africa/Windhoek' => '(UTC+01:00) Windhoek',
		    'Europe/Zagreb' => '(UTC+01:00) Zagreb',
		    'Europe/Zurich' => '(UTC+01:00) Zurich',
		    'Europe/Athens' => '(UTC+02:00) Athens',
		    'Asia/Beirut' => '(UTC+02:00) Beirut',
		    'Africa/Blantyre' => '(UTC+02:00) Blantyre',
		    'Europe/Bucharest' => '(UTC+02:00) Bucharest',
		    'Africa/Bujumbura' => '(UTC+02:00) Bujumbura',
		    'Africa/Cairo' => '(UTC+02:00) Cairo',
		    'Europe/Chisinau' => '(UTC+02:00) Chisinau',
		    'Asia/Damascus' => '(UTC+02:00) Damascus',
		    'Africa/Gaborone' => '(UTC+02:00) Gaborone',
		    'Asia/Gaza' => '(UTC+02:00) Gaza',
		    'Africa/Harare' => '(UTC+02:00) Harare',
		    'Asia/Hebron' => '(UTC+02:00) Hebron',
		    'Europe/Helsinki' => '(UTC+02:00) Helsinki',
		    'Europe/Istanbul' => '(UTC+02:00) Istanbul',
		    'Asia/Jerusalem' => '(UTC+02:00) Jerusalem',
		    'Africa/Johannesburg' => '(UTC+02:00) Johannesburg',
		    'Europe/Kiev' => '(UTC+02:00) Kiev',
		    'Africa/Kigali' => '(UTC+02:00) Kigali',
		    'Africa/Lubumbashi' => '(UTC+02:00) Lubumbashi',
		    'Africa/Lusaka' => '(UTC+02:00) Lusaka',
		    'Africa/Maputo' => '(UTC+02:00) Maputo',
		    'Europe/Mariehamn' => '(UTC+02:00) Mariehamn',
		    'Africa/Maseru' => '(UTC+02:00) Maseru',
		    'Africa/Mbabane' => '(UTC+02:00) Mbabane',
		    'Asia/Nicosia' => '(UTC+02:00) Nicosia',
		    'Europe/Riga' => '(UTC+02:00) Riga',
		    'Europe/Simferopol' => '(UTC+02:00) Simferopol',
		    'Europe/Sofia' => '(UTC+02:00) Sofia',
		    'Europe/Tallinn' => '(UTC+02:00) Tallinn',
		    'Europe/Uzhgorod' => '(UTC+02:00) Uzhgorod',
		    'Europe/Vilnius' => '(UTC+02:00) Vilnius',
		    'Europe/Zaporozhye' => '(UTC+02:00) Zaporozhye',
		    'Africa/Addis_Ababa' => '(UTC+03:00) Addis Ababa',
		    'Asia/Aden' => '(UTC+03:00) Aden',
		    'Asia/Amman' => '(UTC+03:00) Amman',
		    'Indian/Antananarivo' => '(UTC+03:00) Antananarivo',
		    'Africa/Asmara' => '(UTC+03:00) Asmara',
		    'Asia/Baghdad' => '(UTC+03:00) Baghdad',
		    'Asia/Bahrain' => '(UTC+03:00) Bahrain',
		    'Indian/Comoro' => '(UTC+03:00) Comoro',
		    'Africa/Dar_es_Salaam' => '(UTC+03:00) Dar es Salaam',
		    'Africa/Djibouti' => '(UTC+03:00) Djibouti',
		    'Africa/Juba' => '(UTC+03:00) Juba',
		    'Europe/Kaliningrad' => '(UTC+03:00) Kaliningrad',
		    'Africa/Kampala' => '(UTC+03:00) Kampala',
		    'Africa/Khartoum' => '(UTC+03:00) Khartoum',
		    'Asia/Kuwait' => '(UTC+03:00) Kuwait',
		    'Indian/Mayotte' => '(UTC+03:00) Mayotte',
		    'Europe/Minsk' => '(UTC+03:00) Minsk',
		    'Africa/Mogadishu' => '(UTC+03:00) Mogadishu',
		    'Africa/Nairobi' => '(UTC+03:00) Nairobi',
		    'Asia/Qatar' => '(UTC+03:00) Qatar',
		    'Asia/Riyadh' => '(UTC+03:00) Riyadh',
		    'Antarctica/Syowa' => '(UTC+03:00) Syowa',
		    'Asia/Tehran' => '(UTC+03:30) Tehran',
		    'Asia/Baku' => '(UTC+04:00) Baku',
		    'Asia/Dubai' => '(UTC+04:00) Dubai',
		    'Indian/Mahe' => '(UTC+04:00) Mahe',
		    'Indian/Mauritius' => '(UTC+04:00) Mauritius',
		    'Europe/Moscow' => '(UTC+04:00) Moscow',
		    'Asia/Muscat' => '(UTC+04:00) Muscat',
		    'Indian/Reunion' => '(UTC+04:00) Reunion',
		    'Europe/Samara' => '(UTC+04:00) Samara',
		    'Asia/Tbilisi' => '(UTC+04:00) Tbilisi',
		    'Europe/Volgograd' => '(UTC+04:00) Volgograd',
		    'Asia/Yerevan' => '(UTC+04:00) Yerevan',
		    'Asia/Kabul' => '(UTC+04:30) Kabul',
		    'Asia/Aqtau' => '(UTC+05:00) Aqtau',
		    'Asia/Aqtobe' => '(UTC+05:00) Aqtobe',
		    'Asia/Ashgabat' => '(UTC+05:00) Ashgabat',
		    'Asia/Dushanbe' => '(UTC+05:00) Dushanbe',
		    'Asia/Karachi' => '(UTC+05:00) Karachi',
		    'Indian/Kerguelen' => '(UTC+05:00) Kerguelen',
		    'Indian/Maldives' => '(UTC+05:00) Maldives',
		    'Antarctica/Mawson' => '(UTC+05:00) Mawson',
		    'Asia/Oral' => '(UTC+05:00) Oral',
		    'Asia/Samarkand' => '(UTC+05:00) Samarkand',
		    'Asia/Tashkent' => '(UTC+05:00) Tashkent',
		    'Asia/Colombo' => '(UTC+05:30) Colombo',
		    'Asia/Kolkata' => '(UTC+05:30) Kolkata',
		    'Asia/Kathmandu' => '(UTC+05:45) Kathmandu',
		    'Asia/Almaty' => '(UTC+06:00) Almaty',
		    'Asia/Bishkek' => '(UTC+06:00) Bishkek',
		    'Indian/Chagos' => '(UTC+06:00) Chagos',
		    'Asia/Dhaka' => '(UTC+06:00) Dhaka',
		    'Asia/Qyzylorda' => '(UTC+06:00) Qyzylorda',
		    'Asia/Thimphu' => '(UTC+06:00) Thimphu',
		    'Antarctica/Vostok' => '(UTC+06:00) Vostok',
		    'Asia/Yekaterinburg' => '(UTC+06:00) Yekaterinburg',
		    'Indian/Cocos' => '(UTC+06:30) Cocos',
		    'Asia/Rangoon' => '(UTC+06:30) Rangoon',
		    'Asia/Bangkok' => '(UTC+07:00) Bangkok',
		    'Indian/Christmas' => '(UTC+07:00) Christmas',
		    'Antarctica/Davis' => '(UTC+07:00) Davis',
		    'Asia/Ho_Chi_Minh' => '(UTC+07:00) Ho Chi Minh',
		    'Asia/Hovd' => '(UTC+07:00) Hovd',
		    'Asia/Jakarta' => '(UTC+07:00) Jakarta',
		    'Asia/Novokuznetsk' => '(UTC+07:00) Novokuznetsk',
		    'Asia/Novosibirsk' => '(UTC+07:00) Novosibirsk',
		    'Asia/Omsk' => '(UTC+07:00) Omsk',
		    'Asia/Phnom_Penh' => '(UTC+07:00) Phnom Penh',
		    'Asia/Pontianak' => '(UTC+07:00) Pontianak',
		    'Asia/Vientiane' => '(UTC+07:00) Vientiane',
		    'Asia/Brunei' => '(UTC+08:00) Brunei',
		    'Antarctica/Casey' => '(UTC+08:00) Casey',
		    'Asia/Choibalsan' => '(UTC+08:00) Choibalsan',
		    'Asia/Chongqing' => '(UTC+08:00) Chongqing',
		    'Asia/Harbin' => '(UTC+08:00) Harbin',
		    'Asia/Hong_Kong' => '(UTC+08:00) Hong Kong',
		    'Asia/Kashgar' => '(UTC+08:00) Kashgar',
		    'Asia/Krasnoyarsk' => '(UTC+08:00) Krasnoyarsk',
		    'Asia/Kuala_Lumpur' => '(UTC+08:00) Kuala Lumpur',
		    'Asia/Kuching' => '(UTC+08:00) Kuching',
		    'Asia/Macau' => '(UTC+08:00) Macau',
		    'Asia/Makassar' => '(UTC+08:00) Makassar',
		    'Asia/Manila' => '(UTC+08:00) Manila',
		    'Australia/Perth' => '(UTC+08:00) Perth',
		    'Asia/Shanghai' => '(UTC+08:00) Shanghai',
		    'Asia/Singapore' => '(UTC+08:00) Singapore',
		    'Asia/Taipei' => '(UTC+08:00) Taipei',
		    'Asia/Ulaanbaatar' => '(UTC+08:00) Ulaanbaatar',
		    'Asia/Urumqi' => '(UTC+08:00) Urumqi',
		    'Australia/Eucla' => '(UTC+08:45) Eucla',
		    'Asia/Dili' => '(UTC+09:00) Dili',
		    'Asia/Irkutsk' => '(UTC+09:00) Irkutsk',
		    'Asia/Jayapura' => '(UTC+09:00) Jayapura',
		    'Pacific/Palau' => '(UTC+09:00) Palau',
		    'Asia/Pyongyang' => '(UTC+09:00) Pyongyang',
		    'Asia/Seoul' => '(UTC+09:00) Seoul',
		    'Asia/Tokyo' => '(UTC+09:00) Tokyo',
		    'Australia/Adelaide' => '(UTC+09:30) Adelaide',
		    'Australia/Broken_Hill' => '(UTC+09:30) Broken Hill',
		    'Australia/Darwin' => '(UTC+09:30) Darwin',
		    'Australia/Brisbane' => '(UTC+10:00) Brisbane',
		    'Pacific/Chuuk' => '(UTC+10:00) Chuuk',
		    'Australia/Currie' => '(UTC+10:00) Currie',
		    'Antarctica/DumontDUrville' => '(UTC+10:00) DumontDUrville',
		    'Pacific/Guam' => '(UTC+10:00) Guam',
		    'Australia/Hobart' => '(UTC+10:00) Hobart',
		    'Asia/Khandyga' => '(UTC+10:00) Khandyga',
		    'Australia/Lindeman' => '(UTC+10:00) Lindeman',
		    'Australia/Melbourne' => '(UTC+10:00) Melbourne',
		    'Pacific/Port_Moresby' => '(UTC+10:00) Port Moresby',
		    'Pacific/Saipan' => '(UTC+10:00) Saipan',
		    'Australia/Sydney' => '(UTC+10:00) Sydney',
		    'Asia/Yakutsk' => '(UTC+10:00) Yakutsk',
		    'Australia/Lord_Howe' => '(UTC+10:30) Lord Howe',
		    'Pacific/Efate' => '(UTC+11:00) Efate',
		    'Pacific/Guadalcanal' => '(UTC+11:00) Guadalcanal',
		    'Pacific/Kosrae' => '(UTC+11:00) Kosrae',
		    'Antarctica/Macquarie' => '(UTC+11:00) Macquarie',
		    'Pacific/Noumea' => '(UTC+11:00) Noumea',
		    'Pacific/Pohnpei' => '(UTC+11:00) Pohnpei',
		    'Asia/Sakhalin' => '(UTC+11:00) Sakhalin',
		    'Asia/Ust-Nera' => '(UTC+11:00) Ust-Nera',
		    'Asia/Vladivostok' => '(UTC+11:00) Vladivostok',
		    'Pacific/Norfolk' => '(UTC+11:30) Norfolk',
		    'Asia/Anadyr' => '(UTC+12:00) Anadyr',
		    'Pacific/Auckland' => '(UTC+12:00) Auckland',
		    'Pacific/Fiji' => '(UTC+12:00) Fiji',
		    'Pacific/Funafuti' => '(UTC+12:00) Funafuti',
		    'Asia/Kamchatka' => '(UTC+12:00) Kamchatka',
		    'Pacific/Kwajalein' => '(UTC+12:00) Kwajalein',
		    'Asia/Magadan' => '(UTC+12:00) Magadan',
		    'Pacific/Majuro' => '(UTC+12:00) Majuro',
		    'Antarctica/McMurdo' => '(UTC+12:00) McMurdo',
		    'Pacific/Nauru' => '(UTC+12:00) Nauru',
		    'Antarctica/South_Pole' => '(UTC+12:00) South Pole',
		    'Pacific/Tarawa' => '(UTC+12:00) Tarawa',
		    'Pacific/Wake' => '(UTC+12:00) Wake',
		    'Pacific/Wallis' => '(UTC+12:00) Wallis',
		    'Pacific/Chatham' => '(UTC+12:45) Chatham',
		    'Pacific/Apia' => '(UTC+13:00) Apia',
		    'Pacific/Enderbury' => '(UTC+13:00) Enderbury',
		    'Pacific/Fakaofo' => '(UTC+13:00) Fakaofo',
		    'Pacific/Tongatapu' => '(UTC+13:00) Tongatapu',
		    'Pacific/Kiritimati' => '(UTC+14:00) Kiritimati',
		);

		return $timezones;
    }
}
