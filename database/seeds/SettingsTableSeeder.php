<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'contact_email', 'value' => 'contact@infigosoftware.in'],
            ['key' => 'tax_rate', 'value' => 0],
            ['key' => 'site_logo', 'value' => 'site-logo.png'],
            ['key' => 'export_table_enable', 'value' => false],
            ['key' => 'toast_notifications_enable', 'value' => true],
            ['key' => 'loading_animation_enable', 'value' => false],
            ['key' => 'site_logo_name', 'value' => ''],
            ['key' => 'site_logo_colour', 'value' => '#fff'],
            ['key' => 'site_logo_enable', 'value' => true],
            ['key' => 'site_logo_width', 'value' => '150px'],
            ['key' => 'site_logo_height', 'value' => '75px'],
            ['key' => 'shipping_cost', 'value' => 0],
            ['key' => 'shipping_cost_valid_below', 'value' => 499.99],
            ['key' => 'social_link_facebook', 'value' => 'http://facebook.com'],
            ['key' => 'social_link_instagram', 'value' => 'http://instagram.com'],
            ['key' => 'social_link_twitter', 'value' => 'http://twitter.com'],
            ['key' => 'social_link_youtube', 'value' => 'http://youtube.com'],
            ['key' => 'main_slider_enable', 'value' => true],
            ['key' => 'products_slider_enable', 'value' => true],
            ['key' => 'categories_slider_enable', 'value' => true],
            ['key' => 'brands_slider_enable', 'value' => true],
            ['key' => 'banners_right_side_enable', 'value' => false],
            ['key' => 'footer_enable', 'value' => true],
            ['key' => 'social_link_facebook_enable', 'value' => true],
            ['key' => 'social_link_instagram_enable', 'value' => true],
            ['key' => 'social_link_twitter_enable', 'value' => true],
	        ['key' => 'social_link_youtube_enable', 'value' => true],
	        ['key' => 'social_link_google_plus_enable', 'value' => true],
	        ['key' => 'social_link_linkedin_enable', 'value' => true],
            ['key' => 'social_link_google_plus', 'value' => 'http://plus.google.com'],
	        ['key' => 'social_link_linkedin', 'value' => 'http://linkedin.com'],
	        ['key' => 'social_share_enable', 'value' => true],
	        ['key' => 'facebook_app_id', 'value' => ''],
            ['key' => 'contact_number', 'value' => ''],
            ['key' => 'hide_main_slider_in_devices', 'value' => true],
            ['key' => 'currencyconverterapi_key', 'value' => ''],
            ['key' => 'terms_of_service_url', 'value' => ''],
            ['key' => 'privacy_policy_url', 'value' => ''],
            ['key' => 'copyright_text', 'value' => 'Developed By <a id="webcart-link" href="https://web-cart.com" target="_blank">Web-Cart</a>&nbsp;&copy; ' . date("Y") . '&nbsp; All Rights Reserved'],
            ['key' => 'custom_panel_css', 'value' => '#2196F3'],
            ['key' => 'about_us_title', 'value' => 'Webcart is a powerful eCommerce CMS that allows you to sell products online.'],
            ['key' => 'subscribers_title', 'value' => 'SIGN UP FOR NEWSLETTERS'],
            ['key' => 'subscribers_description', 'value' => 'Be the First to Know. Sign up for newsletter today'],
            ['key' => 'subscribers_btn_text', 'value' => 'SUBSCRIBE'],
            ['key' => 'subscribers_placeholder_text', 'value' => 'Enter Your Email'],
            ['key' => 'subscribers_background_img', 'value' => 'subscribers-img.jpg'],
            ['key' => 'enable_subscribers', 'value' => true],
            ['key' => 'enable_google_translation', 'value' => false],
            ['key' => 'enable_zip_code', 'value' => false],
            ['key' => 'pagination_count', 'value' => 9],
            ['key' => 'allow_multi_language', 'value' => false],
            ['key' => 'phone_otp_verification', 'value' => false],
            ['key' => 'webcart_package', 'value' => '1'],
        ];

        foreach($settings as $setting){
            $setting_exists = Setting::where('key', $setting['key'])->first();
            if(!$setting_exists) {
                Setting::create($setting);
            }
        }
    }
}
