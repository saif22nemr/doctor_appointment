<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientCommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
    {
        //
        $comments = $patient->comments()->orderBy('created_at' , 'desc')->get();
        return $this->showAll($comments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Patient $patient)
    {
        //
        $request->validate([
            'message'   => 'required|min:1|max:1500',
            // 'user_id'   => 'required|user_id',
        ]);
        $comment = new Comment([
            'message'   => $request->message,
            'user_id'   => $this->user->id
        ]);
        $patient->comments()->save($comment);

        $activity = new Activity([
            'type' => 'create',
            'description'  => trans('activity.create_comment' , ['comment' => $request->message]),
            'user_id' => $this->user->id,
            'related_id' => $patient->user_id
        ]);
        $comment->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.create_successfully'),
            'data' => $comment
        ]);
    }

  
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient, Comment $comment)
    {
        //
        if(!$check = $patient->comments()->where('id' , $comment->id)->first()){
            return $this->errorResponse(trans('app.error_comment_not_found'));
        }
        $comment->delete();
        $activity = new Activity([
            'type' => 'delete',
            'description'  => trans('activity.delete_comment' , ['comment' => $comment->message]),
            'user_id' => $this->user->id,
            'related_id' => $patient->user_id
        ]);
        $comment->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.delete_successfully'),
            'data' => $comment
        ]);
    }
}
