<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index(){
        return redirect(route('admin.index'));
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'create';
        $group = 2;
        return view('admin.user.employee_form' , compact('action' , 'group'));
    }

   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Employee $employee)
    {
        $employee->phones;
        $employee->userPermissions = $employee->userPermissions()->with('permission')->get();
        $userPermissions = [];
        foreach($employee->userPermissions as $permission){
            $userPermissions[$permission->permission_id] = [
                'create'    => $permission->create,
                'edit'    => $permission->edit,
                'view'    => $permission->view,
                'delete'    => $permission->delete,
            ];
        }
        $permissions = Permission::all();
        $employee->activities = Activity::where('user_id' , $employee->id)->get();
        $tab = $request->has('tab') ? $request->tab : 'activities';
        return view('admin.user.employee_view' , compact('employee' , 'tab' , 'permissions' , 'userPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        // $admin = $employee;
        $action = 'edit';
        $employee->phones;
        $group = 2;
        return view('admin.user.employee_form'  , compact('action' , 'employee' , 'group'));
    }

  
}
