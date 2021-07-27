<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function index(){
        $user = auth()->user();
        return view('admin.user.profile' , compact('user'));
    }

    public function edit(Request $request){
        $user = auth()->user();
        $action = 'edit';
        return view('admin.user.profile_form' , compact('user' , 'action'));
    }
}
