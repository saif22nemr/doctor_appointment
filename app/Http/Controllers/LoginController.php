<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Activity;
use App\Models\Phone;
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
       
        if($request->method() == 'GET'):
            return view('admin.login');
        elseif($request->method() == 'POST'):
            // return $request->all();
            if($request->has('username')){
                if(is_numeric($request->username) and !$phone = Phone::where('number' , $request->number)->first()){
                    throw ValidationException::withMessages([
                        'username'   => trans('login.error_phone_not_found')
                    ]);
                }elseif(!$user = User::whereIn('group' , [1,2])->where('username' , $request->username)->first()){
                    throw ValidationException::withMessages([
                        'username'   => trans('login.error_username')
                    ]);
                }
                if(isset($phone->number)){ // if found phone , it will get user
                    $user = User::whereIn('group' , [1,2])->where('id' , $phone->user_id)->get();
                }
            }else{ // if not enter username or phone number
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
            $user->api_token = $token;
            $user->save();
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
        $user = Auth::user();
        $user->api_token = null;
        $user->save();
        Auth::logout();
        return redirect(route('dashboard.login'));
    }
}
