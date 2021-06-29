<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('name' , 'asc')->get();
        return $this->showAll($branches);
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
            'name'  => 'required|min:1|max:190|unique:branches',
            'address'       => 'required|min:1|max:1500',
            'position' => ['required' , 'integer' , Rule::notIn(Branch::all()->pluck('position'))],
        ]);

        $data = $request->only(['name' , 'address' , 'position']);
        $branch = Branch::create($data);

        $activity = new Activity([
            'type' => 'create',
            'description'   => trans('activity.create_branch' , ['branch' => $branch->name]),
            'user_id' => $this->user->id,
        ]);
        $branch->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.create_successfully'),
            'data' => $branch
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
        return $this->showOne($branch);
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        
        $request->validate([
            'name'  => 'min:1|max:190',
            'address'       => 'min:1|max:1500',
        ]);
        if($request->has('name') and $checkUnique = Branch::where('id' , '!=' , $branch->id)->where('name' , $request->name)->first()){
            return $this->errorResponse(trans('app.error_name_unique'));
        }
        $data = $request->only(['name' , 'address']);
        $branch->fill($data);
        $branch->save();

        $activity = new Activity([
            'type' => 'edit',
            'description'   => trans('activity.edit_branch' , ['branch' => $branch->name]),
            'user_id' => $this->user->id,
        ]);
        $branch->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.edit_successfully'),
            'data' => $branch
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $activity = new Activity([
            'type' => 'edit',
            'description'   => trans('activity.edit_branch' , ['branch' => $branch->name]),
            'user_id' => $this->user->id,
        ]);
        $branch->delete();
        $branch->activities()->save($activity);
        return $this->successResponse([
            'success'   => true,
            'message'   => trans('app.edit_successfully'),
            'data' => $branch
        ]);
    }
    // get admin and employee  that belongs to this branch
    public function getStuff(Branch $branch){
        $users = $branch->users()->whereIn('group' , [1,2])->get();
        return $this->showAll($users);
    }

    // get patients
    public function getPatient(Branch $branch){
        $users = $branch->users()->whereIn('group' , [3])->with('patient')->get();
        return $this->showAll($users);
    }

    // get appointment of this branch
    public function getAppointment(Branch $branch){
        $appointments = $branch->appointments()->orderBy('created_at' , 'desc')->get();
        return $this->showAll($appointments);
    }

}
