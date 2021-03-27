<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ApplicationQuestion;
use App\Models\Branch;
use App\Models\Patient;
use App\Models\Question;
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
        $branchs = Branch::orderBy('name' , 'asc')->get();
        $action = 'create';
        return view('admin.user.patient_form' , compact('action' , 'branchs'));
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
        if($request->has('tab') ){
            $tab = $request->tab;
        }else{
            $tab = 'application';
        }
        $patient->user->phones;
        $patient->application = $patient->application()->with('questions.answers' , 'questions.getQuestion')->first();
        $questions = Question::with('chooses')->get();
        $patient->comments = $patient->comments()->with('user')->orderBy('created_at' , 'desc')->get();
        $patient->activities = Activity::where('related_id' , $patient->user_id)->orderBy('created_at' , 'desc')->get();
        // return $comments ;
        // return $patient->application;
        return view('admin.user.patient_view' , compact('patient' , 'tab' ,'questions'));
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
        $branchs = Branch::orderBy('name' , 'asc')->get();
        return view('admin.user.patient_form' , compact('action' , 'patient' , 'branchs'));
    }

    /**
     * Create Application To Patient.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */

     public function createApplication(Patient $patient){
         if($patient->application_id != null){
             return redirect()->intended(route('patient.show' , $patient->id));
         }
        $action = 'create';
        $questions = Question::with('chooses')->get();
        return view('admin.user.application_form' , compact('action' , 'questions' , 'patient'));
     }

     public function editApplication(Patient $patient , ApplicationQuestion $applicationQuestion){
        if($patient->application_id == null or !$question = $applicationQuestion->getQuestion){
            return redirect()->intended(route('patient.show' , $patient->id));
        }
        $action = 'edit';
        
        $questions = Question::where('id' , $question->id)->with('chooses')->get();
        
        return view('admin.user.application_form' , compact('action' , 'questions' , 'patient' , 'question' , 'applicationQuestion'));
     }
}
