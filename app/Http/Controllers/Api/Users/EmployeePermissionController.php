<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Http\Request;

class EmployeePermissionController extends ApiController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        $permissions = $employee->userPermissions()->with('permission')->get();
        return $this->showAll($permissions);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee )
    {
        /**
         * Example:  $permissions[] = [create: 1, view : 0 : delete:1 , edit: 1]
         */
        $request->validate([
            'permissions' => 'required|array|min:1'
        ]);
        // validate permissions
        $permissions = [];
        foreach($request->permissions as $permissionId => $value):
            // validate permission is exist
            if(!is_numeric($permissionId) or !$permission = Permission::find($permissionId)):
                return $this->errorResponse(trans('user.error_permission'));
            endif;
            $permissions[$permissionId] = [];
            $permissions[$permissionId]['user_id'] = $employee->id;
            $permissions[$permissionId]['permission_id']    = $permissionId;
            if(isset($value['create']) and $value['create'] == 1) $permissions[$permissionId]['create'] = 1;
            if(isset($value['edit']) and $value['edit'] == 1) $permissions[$permissionId]['edit'] = 1;
            if(isset($value['view']) and $value['view'] == 1) $permissions[$permissionId]['view'] = 1;
            if(isset($value['delete']) and $value['delete'] == 1) $permissions[$permissionId]['delete'] = 1;
            
        endforeach;
        // delete old permission for this user
        UserPermission::where('user_id' , $employee->id)->delete();
        // store new one
        // return $this->errorResponse($permissions);
        foreach($permissions as $index => $data):
            UserPermission::create($data);
        endforeach;

        $employee->userPermissions = $employee->userPermissions()->with('permission')->get();

        $activity = new Activity([
            'type' => 'edit',
            'description'   => trans('activity.edit_permission' , ['user' => $employee->name]),
            'user_id'   => $this->user->id,
            'related_id'    => $employee->id
        ]);

        $employee->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'       => trans('activity.edit_permission' , ['user' => $employee->name]),
            'data'  => $employee
        ]);
    }

}
