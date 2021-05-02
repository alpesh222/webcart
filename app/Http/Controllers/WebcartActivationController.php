<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Factory;
use App\Setting;
use Illuminate\Support\Facades\Artisan;

class WebcartActivationController extends Controller
{
    private $api_url = 'https://api.envato.com/v3/market/author/sale';
    private $item_id = 23437961;
    public $error_message = null;

    public function activation()
    {
        if (config('settings.webcart_package') !== '1') {
            return view('activate.activate');
        }
        return view('errors.404');
    }

    public function demoData()
    {
        return view('activate.demo-data');
    }

    public function importDemoData(Request $request)
    {
        $this->validate($request, [
            'demo_template' => 'required'
        ]);
        try {
            $message = __('Data Reset To Default State Successfully!');
            if ($request->demo_template != 'default') {
                Artisan::call('demo:template', ['template' => $request->demo_template]);
                $message = __('Demo Data Imported Successfully! Prowebber.ru');
            }
            session()->flash('success', $message);
            return redirect('/');
        } catch (\Exception $e) {
            $this->error_message = $e->getMessage();
            session()->flash('webcart_not_activated', $this->error_message);
        }

        // return redirect()->back();
    }

    public function activate(Request $request, Factory $cache)
    {




        $body = json_decode(true);

        $request->merge(['webcart_package' => '1']);
        foreach ($request->except('_token') as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }
        $cache->forget('settings');
        $message = __('Your package is activated successfully. ProWebber.ru');
        session()->flash('success', $message);
        if (!empty($request->demo_data) && $request->demo_data == 'on') {
            return redirect(route('webcart.demo_data'));
        }
        return redirect('/');


        return redirect()->back();
    }
}
