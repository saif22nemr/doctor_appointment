<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $appointments = Appointment::all();

        return $this->showAll($appointments);
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
            'title' => 'string|nullable|min:1|max:190',
            'note' => 'string|nullable|min:1|max:10000',
            'date' => 'required|date',
            'hour' => 'required|time',
            'status' => 'required|in:1,2,0',
            'branch_id' => ['required' , 'integer' , Rule::in(Branch::all()->pluck('id'))],
            'patient_status' => 'required|in:1.2',
            'patient_id' => ['required' , Rule::in(Patient::all()->pluck('id'))],
            'appointment_id' => ['required_if:patient_status,2' , Rule::in(Appointment::where('patient_status' , 2)->get()->pluck('id'))]
        ]);

        if($request->has('appointment_id')){
            if(!$followAppointment = Appointment::where('patient_id' , $request->patient_id)->where('id' , $request->appointment_id)->first()){
                return $this->errorResponse(trans('appointment.error_appointment_not_found'));
            }
        }
        $data = $request->only([
            'title' , 'note' ,'date' , 'hour' ,'patient_id' , 'patient_status' , 'status' ,'appointment_id' , 'branch_id'
        ]);
        $appointment = Appointment::create($data);
        $patient = Patient::find($request->patient_id);
        $activity = new Activity([
            'type' => 'create',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.create_appointment' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            'branch_id' => $patient->user->branch_id,
        ]);
        $appointment->activities()->save($activity);
        return $this->successMessage(trans('app.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
        
        return $this->showOne($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
