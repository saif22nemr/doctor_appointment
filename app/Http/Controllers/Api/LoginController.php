<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Phone;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'username' => 'string|min:1|max:190',
            'phone' => 'digits_detween:10,12',
            'password' => 'required_with:username,string|min:1|max:32',
            'action' => 'required_with:phone|in:send,login',
            'code' => 'digits_detween:4,6'
        ]);
        // return $request->all();
        if($request->has('username')){
           if(!$user = User::whereIn('group' , [1,2])->where('username' , $request->username)->first())
                return $this->errorResponse(trans('user.error_username'));
            if(!Hash::check($request->password , $user->password)){
                return $this->errorResponse(trans('login.error_password_fail'));
            }
            $user->OauthAccessToken()->where('name' , 'Api Token')->delete();
            $token = $user->createToken('Api Token')->accessToken;
            $user->api_token = $token;
            $user->save();
           
            $activity = new Activity([
                'description' => trans('activity.api_login' , [] , 'ar'),
                'user_id' => $user->id,
                'type' => 'login'
            ]);
            $user->activities()->save($activity);
            return $this->successResponse([
                'success' => true,
                'message' => trans('login.success_login'),
                'token' => $token,
            ]);
           
        }if($request->has('phone')){
            // leter 
        }
        else{
            return $this->errorResponse(['login.error_login_required']);
        }
               
            
        
    }

    public function logout(){

    }
}
