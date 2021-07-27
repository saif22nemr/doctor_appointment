<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->employeePermission('application' , 'view');
        //
        $questions = Question::all();
        return view('admin.setting.question_list' , compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employeePermission('application' , 'create');
        $action = 'create';
        return view('admin.setting.question_form', compact('action'));
    }

  
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->employeePermission('application' , 'edit');
        $question->chooses;
        $action = 'edit';
        return view('admin.setting.question_form', compact('action' , 'question'));
    }

    
}
