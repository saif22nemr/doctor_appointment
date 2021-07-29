<?php

namespace App\Http\Controllers;

use App\Models\Permission;
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
    public $lang , $apiToken , $defaultRoute;
    
    public function __construct(){
        // $this->mailConfig();
        $this->generalConstruct();
            
    }
    protected function generalConstruct(){
        $this->defaultRoute = route('dashboard.index');
        $this->getConstruct();
        $this->webConstruct();
        View::share($this->viewShare);
       $this->middleware('auth');
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

    // check permission
    public function checkPermission($permission  = '' , $role = ''){
        if($this->user->group == 1){
            return true;
        }elseif($this->user->group == 2){
            $permission = Permission::where('key' , $permission)->first();
            if(isset($permission->id) and $this->user->userPermissions()->where('permission_id' , $permission->id)->where($role , 1)->first()){
                return true;
            }
        }

        return false;
    }
    public function employeePermission($permission = '' , $role = ''){
        if(!$this->checkPermission($permission , $role)){
            return redirect(route('dashboard.index'));
        }
        // return true;
    }
    private function mailConfig(){
        $sets = Setting::all();
        $setting = [];
        foreach($sets as $set){
            $setting[$set->name] = $set->data;
            
        }
        Config::set('mail.mailers.smtp.username', trim($setting['email']));    
        Config::set('mail.mailers.smtp.host', trim($setting['email_host']));    
        Config::set('mail.mailers.smtp.port', trim($setting['email_port']));    
        Config::set('mail.mailers.smtp.encryption', trim('tls'));    
        Config::set('mail.default', trim('smtp'));    
        Config::set('mail.mailers.smtp.password', trim($setting['email_password']));
    }
}
