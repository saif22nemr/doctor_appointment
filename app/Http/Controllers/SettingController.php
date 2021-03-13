<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //

    public function index(){

        $sets = Setting::all();
        $setting = [];
        foreach($sets as $key => $set){
            $setting[$set->name] = $set->data;
        }
        $action = 'edit';
        return view('admin.setting.setting_form' , compact('setting' , 'action'));
    }
}
