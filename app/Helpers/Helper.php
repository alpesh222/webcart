<?php

namespace App\Helpers;
use App\Role;
class Helper {
    public static function convertCurrency($amount, $from, $to) {
        $data = file_get_contents('https://free.currencyconverterapi.com/api/v6/convert?q=' . $from . '_' . $to . '&compact=ultra&apiKey=' . config('settings.currencyconverterapi_key'));
        $json = json_decode($data, true);
        $rate = implode(" ",$json);
        $converted = $rate * $amount;
        return $converted;
    }

    public static function supportedLanguages() {
        $languages = array(
            'en' => 'English',
            'ar' => 'Arabic',
            'de' => 'German',
            'ru' => 'Russian',
        );

        return $languages;
    }
    public static function check_image_avatar($avatar_image_url, $size, $default_image = '',$height ='') {
            $image_name =  explode('/',$avatar_image_url);
            $total_div = count($image_name);
            $image_name = $image_name[$total_div - 1];
            if (!empty($avatar_image_url) && file_exists(base_path().'/public/'.\App\Photo::getPhotoDirectoryName().'/'.$image_name)){
                $image_url = $avatar_image_url ;
            }else{
                if ($height == ''){
                    $height = $size;
                }
                $image_url = $default_image != '' ? $default_image : 'https://via.placeholder.com/'.$size.'x'.$height.'?text=No+Image';
            }
        return $image_url;
    }

    public static function get_user_role($user) {
        if($user->role) {
            $user_role = array(
                'role_id' => $user->role->id,
                'role_name' => $user->role->name,
            );
        }else{
            $user_role_id =  0;
            if ($user->vendor){
                $vendor_role_id = Role::vendorRoleId();
                if($vendor_role_id){
                    $user_role_id = $vendor_role_id;
                }
                $user_role = array(
                    'role_id' => $user_role_id,
                    'role_name' => 'Vendor',
                );
            }else{
                $user_role = array(
                    'role_id' => $user_role_id,
                    'role_name' => 'User',
                );
            }
        }
        return $user_role;
    }


    public static function getCurrentActivatedTheme(){
        if(!$current_theme = config('themeswitcher.current_theme')){
            $current_theme = 'theme1';
        }
        return $current_theme;
    }




}