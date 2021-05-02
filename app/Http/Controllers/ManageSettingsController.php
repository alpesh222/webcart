<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Setting;
use App\User;
use App\Photo;
use App\Other;
use App\Location;
use App\Http\Requests\UsersUpdateRequest;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Auth\UserActivationEmail;
use Illuminate\Support\Facades\Artisan;
use Igaster\LaravelTheme\Facades\Theme;

class ManageSettingsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('update-settings', Other::class)) {
            $settings = Setting::pluck('value', 'key')->all();
            $themes = $this->getThemes();
            return view('manage.settings.index', compact('settings', 'themes'));
        } else {
            return view('errors.403');
        }
    }

    private function getThemes()
    {
        return [
//            'default-theme' => 'Default',
            'theme1' => 'Theme 1',
            'theme2' => 'Theme 2'
        ];
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $locations = Location::pluck('name','id')->all();
        return view('manage.settings.profile', compact('user', 'locations'));
    }

    function updateProfile(UsersUpdateRequest $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $this->validate($request, [
            'email' => 'unique:users,email,'.$user->id,
            'username' => 'unique:users,username,'.$user->id
        ]);

        if(!$request->password) {
            $userInput = $request->except('password');
            $input["password"] = $user->password;
        } else {
            $userInput = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        $input["name"] = $userInput["name"];
        $input["username"] = $userInput["username"];
        $input["email"] = $userInput["email"];

        if(!$request->file('photo') && $request->remove_photo) {
            if($user->photo) {
                if(file_exists($user->photo->getPath())) {
                    unlink($user->photo->getPath());
                    $user->photo()->delete();
                }
            }
        }

        if($photo = $request->file('photo')) {
            $name = time().$photo->getClientOriginalName();
            $photo->move(Photo::getPhotoDirectoryName(), $name);
            if($user->photo) {
                if(file_exists($user->photo->getPath())) {
                    unlink($user->photo->getPath());
                    $user->photo()->delete();
                }
            }
            $photo = Photo::create(['name'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        $old_email = $user->email;

        if($old_email != $request->email) {
            if($user->id != 1){
                $input['verified'] = false;
            }
            $input['activation_token'] = str_random(191);
        }

        $user->update($input);

        if($request->email != $old_email) {
            event(new UserActivationEmail($user));
        }

        session()->flash('profile_updated', __("The profile has been updated."));

        return redirect(route('manage.settings.profile'));
    }

    public function updateStore(SettingsUpdateRequest $request, Factory $cache)
    {
        if($photo = $request->file('logo')) {
            $name = $photo->getClientOriginalName();
            if(file_exists(public_path().Photo::$directory.$name)) {
                unlink(public_path().Photo::$directory.$name);
            }
            $photo->move(Photo::getPhotoDirectoryName(), $name);
            $request->merge(['site_logo' => $name]);
        } else {
            $request->site_logo = null;
        }

        if($photo = $request->file('site_favicon')) {
            $name = $photo->getClientOriginalName();
            $favicon_extension = $photo->getClientOriginalExtension();
            if($favicon_extension == 'ico'){
                if(file_exists(public_path().'/favicon.ico')) {
                    unlink(public_path().'/favicon.ico');
                }
                $photo->move(public_path(), 'favicon.ico');
            } else {
                return redirect()->back()->withErrors(__('Please upload only ico file for favicon.'));
            }
        }

        if($request->footer_enable) {
            $request->merge(['footer_enable' => true]);
        } else {
            $request->merge(['footer_enable' => false]);
        }

	    if($request->social_share_enable) {
		    $request->merge(['social_share_enable' => true]);
	    } else {
		    $request->merge(['social_share_enable' => false]);
	    }

        if($request->social_link_facebook_enable) {
            $request->merge(['social_link_facebook_enable' => true]);
        } else {
            $request->merge(['social_link_facebook_enable' => false]);
        }

        if($request->social_link_instagram_enable) {
            $request->merge(['social_link_instagram_enable' => true]);
        } else {
            $request->merge(['social_link_instagram_enable' => false]);
        }

        if($request->social_link_twitter_enable) {
            $request->merge(['social_link_twitter_enable' => true]);
        } else {
            $request->merge(['social_link_twitter_enable' => false]);
        }

        if($request->social_link_youtube_enable) {
            $request->merge(['social_link_youtube_enable' => true]);
        } else {
            $request->merge(['social_link_youtube_enable' => false]);
        }

	    if($request->social_link_google_plus_enable) {
		    $request->merge(['social_link_google_plus_enable' => true]);
	    } else {
		    $request->merge(['social_link_google_plus_enable' => false]);
	    }

	    if($request->social_link_linkedin_enable) {
		    $request->merge(['social_link_linkedin_enable' => true]);
	    } else {
		    $request->merge(['social_link_linkedin_enable' => false]);
	    }

        if($request->site_logo_enable) {
            $request->merge(['site_logo_enable' => true]);
        } else {
            $request->merge(['site_logo_enable' => false]);
        }

        if($request->main_slider_enable) {
            $request->merge(['main_slider_enable' => true]);
        } else {
            $request->merge(['main_slider_enable' => false]);
        }

        if($request->products_slider_enable) {
            $request->merge(['products_slider_enable' => true]);
        } else {
            $request->merge(['products_slider_enable' => false]);
        }

        if($request->hide_main_slider_in_devices) {
            $request->merge(['hide_main_slider_in_devices' => true]);
        } else {
            $request->merge(['hide_main_slider_in_devices' => false]);
        }

        if($request->categories_slider_enable) {
            $request->merge(['categories_slider_enable' => true]);
        } else {
            $request->merge(['categories_slider_enable' => false]);
        }

        if($request->brands_slider_enable) {
            $request->merge(['brands_slider_enable' => true]);
        } else {
            $request->merge(['brands_slider_enable' => false]);
        }

        if($request->banners_right_side_enable) {
            $request->merge(['banners_right_side_enable' => true]);
        } else {
            $request->merge(['banners_right_side_enable' => false]);
        }

        if($request->enable_google_translation) {
            $request->merge(['enable_google_translation' => true]);
        } else {
            $request->merge(['enable_google_translation' => false]);
        }

        if(Auth::user()->can('update-settings', Other::class)) {
            foreach($request->except('_token') as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if($setting) {
                    $setting->value = $value;
                    $setting->save();
                }
            }

            $cache->forget('settings');

            if($request->maintenance_enable) {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateTheme(Request $request)
    {
        if(Auth::user()->can('update-settings', Other::class)) {
            if($request->theme) {
                if(Theme::exists($request->theme)) {
                    $array = \Config::get('themeswitcher');
                    $array['current_theme'] = $request->theme;
                    $data = var_export($array, 1);
                    if(\File::put(base_path() . '/config/themeswitcher.php', "<?php\n return $data ;")) {
                        session()->flash('settings_saved', __("The settings has been saved."));
                    } else {
                        session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                    }
                } else {
                    session()->flash('settings_not_saved', __("This theme is not supported."));
                }
            }
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateLiveChat(Request $request)
    {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('livechat');
            $array['tawk_widget_code'] = $request->tawk_widget_code ? $request->tawk_widget_code : "";
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/livechat.php', "<?php\n return $data ;")) {
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

    public function updateTaxShipping(Request $request, Factory $cache)
    {
        $this->validate($request, [
            'tax_rate'=>'required|integer|min:0|max:100',
            'shipping_cost'=>'required|regex:/^\d*(\.\d{1,2})?$/|min:0',
            'shipping_cost_valid_below'=>'required|regex:/^\d*(\.\d{1,2})?$/|min:0'
        ]);
        if($request->enable_zip_code) {
            $request->merge(['enable_zip_code' => true]);
        } else {
            $request->merge(['enable_zip_code' => false]);
        }
        if(Auth::user()->can('update-settings', Other::class)) {
            foreach($request->except('_token') as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if($setting) {
                    $setting->value = $value;
                    $setting->save();
                }
            }
    
            $cache->forget('settings');
    
            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateVendor(Request $request)
    {
        if(Auth::user()->can('update-settings', Other::class)) {
            $this->validate($request, [
                'minimum_amount_for_request'=>'required|regex:/^\d*(\.\d{1,2})?$/|min:0'
            ]);

            $array = \Config::get('vendor');
            $array['minimum_amount_for_request'] = $request->minimum_amount_for_request;
            $array['enable_vendor_signup'] = (bool) $request->enable_vendor_signup;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/vendor.php', "<?php\n return $data ;")) {
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

    public function updateAdminPanel(Request $request, Factory $cache)
    {
        if($request->export_table_enable) {
            $request->merge(['export_table_enable' => true]);
        } else {
            $request->merge(['export_table_enable' => false]);
        }

        if($request->toast_notifications_enable) {
            $request->merge(['toast_notifications_enable' => true]);
        } else {
            $request->merge(['toast_notifications_enable' => false]);
        }

        if($request->loading_animation_enable) {
            $request->merge(['loading_animation_enable' => true]);
        } else {
            $request->merge(['loading_animation_enable' => false]);
        }

        if(Auth::user()->can('update-settings', Other::class)) {
            foreach($request->except('_token') as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if($setting) {
                    $setting->value = $value;
                    $setting->save();
                }
            }
    
            $cache->forget('settings');

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateRecaptcha(Request $request) {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('recaptcha');
                    $array['enable'] = $request->enable_recaptcha;
                    $array['public_key'] = $request->recaptcha_public_key;
                    $array['private_key'] = $request->recaptcha_private_key;
                    $data = var_export($array, 1);
                    if(\File::put(base_path() . '/config/recaptcha.php', "<?php\n return $data ;")) {
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

    public function updateGoogleMap(Request $request) {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('googlemap');
            $array['embed_code'] = $request->map_embed_code;
            $array['api_key'] = $request->map_api_key;
            $array['location_name'] = $request->map_location;
            $array['zoom'] = $request->map_zoom;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/googlemap.php', "<?php\n return $data ;")) {
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

    public function updateGoogleAnalytics(Request $request) {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('analytics');
            $array['google_analytics_script'] = $request->tracking_code;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/analytics.php', "<?php\n return $data ;")) {
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

    public function updateSiteMap(Request $request) {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('site_map');
            $array['site_map_url'] = $request->site_map_url;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/site_map.php', "<?php\n return $data ;")) {
            } else {
                session()->flash('settings_not_saved', __("Error saving the settings. There may be no permission to modify the file."));
                return redirect()->back();
            }

            if($file = $request->file('site_map_file')) {
                $file_extension = $file->getClientOriginalExtension();
                if($file_extension == 'xml'){
                    if(file_exists(public_path().'/sitemap.xml')) {
                        unlink(public_path().'/sitemap.xml');
                    }
                    $file->move(public_path(), 'sitemap.xml');
                } else {
                    return redirect()->back()->withErrors(__('Please upload only xml file for Site Map.'));
                }
            }

            session()->flash('settings_saved', __("The settings has been saved."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updateReferral(Request $request) {
        if(Auth::user()->can('update-settings', Other::class)) {
            $array = \Config::get('referral');
            if($request->enable_referral) { $array['enable'] = true; }
            else { $array['enable'] = false; }
            $array['referral_to_amt']   = $request->referral_to_amt;
            $array['referral_by_amt']   = $request->referral_by_amt;
            $data = var_export($array, 1);
            if(\File::put(base_path() . '/config/referral.php', "<?php\n return $data ;")) {
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
}
