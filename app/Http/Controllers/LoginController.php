<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->getConstruct();
    }
    //
    public function login(Request $request){
        if(Auth::check()){
            return redirect(route('dashboard.index'));
        }
        if($request->method() == 'GET'):
            return view('admin.login');
        elseif($request->method() == 'POST'):
            // return $request->all();
            if(!$request->has('username') or !$user = User::where('username' , $request->username)->first()){
                throw ValidationException::withMessages([
                    'username'   => trans('login.error_username')
                ]);
            }
            if(!$request->has('password') and strlen($request->password) < 4){
                throw ValidationException::withMessages([
                    'password'   => trans('login.error_password')
                ]);
            }elseif(!Hash::check($request->password, $user->password)){
                throw ValidationException::withMessages([
                    'password'   => trans('login.error_password_fail')
                ]);
            }
            // check this user is closed account
            if($user->status == 0){
                throw ValidationException::withMessages([
                    'username'   => trans('login.account_not_active')
                ]);
            }
            $user->OauthAccessToken()->where('name' , 'Web Token')->delete();
            $token = $user->createToken('Web Token')->accessToken;
            Auth::login($user);
            session()->put('auth' , [
                'access_token'  => $token,
                'user' => $user
            ]);
            $activity = new Activity([
                'description' => trans('activity.web_login' , [] , 'ar'),
                'user_id' => $user->id,
                'type' => 'login'
            ]);
            $user->activities()->save($activity);
            return redirect(route('dashboard.index'));
        else:
            return "test";
        endif; // end post data
    }

    public function logout(){
        session()->forget('auth');
        Auth::logout();
        return redirect(route('dashboard.login'));
    }
}
