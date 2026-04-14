<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function GeneralSettings(){
        return view('backend.settings');
    }
    public function homePage(){
        $title = trans('app.general_settings');
        return view('backend.home', compact('title'));
    }
    public function socialLogin(){
        $title = trans('app.general_settings');
        return view('backend.social_login', compact('title'));
    }

    public function PaymentSettings(){
        $title = trans('app.payment_settings');
        return view('backend.payment_settings', compact('title'));
    }
    public function AdSettings(){
        $title = trans('app.ad_settings_and_pricing');
        return view('backend.ad_settings', compact('title'));
    }

    public function StorageSettings(){
        $title = trans('app.file_storage_settings');
        return view('backend.storage_settings', compact('title'));
    }

    public function SocialSettings(){
        $title = trans('app.social_settings');
        return view('backend.social_settings', compact('title'));
    }
    public function reCaptchaSettings(){
        $title = trans('app.re_captcha_settings');
        return view('backend.re_captcha_settings', compact('title'));
    }
    public function BlogSettings(){
        $title = trans('app.blog_settings');
        return view('backend.blog_settings', compact('title'));
    }
    public function ThemeSettings(){
        $title = trans('app.theme_settings');
        return view('backend.theme_settings', compact('title'));
    }
    public function modernThemeSettings(){
        $title = trans('app.modern_theme_settings');
        return view('backend.modern_theme_settings', compact('title'));
    }

    public function SocialUrlSettings(){
        $title = trans('app.social_url_settings');
        return view('backend.social_url_settings', compact('title'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request) {

        if(config('app.is_demo')) return ['success'=>false, 'msg'=>trans('app.feature_disable_demo')];

        $inputs = Arr::except($request->input(), ['_token']);

        foreach($inputs as $key => $value) {
            $option = Option::firstOrCreate(['option_key' => $key]);
            $option -> option_value = $value;
            $option->save();
        }
        //check is request comes via ajax?
        if ($request->ajax()){
            return ['success'=>1, 'msg'=>trans('app.settings_saved_msg')];
        }
        return redirect()->back()->with('success', trans('app.settings_saved_msg'));
    }


    public function monetization(){
        $title = trans('app.website_monetization');
        return view('backend.website_monetization', compact('title'));
    }
}
