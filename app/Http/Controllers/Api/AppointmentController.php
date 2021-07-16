<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = -1;
        $request->validate([
            'id' => 'integer',
            'title' => 'string|min:1|max:190',
            'sort' => 'in:id,title,create_at,updated_at,status,patient_status',
            'order' => 'in:desc,asc',
        ]);
        if($request->has('status')){
            if($request->status == 'pending') $status = 1;
            elseif($request->status == 'finished') $status = 2;
            elseif($request->status == 'canceled') $status = 0;
            elseif($request->status == 'appointment_request') $status = 3;
        }
        $datatable = $request->has('datatable') and $request->datatable == 1 ? true : false;
        // check if there wanted as datatable
        
        $appointments = Appointment::where('id' , '!=' , 0);
        if($request->has('id')){
            $appointments = $appointments->where('id' , $request->id);
        }elseif($request->has('title')){
            $appointments = $appointments->where('title' , 'LIKE' , '%'.$request->title.'%');
        }
        $sort = $request->has('sort') ? $request->sort : 'created_at';
        $order = $request->has('order') ? $request->order : 'desc';
        if($status != -1){
            $appointments = $appointments->where('status' , $status);
        }
        
        $appointments = $appointments->with('patient.user' , 'branch')->orderBy($sort , $order)->get()->map(function($item)use($datatable){
            if($datatable){
                $item->patient_tag = '<a href="'.route('patient.show' , $item->patient_id).'">'.$item->patient->user->name.'</a>';
                $item->title_tag = '<a href="'.route('appointment.show' , $item->id).'">'.$item->title.'</a>';
                $item->time_tag = date('h:i A' , strtotime($item->time));
                
                if($item->status == 1) $item->status_tag = '<span class="badge badge-primary">'.trans('appointment.pending').'</span>';
                elseif($item->status == 2) $item->status_tag = '<span class="badge badge-success">'.trans('appointment.finished').'</span>';
                elseif($item->status == 3) $item->status_tag = '<span class="badge badge-warning">'.trans('appointment.appointment_request').'</span>';
                else $item->status_tag = '<span class="badge badge-danger">'.trans('appointment.canceled').'</span>';
                

                // action button
                $item->action = '<div class="dropdown show d-inline-block widget-dropdown" id="'.$item->id.'"><a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a><ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1"><li class="dropdown-item"><a href="'.route('appointment.edit' , $item->id).'">'.trans("app.edit").'</a></li><li class="dropdown-item"><a href="javascript::void(0)" class="delete-item" data-toggle="modal" data-target="#exampleModal" data-id="'.$item->id.'" >'.trans("app.delete").'</a></li></ul></div>';

            }
            
            $item->created_date = [
                'string' => Carbon::createFromTimestamp(strtotime($item->created_at))->format('Y-m-d h:i A'),
                'timestamp' => strtotime($item->created_at)
            ];
            return $item;
        });
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
        
        $request->validate([
            'patient_id' => ['required', 'integer' , Rule::in(Patient::all()->pluck('id'))],
            'title' => 'string|nullable|min:1|max:190',
            'note' => 'string|nullable|min:1|max:10000',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'status' => 'required|in:1,2,0',
            'branch_id' => [ 'required' , 'integer' , Rule::in(Branch::all()->pluck('id'))],
            'patient_status' => 'required|in:0,1',
            
            'appointment_id' => ['integer'  ]
        ]);

        if( $request->patient_status == 1){
            if(!$request->has('appointment_id') or !$followAppointment = Appointment::where('patient_id' , $request->patient_id)->where('status' , 2)->where('id' , $request->appointment_id)->first()){
                return $this->errorResponse(trans('appointment.error_appointment_not_found'));
            }
        }
        $data = $request->only([
            'title' , 'note' ,'date' , 'time' ,'patient_id' , 'patient_status' , 'status' , 'branch_id'
        ]);
        if($request->patient_status == 1){
            $data['appointment_id'] = $request->appointment_id;
        }
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
        $appointment->patient;
        $appointment->branch;
        $appointment->followAppointment;
        return $this->showOne($appointment);
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
        // return $this->errorResponse($request->all());
        $request->validate([
            // 'patient_id' => [ 'integer' , Rule::in(Patient::all()->pluck('id')) , 'not_in:'.$appointment->patient_id],
            'title' => 'string|nullable|min:1|max:190',
            'note' => 'string|nullable|min:1|max:10000',
            'date' => 'date',
            'time' => 'date_format:H:i:s',
            'status' => 'in:1,2,0',
            'branch_id' => [ 'integer' , Rule::in(Branch::all()->pluck('id'))],
            'patient_status' => 'in:0,1',
            
            'appointment_id' => ['integer' , Rule::in(Appointment::where('patient_status' , 0)->get()->pluck('id'))]
        ]);
        // return $this->errorResponse($request->all());
   
        if($request->has('patient_status') and $request->patient_status == 1){
            if(!$request->has('appointment_id') or !$followAppointment = Appointment::where('patient_id' , $appointment->patient_id)->where('id' , $request->appointment_id)->where('status' , 2)->first()){
                return $this->errorResponse(trans('appointment.error_appointment'));
            }
        }
        $data = $request->only([
            'title' , 'note' ,'date' , 'time'  , 'patient_status' , 'status' , 'branch_id'
        ]);
        if($request->patient_status == 1){
            $data['appointment_id'] = $request->appointment_id;
        }
        $appointment->update($data);
        $patient = $appointment->patient;
        $activity = new Activity([
            'type' => 'edit',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.edit_appointment' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            'branch_id' => $patient->user->branch_id,
        ]);
        $appointment->activities()->save($activity);
        return $this->successMessage(trans('app.edit_successfully'));
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
        $patient = $appointment->patient;
        $appointment->delete();
        $activity = new Activity([
            'type' => 'delete',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.delete_appointment' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            // 'branch_id' => $patient->user->branch_id,
        ]);
        $appointment->activities()->save($activity);
        return $this->successMessage(trans('app.delete_successfully'));
    }
}
