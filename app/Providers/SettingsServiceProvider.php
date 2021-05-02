<?php

namespace App\Providers;

use DB;
use App\Setting;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Factory $cache, Setting $settings)
    {
        if(DB::connection()->getPdo() && Schema::hasTable('settings')) {
            $settings = $cache->remember('settings', 60, function() use ($settings)
            {
                return $settings->pluck('value', 'key')->all();
            });
    
            config()->set('settings', $settings);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
