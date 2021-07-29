<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
        use ApiResponse;
    public $user = null , $unauthResponse;
    public function __construct(){
    	
    	// $this->getConstruct();
        
        if($this->user != null and count($this->user->AauthAcessToken) == 0):
            return $this->errorResponse(trans('login.error_expire_time'));
        endif;
        $this->lang = app()->getLocale();
        $sets =  Setting::all();
        $this->setting = [];
        foreach($sets as $set){
            $this->setting[$set->name] = $set->data;
        }
    	$this->apiGetUser();
        $this->middleware('auth:api');
        $this->unauthResponse = $this->errorResponse(trans('app.error_not_auth'));
    }
    public function apiGetUser(){
    	$this->middleware(function ($request, $next) {
            
            if(Auth::guard('api')->check()){
                $this->user  = Auth::guard('api')->user();
                if($this->user->last_login != null){
                    $now = Carbon::now();
                    $lastUpdate = Carbon::createFromTimeStamp(strtotime($this->user->last_login))->addHours(24);
                    if($now->greaterThan($lastUpdate)){
                        $this->user->OauthAcessToken()->delete();
                        return redirect('api/auth');
                    }    
                }
                
            }
            
            return $next($request);
        });
        return $this->user;
    }
}
