<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::with('user.phones')->get()->map(function($patient){
            $patient->age = calucAge($patient->birthday);
            return $patient;
        });
        
        return view('admin.user.patient_list' , compact('patients'));
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
        return view('admin.user.patient_form' , compact('action'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Patient $patient)
    {
        $tabList = ['application' , 'activity' , 'comment'];
        if($request->has('tab') and isset($tabList[$request->tab])){
            $tab = $request->tab;
        }else{
            $tab = 'application';
        }
        $patient->user->phones;
        return view('admin.user.patient_view' , compact('patient' , 'tab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $action = 'edit';
        return view('admin.user.patient_form' , compact('action' , 'patient'));
    }

  
}
