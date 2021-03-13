<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $request->validate([
            'username'          => 'min:1|max:190',
            'name'                  => 'min:1|max:190',
            'phone'                 => 'digit',
            'group'                 => 'in:1,2,3,4',
            'sort'                     => 'in:username,name,created_at,updated_at,id',
            'order'                 => 'in:desc,asc',
        ]);
        $users = User::where('id' , '!=' , 0) ;
        if($request->has('phone')){
            $usersId  = Phone::where('number' , 'LIKE' , "%".$request->phone."%")->get()->pluck('user_id');
            $users = $users->whereIn('id' , $usersId);
        }if($request->has('username')){
            $users = $users->where('username'  , 'LIKE' , "%".$request->username."%");
        }if($request->has('name')){
            $users = $users->where('name'  , 'LIKE' , "%".$request->name."%");
        }
        if($request->has('group')){
            $users = $users->where('group' , $request->group);
        }
        $sort = $request->has('sort') ? $request->sort : 'name';
        $order = $request->has('order') ? $request->order : 'asc';

        $users = $users->with('phones')->orderBy($sort , $order)->get();
        return $this->showAll($users);
    }

}
