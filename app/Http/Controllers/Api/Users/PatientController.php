<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Patient;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends ApiController
{
    public function index(Request $request)
    {
        
        $request->validate([
            'username'          => 'min:1|max:190',
            'name'                  => 'min:1|max:190',
            'phone'                 => 'digit',
            // 'group'                 => 'in:1,2,3,4',
            'sort'                     => 'in:username,name,created_at,updated_at,id',
            'order'                 => 'in:desc,asc',
        ]);
        $users = User::where('group' , 3) ;
        if($request->has('phone')){
            $users  = Phone::where('number' , 'LIKE' , "%".$request->phone."%");
            // $users = $users->whereIn('id' , $users);
        }if($request->has('username')){
            $users = $users->where('username'  , 'LIKE' , "%".$request->username."%");
        }if($request->has('name')){
            $users = $users->where('name'  , 'LIKE' , "%".$request->name."%");
        }
       
        $sort = $request->has('sort') ? $request->sort : 'name';
        $order = $request->has('order') ? $request->order : 'asc';
        $usersId = $users->with('phones')->orderBy($sort , $order)->get()->pluck('id');
        $patients = Patient::whereIn('user_id' , $usersId)->with('user.phones')->get();
        return $this->showAll($patients);
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
            // return $this->errorResponse($request->all());
            $request->validate([
                // 'username'  => 'required|min:4|max:190|unique:users',
                'name' => 'required|min:3|max:190',
                'email' => 'email|unique:users',
                'birthday'      => 'required|date',
                'sex'   => 'required|in:male,female',
                'nationality'      => 'required|min:1|max:190',
                'job'      => 'required|min:1|max:190',
                'address'      => 'required|min:1|max:2000',
                'social_status' => 'required|in:single,married',
                'password'  => 'required|min:4|max:50',
                'phones'    => 'required|array|min:1|max:10',
            ]);
            
            if($request->has('phones') and !checkPhones($request->phones))
                return $this->errorResponse(trans('user.error_phone'));
            else{
                foreach($request->phones as $key => $phone):
                    if($check = Phone::where('number'  , $phone['number'])->first())
                        return $this->errorResponse(trans('user.error_phone_unique'));
                endforeach;
            }
                // return $this->errorResponse(['test' => $request->phones[0]]);
            $data = $request->only([
                  'name' ,'email'  
            ]);
            $data['password'] = Hash::make($request->password);
            $data['group'] = 3;
            $data['status'] = 1;
            $user = User::create($data);
            $dataPatient = $request->only([
                'birthday'  ,'job' ,'address' ,'nationality' 
            ]);
            $dataPatient['sex'] = $request->sex == 'male' ? 1 : 0;
            $dataPatient['social_status'] = $request->sex == 'single' ? 0 : 1;
            $dataPatient['user_id'] = $user->id;
            $patient = Patient::create($dataPatient);
            // store phones number
            $count = 0;
            foreach($request->phones as $phone):
                $data = [
                    'user_id' => $user->id,
                    'number' => $phone['number'],
                    'primary'   => $phone['primary']
                ];
                Phone::create($data);
                $count++;
            endforeach;
    
            // store activity
            $activity = new Activity([
                'description'   => trans('activity.create_patient' , ['patient' => $user->name]),
                'type' => 'create', 
                'user_id' => $this->user->id,
                'related_id' => $user->id,
                
            ]);
            $patient->activities()->save($activity);
            $patient->phones = Phone::where('user_id' , $user->id)->get();
            return $this->successResponse([
                'success'    => true,
                'message'   => trans('app.create_successfully'),
                'data' => $patient
            ]);
        }
    
        /**
         * Display the specified resource.
         *
         * @param  \App\Models\patient  $patient
         * @return \Illuminate\Http\Response
         */
        public function show(Patient $patient)
        {
            
            $patient->phones;
            return $this->showOne($patient);
        }
    
     
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\patient  $patient
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Patient $patient)
        {
            
            $request->validate([
                // 'username'  => 'required|min:4|max:190|unique:users',
                'name' => 'min:3|max:190',
                'email' => 'email',
                'birthday'      => 'date',
                'sex'   => 'in:male,female',
                'nationality'      => 'min:1|max:190',
                'job'      => 'min:1|max:190',
                'address'      => 'min:1|max:2000',
                'social_status' => 'in:single,married',
                'password'  => 'min:4|max:50',
                'phones'    => 'array|min:1|max:10',
            ]);
          
            // check emails
            if($request->has('email') and $check = User::where('id' , '!=' , $patient->user_id)->where('email' , $request->email)->first()){
                return $this->errorResponse(trans('user.error_email_unique'));
            }
            // check phones
            if($request->has('phones') and !checkPhones($request->phones))
                return $this->errorResponse(trans('user.error_phone'));
            elseif($request->has('phones')){
                foreach($request->phones as $key => $phone):
                    if($check = Phone::where('user_id' , '!=' , $patient->user_id)->where('number'  , $phone['number'])->first())
                        return $this->errorResponse(trans('user.error_phone_unique'));
                endforeach;
            }

          
            $data = $request->only([
                  'name' ,'email'  , 'status'
            ]);
            if($request->has('password')){
                $data['password'] = Hash::make($request->password);
            }
            $user = $patient->user;
            if(count($data) > 0){
                $user->fill($data);
                $user->save();
            }
            // update patient data
            $patientData = $request->only([
                'birthday'  , 'job' , 'address' , 'nationality' 
            ]);
            if($request->has('sex'))
                $patientData['sex'] = $request->sex == 'male' ? 1 : 0;
            if($request->has('social_status'))
                $patientData['social_status'] = $request->social_status == 'single' ? 0 : 1;
            $patient->fill($patientData);
            $patient->save();
            if($request->has('phones')):
                Phone::where('user_id' , $user->id)->delete();
                // store phones number
                foreach($request->phones as $phone):
                    $data = [
                        'user_id' => $user->id,
                        'number' => $phone['number'],
                        'primary'   => $phone['primary']
                    ];
                    Phone::create($data);
                endforeach;
            endif;
    
            // store activity
            $activity = new Activity([
                'description'   => trans('activity.edit_patient' , ['patient' => $user->name]),
                'type' => 'edit', 
                'user_id' => $this->user->id,
                'related_id' => $user->id,
                
            ]);
            $patient->activities()->save($activity);
            $patient->phones = Phone::where('user_id' , $user->id)->get();
            $patient->user;
            return $this->successResponse([
                'success'    => true,
                'message'   => trans('app.edit_successfully'),
                'data' => $patient
            ]);
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\patient  $patient
         * @return \Illuminate\Http\Response
         */
        public function destroy(patient $patient)
        {
            $activity = new Activity([
                'description'   => trans('activity.delete_patient' , ['patient' => $patient->user->name]),
                'type' => 'delete', 
                'user_id' => $this->user->id,
                'related_id' => $patient->user_id,
                
            ]);
            $patient->activities()->save($activity);
            $patient->delete();
            return $this->successResponse([
                'success'    => true,
                'message'   => trans('app.delete_successfully'),
                'data' => $patient
            ]);
        }
    
}
