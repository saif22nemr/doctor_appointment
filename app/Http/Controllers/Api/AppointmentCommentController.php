<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Appointment;
use App\Models\Comment;
use Illuminate\Http\Request;

class AppointmentCommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Appointment $appointment)
    {
        //
        $comments = $appointment->comments()->with('user')->orderBy('created_at' , 'desc')->get();
        return $this->showAll($comments);
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Appointment $appointment)
    {
        //
        $request->validate([
            'message' => 'required|min:1|max:1000',
        ]);

        $data = new Comment( [
            'message' => $request->message,
            'user_id' => $this->user->id
        ]);
        $appointment->comments()->save($data);
        $activity = new Activity([
            'type' => 'create',
            'description'  => trans('activity.create_comment' , ['comment' => $request->message]),
            'user_id' => $this->user->id,
        ]);
        $data->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.create_successfully'),
            'data' => $data
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment , Appointment $appointment)
    {
        if(!$appointment->comments()->contains($comment)){
            return $this->errorResponse('app.error_comment_not_found');
        }
        $comment->delete();
        $activity = new Activity([
            'type' => 'delete',
            'description'  => trans('activity.delete_comment' , ['comment' => $comment->message]),
            'user_id' => $this->user->id,
        ]);
        $comment->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.delete_successfully'),
            'data' => $comment
        ]);
    }
}
