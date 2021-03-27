<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Application;
use App\Models\ApplicationAnswer;
use App\Models\ApplicationQuestion;
use App\Models\Choose;
use App\Models\Patient;
use App\Models\Question;
use Illuminate\Http\Request;

class ApplicationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
    {
        $application = $patient->application()->with('questions.answers')->first();
        return $this->showOne($application);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Patient $patient)
    {
        if($patient->application_id  ){
            return $this->errorResponse(trans('application.error.patient_has_application'));
        }
        $request->validate([
            'questions' =>'required|array|min:1',
        ]);

        /**
         *  $questions[id] = [
         *             'answer' => '',
         *          'chooses' => [],
         *            'reason'  => '',
         * ]
         * */

        //  validate patient id
        if($patient->user->status == 0 ){
            return $this->errorResponse(trans('appliaction.error.patient_not_active'));
        }
        $questions = [];
        // validate question
        foreach($request->questions as $id => $item):
            if(!is_numeric($id) or !$question = Question::find($id)){
                return $this->errorResponse(trans('application.error.question_not_found'));
            }
            $questions[$id] = [];
            // if question type [text or textarea]
            if(in_array($question->answer_type , [1,4])){
                if(!isset($item['answer']) or mb_strlen($item['answer'] , 'utf8')  < 1)
                    return $this->errorResponse(trans('application.error.question_answer'));
                else
                    $questions[$id]['answer'] = $item['answer'];
            }
            // check if question type [checkbox or selectbox]
            elseif(in_array($question->answer_type , [2,3]) and isset($item['chooses']) and is_array($item['chooses']) and count($item['chooses']) > 0){
                
                foreach($item['chooses'] as $key => $value):
                    if(!$choose = Choose::where('choose' , $value)->first()){
                        return $this->errorResponse(trans('application.error.choose_not_found'));
                    }
                    if($question->is_many == 1 or $key == 0){
                        $questions[$id]['chooses'][] = $value;
                    }
                endforeach;
            }
            elseif(in_array($question->answer_type , [2,3])){
                return $this->errorResponse(trans('application.error.choose_not_found'));
            }
            // check if there reason 
            // if($question->reason == 1 and (!isset($item['reason']) )){
            //     return $this->errorResponse(trans('application.error.reason_required'));
            // }elseif($question->reason == 1){
            //     $questions[$id]['reason'] = $item['reason'];
            // }
            

        endforeach;
        // create application to this 
        $application = Application::create([]);
        foreach($questions as $id => $data):
            if($question = Question::find($id)){
                $questionData = [
                    'question_id' => $id,
                    'question'  => $question->question,
                    'application_id' => $application->id,
                ];
                if($question->reason == 1 ){
                    $questionData['reason'] = isset($data['reason']) ? $data['reason'] : '';
                }
                $applicationQuestion = ApplicationQuestion::create($questionData);
                if(in_array($question->answer_type , [2,3])){
                    foreach($data['chooses'] as $value):
                        ApplicationAnswer::create([
                            'question_id' => $applicationQuestion->id,
                            'answer' => $value
                        ]);
                    endforeach;
                }
                elseif(in_array($question->answer_type , [1,4]) and isset($data['answer'])){
                    ApplicationAnswer::create([
                        'question_id' => $applicationQuestion->id,
                        'answer' => $data['answer']
                    ]);
                }
            }
            
        endforeach;
        $patient->application_id =$application->id;
        $patient->save();
        $questions = $application->questions()->with('answers')->get();
        $activity = new Activity([
            'type' => 'create',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.create_application' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            'branch_id' => $patient->user->branch_id,
        ]);
        $patient->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.create_successfully'),
            'data'  => $questions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient , ApplicationQuestion $application)
    {
        $applicationQuestion = $application;
        // validate if this question is exist to this patient
        if($patient->application_id == null or $applicationQuestion->application_id != $patient->application_id){
            return $this->errorResponse(trans('application.error.question_not_found').'llp');
        }
        $request->validate([
            'chooses'   => 'required|array|min:1',
            'reason'    => 'min:1',
        ]);
        // check if the real question is exist
        if(!$question = $applicationQuestion->getQuestion ){
            return $this->errorResponse(trans('application.error.question_not_found'));
        }
        // return $this->errorResponse($question);
        // check chooses
        if(in_array($question->answer_type , [2,3])){
            foreach($request->chooses as $key => $value):
                // return $this->errorResponse($question->chooses);
                if(!$choose = $question->chooses()->where('choose' , $value)->first()){
                    return $this->errorResponse(trans('application.error.choose_not_found') );
                }
            endforeach;
        }
        
        // check reason 
        // if($question->reason == 1 and !$request->has('reason')){
        //     return $this->errorResponse(trans('application.error.reason_required'));
        // }
        if($question->reason == 1){
            $applicationQuestion->reason = $request->has('reason') ?  $request->reason : null;
            $applicationQuestion->save();
        }

        // then you can update now
        $applicationQuestion->answers()->delete();
        foreach($request->chooses as $key => $value):
            if($question->is_many == 1 or $key == 0){
                ApplicationAnswer::create([
                    'question_id'   => $applicationQuestion->id,
                    'answer'    => $value,
                ]);
            }
        endforeach;

        $activity = new Activity([
            'type' => 'edit',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.edit_application' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            'branch_id' => $patient->user->branch_id,
        ]);
        $patient->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.edit_successfully'),
            'data'  => $applicationQuestion->with('answers')->get()
        ]);
    }

    /**
     * Remove the all question of this application to this patient
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient )
    {
        if($patient->application_id == null ){
            return $this->errorResponse(trans('application.error.application_not_found'),404);
        }
        $application = $patient->application;
        $questions = $application->questions()->with('answers')->get();
        $application->delete();
        $activity = new Activity([
            'type' => 'delete',
            'user_id'   => $this->user->id,
            'description'   => trans('activity.delete_application' , ['patient' => $patient->user->name]),
            'related_id'    => $patient->user_id,
            'branch_id' => $patient->user->branch_id,
        ]);
        $patient->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.delete_successfully'),
            'data'  => $questions
        ]);
    }
}
