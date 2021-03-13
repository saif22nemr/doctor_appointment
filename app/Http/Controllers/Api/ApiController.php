<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
        use ApiResponse;
    public $user = null;
    public function __construct(){
    	
    	// $this->getConstruct();
        
        if($this->user != null and count($this->user->AauthAcessToken) == 0):
            return $this->errorResponse(trans('login.error_expire_time'));
        endif;
    	$this->apiGetUser();
        $this->middleware('auth:api');
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
