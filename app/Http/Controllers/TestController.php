<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    //

    public function index(){

        if(!Auth::check()){
            $user = User::where('group' , 1)->first();
            Auth::login($user);
        }
        // return $this->viewShare;
        return view('admin.dashboard');
    }
}
