<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends ApiController
{
   

    public function index(Request $request)
    {
        
        $request->validate([
            'username'          => 'min:1|max:190',
            'name'                  => 'min:1|max:190',
            'phone'                 => 'digit',
            // 'group'                 => 'in:1,2,3,4',
            'sort'                     => 'in:username,name,created_at,updated_at,id',
            'order'                 => 'in:desc,asc',
        ]);
        $users = User::where('group' , 1) ;
        if($request->has('phone')){
            $users  = Phone::where('number' , 'LIKE' , "%".$request->phone."%");
            // $users = $users->whereIn('id' , $users);
        }if($request->has('username')){
            $users = $users->where('username'  , 'LIKE' , "%".$request->username."%");
        }if($request->has('name')){
            $users = $users->where('name'  , 'LIKE' , "%".$request->name."%");
        }
       
        $sort = $request->has('sort') ? $request->sort : 'name';
        $order = $request->has('order') ? $request->order : 'asc';
        $users = $users->with('phones')->orderBy($sort , $order)->get();
    
        return $this->showAll($users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'username'  => 'required|min:4|max:190|unique:users',
            'name' => 'required|min:3|max:190',
            'email' => 'email|unique:users',
            'branch_id'    => 'required|integer',
            'password'  => 'required|min:4|max:50',
            'phones'    => 'required|array|min:1|max:10',
        ]);

        // validate branch
        if(!$branch = Branch::find($request->branch_id)){
            return $this->errorResponse(trans('app.error_branch_not_found'));
        }
        if(!checkPhones($request->phones))
            return $this->errorResponse(trans('user.error_phone'));
        else{
            // check unique
            foreach($request->phones as $phone):
                if($check = Phone::where('number' , $phone['number'])->first()){
                    return $this->errorResponse(trans('user.error_phone_unique'));
                }
            endforeach;
        }
        $data = $request->only([
            'username'  ,'name' ,'email'  , 'branch_id'
        ]);
        $data['password'] = Hash::make($request->password);
        $data['group'] = 1;
        $data['status'] = 1;
        $admin = Admin::create($data);
        // store phones number
        $count = 0;
        foreach($request->phones as $phone):
            $data = [
                'user_id' => $admin->id,
                'number' => $phone['number'],
                'primary'   => $phone['primary']
            ];
            Phone::create($data);
            $count++;
        endforeach;

        // store activity
        $activity = new Activity([
            'description'   => trans('activity.create_admin' , ['admin' => $admin->name]),
            'type' => 'create', 
            'user_id' => $this->user->id,
            'related_id' => $admin->id,
            
        ]);
        $admin->activities()->save($activity);
        $admin->phones = Phone::where('user_id' , $admin->id)->get();
        return $this->successResponse([
            'success'    => true,
            'message'   => trans('app.create_successfully'),
            'data' => $admin
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        
        $admin->phones;
        return $this->showOne($admin);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'username'  => 'min:4|max:190',
            'name' => 'min:3|max:190',
            'email' => 'email',
            'branch_id' => 'integer',
            'password'  => 'min:4|max:50',
            'phones'    => 'array|min:1|max:10',
            'status'    => 'in:0,1',
        ]);
        // check branch
        if($request->has('branch_id') and !$branch = Branch::find($request->branch_id)){
            return $this->errorResponse(trans('app.error_branch_not_found'));
        }
        // check username
        if($request->has('username') and $user = User::where('id' , '!=' , $admin->id)->where('username' , $request->username)->first())
            return $this->errorResponse(trans('user.error_username_unique'));
        // check email
        if($request->has('email') and $check = User::where('id' , '!=' , $admin->id)->where('email' , $request->email)->first())
            return $this->errorResponse(trans('user.error_email_unique'));
        if($request->has('phones') and !checkPhones($request->phones))
            return $this->errorResponse(trans('user.error_phone'));
      
        $data = $request->only([
            'username'  ,'name' ,'email'  , 'status' , 'branch_id'
        ]);
        if($request->has('password')){
            $data['password'] = Hash::make($request->password);
        }
        $admin->fill($data);
        $admin->save();
        if($request->has('phones')):
            Phone::where('user_id' , $admin->id)->delete();
            // store phones number
            foreach($request->phones as $phone):
                $data = [
                    'user_id' => $admin->id,
                    'number' => $phone['number'],
                    'primary'   => $phone['primary']
                ];
                Phone::create($data);
            endforeach;
        endif;

        // store activity
        $activity = new Activity([
            'description'   => trans('activity.edit_admin' , ['admin' => $admin->name]),
            'type' => 'edit', 
            'user_id' => $this->user->id,
            'related_id' => $admin->id,
            
        ]);
        $admin->activities()->save($activity);
        $admin->phones = Phone::where('user_id' , $admin->id)->get();
        return $this->successResponse([
            'success'    => true,
            'message'   => trans('app.edit_successfully'),
            'data' => $admin
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $activity = new Activity([
            'description'   => trans('activity.delete_admin' , ['admin' => $admin->name]),
            'type' => 'delete', 
            'user_id' => $this->user->id,
            'related_id' => $admin->id,
            
        ]);
        $admin->activities()->save($activity);
        $admin->delete();
        return $this->successResponse([
            'success'    => true,
            'message'   => trans('app.delete_successfully'),
            'data' => $admin
        ]);
    }
      /**
         * 
         *  update phones for admin
         * 
         */
        
        public function updatePhones(Request $request , Admin $admin ){
            $request->validate([
                'phones'    => 'required|array|min:1|max:10',
            ]);
            // return $this->successResponse($request->all());
            // validate phones
            if(!checkPhones($request->phones))
                return $this->errorResponse(trans('user.error_phone'));
            foreach($request->phones as $phone):
                if($check = Phone::where('user_id' , '!=' , $admin->id)->where('number' , $phone['number'])->first() ){
                    return $this->errorResponse(trans('user.error_phone'));
                }
            endforeach;
            // delete old phones and then stored
            $admin->phones()->delete();
            
            foreach($request->phones as $phone):
                Phone::create([
                    'user_id' => $admin->id,
                    'number'    => $phone['number'],
                    'primary'   => $phone['primary']
                ]);    
            endforeach;

            $activity = new Activity([
                'type'  => 'edit',
                'description'       => trans('activity.edit_phone' , ['user' => $admin->name]),
                'user_id'   => $this->user->id,
                'related_id'        => $admin->id
            ]);

            $admin->activities()->save($activity);

            return $this->successResponse([
                'success'           => true,
                'message'   => trans('activity.edit_phone' , ['user' => $admin->name]),
                'data'  => $admin->phones
            ]);
        }
}
