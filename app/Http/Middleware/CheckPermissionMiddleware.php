<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check()){
            // return redirect('dashboard.login');
        }else{
            $user = auth()->user();
            $permissionName = $request->segment(2) ;
            $roleName = $request->segment(3) ;
            if(is_numeric($roleName)){
                $roleName = $request->segment(4);
            }
            if(!in_array($roleName , ['view' , 'create' , 'edit'])){
                $roleName = $roleName ==  'appliaction' ? 'edit' : 'view';
            }
            if($user->group == 2 && in_array($permissionName , ['profile' , 'logout' , 'login' ])){ // always allow
                // return redirect(route('dashboard.index'));
            }
            elseif($user->group == 2 and !empty($roleName) and !empty($permissionName)){
                $permission = Permission::where('key' , $permissionName)->first();
                if(!isset($permission->id) ||  !$user->userPermissions()->where('permission_id' , $permission->id)->where($roleName , 1)->first()){
                    return redirect(route('dashboard.index') );
                }
            }elseif($user->group == 1 || (empty($permissionName) && $request->segment(1) == 'dashboard') ){}
            elseif($user->group != 1 or $user->group != 2){
                return redirect(route('dashboard.index'));
            }
        }
        return $next($request);
    }
}
