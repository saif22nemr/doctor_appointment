<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Choose;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'question'  => 'min:1',
        ]);
        if($request->has('question')){
            $questions = Question::where('question' , 'LIKE' ,'%'.$request->question.'%');
        }
        else{
            $questions = Question::where('id' , '!=' , 0);
        }
        $questions = $questions->orderBy('created_at' , 'asc')->with('chooses')->get();

        return $this->showAll($questions);
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
            'question'         => 'required|min:1|max:1000',
            'reason'            => 'min:1,0',
            'is_many'            => 'min:1,0',
            'answer_type'      => 'required|in:checkbox,selectbox,text,textarea',
            
        ]);

        $type = ['checkbox'  => 2, 'text' => 1 , 'selectbox' => 3 , 'textarea' => 4];
        // validate data;
        if($request->answer_type == 'checkbox' or $request->answer_type == 'selectbox'){
            $request->validate([
                'chooses' => 'required|array|min:2'
            ]);
            $reason = $request->has('reason') ? $request->reason : 0;
            $isMany = $request->has('is_many') ? $request->is_many : 0;
            if(!$request->has('chooses')){
                foreach($request->chooses as $choose){
                    if(mb_strlen($choose , 'utf8') < 2){
                        return $this->errorResponse(trans('application.error_choose'));
                    }
                }
            }
        }else{
            $reason = 0;
            $isMany = 0;
        }

        // store
        $data = $request->only([
            'question' 
        ]);
        $data['answer_type']  = $type[$request->answer_type];
        $data['reason'] = $reason ;
        $data['is_many'] = $isMany;
        $question = Question::create($data);
        if($request->answer_type == 'checkbox' or $request->answer_type == 'selectbox'){
            foreach($request->chooses as $value){
                Choose::create([
                    'question_id' =>$question->id,
                    'choose' => $value
                ]);
            }
        }
        $activity = new Activity([
            'type' => 'create',
            'description' => trans('activity.create_question'),
            'user_id'   => $this->user->id,
            'related_id'    => $question->id
        ]);
        $question->chooses ;
        $question->activities()->save($activity);
        return $this->successResponse([
            'success'     => true,
            'message'   => trans('app.create_successfully'),
            'data' => $question
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->chooses;
        return $this->showOne($question);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question'         => 'min:1|max:1000',
            'reason'            => 'min:1,0',
            'is_many'            => 'min:1,0',
            'chooses'       => 'array|min:2'
        ]);
        if($request->has('question')){
            $question->question = $request->question;
        }
        $type = ['checkbox'  => 2, 'text' => 1 , 'selectbox' => 3 , 'textarea' => 4];
        // validate data;
        if($request->answer_type == 'checkbox' or $request->answer_type == 'selectbox'){
            if($request->has('reason'))
                $question->reason = $request->reason;
            if($request->has('is_many'))
                $question->is_many = $request->is_many;
            if($request->has('chooses')){
                foreach($request->chooses as $choose){
                    if(mb_strlen($choose , 'utf8') < 2){
                        return $this->errorResponse(trans('application.error_choose'));
                    }
                }
            }else{
                return $this->errorResponse(trans('application.error_choose'));
            }
        }

        // store
       
       
        $question->save();
        if($request->has('chooses')){
            $question->chooses()->delete();
            if($request->answer_type == 'checkbox' or $request->answer_type == 'selectbox'){
                foreach($request->chooses as $value){
                    Choose::create([
                        'question_id' =>$question->id,
                        'choose' => $value
                    ]);
                }
            }
        }
        
        $activity = new Activity([
            'type' => 'edit',
            'description' => trans('activity.edit_question'),
            'user_id'   => $this->user->id,
            'related_id'    => $question->id
        ]);
        $question->chooses ;
        $question->activities()->save($activity);
        return $this->successResponse([
            'success'     => true,
            'message'   => trans('app.edit_successfully'),
            'data' => $question
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        $activity = new Activity([
            'type' => 'delete',
            'description' => trans('activity.delete_question'),
            'user_id'   => $this->user->id,
            'related_id'    => $question->id
        ]);
        $question->chooses ;
        $question->activities()->save($activity);
        
        return $this->successResponse([
            'success'     => true,
            'message'   => trans('app.delete_successfully'),
            'data' => $question
        ]);
    }
}
