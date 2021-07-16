<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status = $request->has('status') ? $request->status : 'all';
        return view('admin.appointment.appointment_list' ,compact('status')) ;
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
        $patients = Patient::leftJoin('users' , 'patients.user_id' , 'users.id')->select('patients.*','users.name')->orderBy('users.name' , 'asc')->get();
        $branches = Branch::orderBy('position' , 'asc')->get();
        
        return view('admin.appointment.appointment_form' , compact('action' , 'branches' , 'patients'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Appointment $appointment)
    {
        //
        $appointment->patient;
        $appointment->branch;
        $appointment->followAppointment;
        // return $appointment;
        $appointment->comments = $appointment->comments()->orderBy('created_at' , 'desc')->get();
        $tab = $request->has('tab') ? $request->tab : 'comments';
        return view('admin.appointment.appointment_view' , compact('appointment' , 'tab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $action = 'edit';
        $patients = Patient::leftJoin('users' , 'patients.user_id' , 'users.id')->select('patients.*','users.name')->orderBy('users.name' , 'asc')->get();
        $branches = Branch::orderBy('position' , 'asc')->get();
        
        return view('admin.appointment.appointment_form' , compact('action' , 'branches' , 'patients' , 'appointment'));
    }

}
