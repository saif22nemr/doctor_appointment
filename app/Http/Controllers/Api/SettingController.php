<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    //

    public function index()
    {
       $sets = Setting::all();
       $settings = [];
       foreach($sets as $set){
            $settings[$set->name] = $set->data;
       }
       return $this->successResponse(['settings' => $settings]);
    }

    
    public function update(Request $request){
        // foreach (['sms_url' , 'sms_status' , 'sms_number' , 'sms_password' , 'sms_sender' , 'site_title' , 'site_icon' , 'site_footer' , 'meta_name' , 'meta_description' , 'meta_keyword'] as $value) {
        //     Setting::create([
        //         'key' => $value,
        //         'value' => ''
        //     ]);
        // }
      // return $this->errorResponse($request->all());
        $request->validate([
            'email' => 'email',
            'email_password' => 'max:100',
            'email_host' => 'min:3|max:100',
            'email_sender' => 'min:1|max:100',
            'email_port' => 'numeric|min:0',
            // 'sms_url' => 'url',
            // 'sms_status' => 'boolean',
            // 'sms_number' => 'numeric',
            // 'sms_password' => 'max:100',
            // 'sms_sender' => 'min:1|max:190',
            'site_title' => 'min:1|max:190',
            'site_title_en' => 'min:1|max:190',
            'site_icon' => 'image',
            // 'site_description',
            'site_footer' => 'min:3|max:190',
            'meta_name' => 'min:1|max:190',
            'meta_description' => 'min:1|max:1000',
            'meta_keywords' =>  'min:1|max:1000',
            'site_footer_en' => 'min:3|max:190',
            'meta_name_en' => 'min:1|max:190',
            'meta_description_en' => 'min:1|max:1000',
            'meta_keywords_en' =>  'min:1|max:1000',
            'meta_image' =>   'image',
            'color_primary' => 'min:3',
            'color_secondary' => 'min:3',
            'color_gray' => 'min:3',
            'site_email' => 'email',
            'success_percent' => 'integer',
            'semester_success_percent' => 'integer',
            'slideshow_enable'          => 'boolean',

        ]);
        // if($request->has('sms_number')) $request->sms_number = (int)$request->sms_number;
       $data = $request->only([
        'email' , 'email_password', 'email_host' , 'email_sender' , 'email_port',
         //'sms_url' , 'sms_status' , 'sms_number' , 'sms_password' , 'sms_sender' , 
         'site_title' , 'site_icon' , 'site_footer' , 'meta_name' , 'meta_description' , 'meta_keywords','meta_image' ,  'site_email', 'site_title_en'  , 'site_footer_en' , 'meta_name_en' , 'meta_description_en' , 'meta_keywords_en' , 'success_percent' ,'semester_success_percent' , 'slideshow_enable'
       ]); 
       if(count($data) == 0){
            return $this->errorResponse(trans('app.nothing_to_update'));
       }
       foreach ($data as $key => $value) {
            $setting = Setting::where('name' , $key)->first();
            if(isset($setting->id)){
                if($key == 'site_icon'){
                    $setting->data = $request->site_icon->store('image');
               }
               elseif($key == 'meta_image'){
                    $setting->data = $request->meta_image->store('image');
               }elseif(strlen($value) > 0){
                    $setting->data = $value;
               }
               $setting->save();
            }
           
       }
       if(!isset($request->sms_status)){
          $t = Setting::where('name' , 'sms_status')->first();
          $t->data = 0;
          $t->save();
       }
       $activity = new Activity([
            'type' => 'edit',
            'user_id' => $this->user->id,
            'activitable_type' => 'App\Models\Setting',
            'description' => trans('activity.setting_edit' , ['name'=>$this->user->name] , 'ar'),
            
        ]);
        $activity->save();
       return $this->successResponse([
        'success' => true,
        'message' => trans('app.edit_successfully'),
        'setting' => $request->all(),
       ]);
    }
  
}
