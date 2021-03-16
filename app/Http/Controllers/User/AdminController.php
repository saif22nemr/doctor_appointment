<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::whereIn('group' , [1,2])->get();
        return view('admin.user.admin_list' , compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $action = 'create';
        $branches = Branch::orderBy('name' , 'asc')->get();
        return view('admin.user.admin_form' , compact('action' , 'branches'));
    }

  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Admin $admin)
    {
        $admin->phones;
        $tab = $request->has('tab') ? $request->tab : 'activities';
        $admin->activities = Activity::where('user_id' , $admin->id)->orderBy('created_at' , 'desc') ->get();
        return view('admin.user.admin_view' , compact('admin' , 'tab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $action = 'edit';
        $admin->phones;
        $branches = Branch::orderBy('name' , 'asc')->get();
        $group = 1;
        return view('admin.user.admin_form'  , compact('action' , 'admin' , 'group' ,'branches'));
    }

}
