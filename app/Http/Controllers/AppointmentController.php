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
        return $this->employeePermission('appointment' , 'view');
        //
        $status = $request->has('status') ? $request->status : 'all';
        $mystatus = -1;
        if($request->has('status')){
            if($request->status == 'pending') $mystatus = 1;
            elseif($request->status == 'finished') $mystatus = 2;
            elseif($request->status == 'canceled') $mystatus = 0;
            elseif($request->status == 'appointment_request') $mystatus = 3;
        }

        if($mystatus != -1){
            $appointments = Appointment::where('status' , $mystatus)->with('patient.user')->get();
        }else{
            $appointments = Appointment::with('patient.user' )->get();
        }
        // return $appointments;

        $today = $request->has('search_type') ? ($request->search_type == 'today' ? true : false ): false;
        return view('admin.appointment.appointment_list' ,compact('status' , 'appointments' , 'today')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->employeePermission('appointment' , 'create');
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
        return $this->employeePermission('appointment' , 'view');
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
        return $this->employeePermission('appointment' , 'edit');
        $action = 'edit';
        $patients = Patient::leftJoin('users' , 'patients.user_id' , 'users.id')->select('patients.*','users.name')->orderBy('users.name' , 'asc')->get();
        $branches = Branch::orderBy('position' , 'asc')->get();
        
        return view('admin.appointment.appointment_form' , compact('action' , 'branches' , 'patients' , 'appointment'));
    }

}
