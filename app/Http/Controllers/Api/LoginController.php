<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    //

    public function __construct()
    {
        if($this->user != null and count($this->user->AauthAcessToken) == 0):
            return $this->errorResponse(trans('login.error_expire_time'));
        endif;
        $this->lang = app()->getLocale();
        $sets =  Setting::all();
        $this->setting = [];
        foreach($sets as $set){
            $this->setting[$set->name] = $set->data;
        }
    }

    public function login(Request $request){
        if(Auth::guard('api')->check()){
            return $this->successResponse([
                'success' => false,
                'message' => trans('login.login_before')
            ]);
        }
        // return $request->all();
        if($request->has('username')){
            if(is_numeric($request->username) and !$phone = Phone::where('number' , $request->number)->first())
                return $this->errorResponse(trans('login.error_phone_not_found'));
            elseif(!$user = User::whereIn('group' , [1,2])->where('username' , $request->username)->first())
                return $this->errorResponse(trans('user.error_username'));
            
            if(isset($phone->number)) // if found phone , it will get user
                $user = User::whereIn('group' , [1,2])->where('id' , $phone->user_id)->get();
        
        }else{
            
        }
               
            
        
    }

    public function logout(){

    }
}
