<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $setting;
    public $user = null;
    protected $viewShare = null;
    public $lang , $apiToken;
    public function __construct(){
        
        $this->getConstruct();
        $this->webConstruct();
        View::share($this->viewShare);
    //    $this->middleware('auth');
            
    }
    protected function getConstruct(){
        
        $this->lang = app()->getLocale();
        $sets =  Setting::all();
        $this->setting = [];
        foreach($sets as $set){
            $this->setting[$set->name] = $set->data;
        }
        
    	$this->viewShare = [
            'setting' => $this->setting,
            'lang' => $this->lang,
            'apiToken' => $this->apiToken
        ];
        View::share($this->viewShare);
    }
    protected function webConstruct(){
        $this->middleware(function ($request, $next) {
            $now = Carbon::now();
            if(Auth::check()){
                $this->user = $request->user();
                $this->apiToken = $this->user->api_token;
                $this->viewShare['apiToken'] = $this->apiToken;
                $this->viewShare['auth_user'] = $this->user;
            }

            
            View::share($this->viewShare);
            return $next($request);
        });
    }
}
