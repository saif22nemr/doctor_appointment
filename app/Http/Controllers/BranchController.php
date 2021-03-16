<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $branches = Branch::orderBy('name' , 'asc')->get()->map(function($branch){
            $branch->countStuff = User::whereIn('group', [1,2])->where('branch_id' , $branch->id)->count();
            $branch->countPatient = User::where('group' , 3)->where('branch_id' , $branch->id)->count();
            $branch->countAppointment = Appointment::where('branch_id' , $branch->id)->count();
            return $branch;
        });
        return view('admin.branch_list' , compact('branches'));
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
        return view('admin.branch_form' , compact('action'));
    }

   
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        return view('admin.branch_view' , compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $action = 'edit';
        return view('admin.branch_form' , compact('action' , 'branch'));
    }

}
