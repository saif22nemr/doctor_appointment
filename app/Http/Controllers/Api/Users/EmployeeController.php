<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends ApiController
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
        $users = User::where('group' , 2) ;
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
            'email' => 'email',
            'branch_id' => 'required|integer',
            'password'  => 'required|min:4|max:50',
            'phones'    => 'required|array|min:1|max:10',
        ]);
        if($request->has('branch_id') and !$branch = Branch::find($request->branch_id)){
            return $this->errorResponse(trans('app.error_branch_not_found'));
        }
        if(!checkPhones($request->phones))
            return $this->errorResponse(trans('user.error_phone'));
            // return $this->errorResponse(['test' => $request->phones[0]]);
        $data = $request->only([
            'username'  ,'name' ,'email'  , 'branch_id'
        ]);
        $data['password'] = Hash::make($request->password);
        $data['group'] = 2;
        $data['status'] = 1;
        $employee = Employee::create($data);
        // store phones number
        $count = 0;
        foreach($request->phones as $phone):
            $data = [
                'user_id' => $employee->id,
                'number' => $phone['number'],
                'primary'   => $phone['primary']
            ];
            Phone::create($data);
            $count++;
        endforeach;

        // store activity
        $activity = new Activity([
            'description'   => trans('activity.create_employee' , ['user' => $employee->name]),
            'type' => 'create', 
            'user_id' => $this->user->id,
            'related_id' => $employee->id,
            
        ]);
        $employee->activities()->save($activity);
        $employee->phones = Phone::where('user_id' , $employee->id)->get();
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.create_successfully'),
            'data' => $employee
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        
        $employee->phones;
        return $this->showOne($employee);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
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
        if($request->has('branch_id') and !$branch = Branch::find($request->branch_id)){
            return $this->errorResponse(trans('app.error_branch_not_found'));
        }
        // check username
        if($request->has('username') and $user = User::where('id' , '!=' , $employee->id)->where('username' , $request->username)->first())
            return $this->errorResponse(trans('user.error_username_unique'));
        if($request->has('phones') and !checkPhones($request->phones))
            return $this->errorResponse(trans('user.error_phone'));
      
        $data = $request->only([
            'username'  ,'name' ,'email'  , 'status' , 'branch_id'
        ]);
        if($request->has('password')){
            $data['password'] = Hash::make($request->password);
        }
        $employee->fill($data);
        $employee->save();
        if($request->has('phones')):
            Phone::where('user_id' , $employee->id)->delete();
            // store phones number
            foreach($request->phones as $phone):
                $data = [
                    'user_id' => $employee->id,
                    'number' => $phone['number'],
                    'primary'   => $phone['primary']
                ];
                Phone::create($data);
            endforeach;
        endif;

        // store activity
        $activity = new Activity([
            'description'   => trans('activity.edit_employee' , ['employee' => $employee->name]),
            'type' => 'edit', 
            'user_id' => $this->user->id,
            'related_id' => $employee->id,
            
        ]);
        $employee->activities()->save($activity);
        $employee->phones = Phone::where('user_id' , $employee->id)->get();
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.edit_successfully'),
            'data' => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $activity = new Activity([
            'description'   => trans('activity.delete_employee' , ['employee' => $employee->name]),
            'type' => 'delete', 
            'user_id' => $this->user->id,
            'related_id' => $employee->id,
            
        ]);
        $employee->activities()->save($activity);
        $employee->delete();
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.delete_successfully'),
            'data' => $employee
        ]);
    }

       /**
         * 
         *  update phones for employee
         * 
         */
        
        public function updatePhones(Request $request , Employee $employee ){
            $request->validate([
                'phones'    => 'required|array|min:1|max:10',
            ]);
            // return $this->successResponse($request->all());
            // validate phones
            if(!checkPhones($request->phones))
                return $this->errorResponse(trans('user.error_phone '));
            foreach($request->phones as $phone):
                if($check = Phone::where('user_id' , '!=' , $employee->id)->where('number' , $phone['number'])->first() ){
                    return $this->errorResponse(trans('user.error_phone '));
                }
            endforeach;
            // delete old phones and then stored
            $employee->phones()->delete();
            
            foreach($request->phones as $phone):
                Phone::create([
                    'user_id' => $employee->id,
                    'number'    => $phone['number'],
                    'primary'   => $phone['primary']
                ]);    
            endforeach;

            $activity = new Activity([
                'type'  => 'edit',
                'description'       => trans('activity.edit_phone' , ['user' => $employee->name]),
                'user_id'   => $this->user->id,
                'related_id'        => $employee->id
            ]);

            $employee->activities()->save($activity);

            return $this->successResponse([
                'success'           => true,
                'message'   => trans('activity.edit_phone' , ['user' => $employee->name]),
                'data'  => $employee->phones
            ]);
        }
}
