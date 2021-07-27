<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index(){
        $count = [
            'appointment' => [
                'wait' => [
                    'count' => Appointment::where('status' , 1)->count(),
                    'link'  => route('appointment.index') . '?status=pending',
                ],
                'complete' => [
                    'count' => Appointment::where('status' , 2)->count(),
                    'link'  => route('appointment.index') . '?status=finished',
                ],
                'wait_today'    => [
                    'count' => Appointment::where('status' , 1)->where('date' , date('Y-m-d'))->count(),
                    'link'  => route('appointment.index') . '?status=pending&search_type=today',
                ],
                'all' => [
                    'count' => Appointment::count(),
                    'link'  => route('appointment.index') ,
                ],
            ],

            'patient' => [
                'count' => Patient::count(),
                'link' => route('patient.index')
            ],
            'admin' => [
                'count' => User::where('group' , 1)->count(),
                'link' => route('admin.index')
            ],
            'employee' => [
                'count' => User::where('group' , 2)->count(),
                'link' => route('employee.index')
            ],
            'branch'    => [
                'count' => Branch::count(),
                'link'  => route('branch.index')
            ],
        ];
        // return $count;
        return view('admin.dashboard' , compact('count'));
    }
}
