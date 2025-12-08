<?php

namespace App\Http\Controllers;

use App\Models\General\Setting;
use App\Models\General\State;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Toastr;


class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Default Settings';
        $setting = (object)Setting::pluck('value', 'key')->toArray();
        $states = $setting->site_country ? State::where('country_id', $setting->site_country)->get()
                    : State::get();

        return view('admin.settings.index', compact('states', 'setting'));
    }

    public function save(Request $request)
    {
        $request->validate(array_map(fn ($data) => [$data => 'required'], $request->except(['_token', 'favicon', 'logo', 'general_discount'])));

        $data = [];
        $settings = (object)Setting::pluck('value', 'key')->toArray();

        foreach($request->except(['_token', 'favicon', 'logo', 'general_discount']) as $key => $value){
            $data[] = ['key' => $key, 'value' => $value];
        }

        if($request->general_discount != $settings->general_discount){
            $discount = $request->general_discount/100;
            
            Product::query()->update([
                    'selling_price' => DB::raw('selling_price - selling_price * ' . $discount),
                    'discount' => $request->general_discount,
                ]);

            $data[] = ['key' => 'general_discount', 'value' => $request->general_discount];
        }

        if($request->hasFile('favicon')){

            if(file_exists("./assets/".$settings->site_favicon)==1){
                unlink("./assets/".$settings->site_favicon);
            }

            $favicon = photo("favicon","site_files/","assets/");

            $data[] = ['key' => 'site_favicon', 'value' => $favicon];
        }

        if($request->hasFile('logo')){
            
            if(file_exists("./assets/".$settings->site_logo)==1){
                unlink("./assets/".$settings->site_logo);
            }

		    $logo = photo("logo","site_files/","assets/");

            $data[] = ['key' => 'site_logo', 'value' => $logo];
        }

        Setting::upsert($data, ['key'], ['value']);

        Toastr::success('Service Created successfully', 'success');

        return redirect('admin/settings');
    }

    public function sliders()
    {
        $title = 'Banners Settings';
        return view('admin.settings.sliders', compact('title'));
    }
}
