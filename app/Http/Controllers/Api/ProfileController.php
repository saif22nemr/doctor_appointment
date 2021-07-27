<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends ApiController
{
    //

    public function update(Request $request){
        $request->validate([
            'email' => 'email',
            'password' => 'min:1|max:20|string',
            'username' => 'string|min:1|max:190',
        ]);

        if($request->has('username') and $checkUsername = User::where('username' , $request->username)->where('id' , '!=',$this->user->id)->first()){
            return $this->errorResponse(trans('user.error_username_unique'));
        }

        if($request->has('email') and $checkUsername = User::where('email' , $request->email)->where('id' , '!=',$this->user->id)->first()){
            return $this->errorResponse(trans('user.error_email_unique'));
        }

        $data = $request->only(['username' , 'email']);
        if($request->has('password')){
            $data['password'] = Hash::make($request->password);
        }

        $this->user->update($data);
        $activity = new Activity([
            'type' => 'edit',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.edit_profile' , ['patient' => $this->user->name]),
           
        ]);
        $this->user->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.edit_successfully'),
            'data'  => $this->user
        ]);
    }
}
