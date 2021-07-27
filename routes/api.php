<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AppointmentCommentController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\Users\AdminController;
use App\Http\Controllers\Api\Users\EmployeeController;
use App\Http\Controllers\Api\Users\EmployeePermissionController;
use App\Http\Controllers\Api\Users\PatientCommentController;
use App\Http\Controllers\Api\Users\PatientController;
use App\Http\Controllers\Api\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'middleware' => 'api'] , function(){
    Route::post('login' , [LoginController::class , 'login'])->name('api.login');
});
Route::group(['middleware' => 'auth:api'] , function(){

    
   Route::get('user' , [UserController::class , 'index'])->name('api.user.index');
    // Admin
    Route::resource('admin', AdminController::class , ['as' => 'api'])->except(['create' , 'edit' ]);
    Route::post('admin/{admin}/phone' , [AdminController::class , 'updatePhones'])->name('api.admin.phone.update');
    // Employee
    Route::resource('employee', EmployeeController::class , ['as' => 'api'])->except(['create' , 'edit' ]);
    Route::post('employee/{employee}/phone' , [EmployeeController::class , 'updatePhones'])->name('api.employee.phone.update');
    Route::get('employee/{employee}/permission' , [EmployeePermissionController::class , 'index'])->name('api.employee.permission.index');
    Route::post('employee/{employee}/permission' , [EmployeePermissionController::class , 'update'])->name('api.employee.permission.update');
    // Patient
    Route::resource('patient', PatientController::class , ['as' => 'api'])->except(['create' , 'edit' ]);
    Route::post('patient/{patient}/phone' , [PatientController::class , 'updatePhones'])->name('api.patient.phone.update');
    Route::resource('patient.comment', PatientCommentController::class , ['as' => 'api'])->only(['index' , 'store' , 'destroy' ]);
    Route::resource('patient.application', ApplicationController::class , ['as' => 'api'])->only(['index' , 'store' ,'update' ]);
    Route::delete('patient/{patient}/application',[ ApplicationController::class , 'destroy'])->name('api.patient.application.destroy');

    Route::patch('profile' , [ProfileController::class , 'update'])->name('api.profile.update');
    // Branch
    Route::resource('branch' , BranchController::class, ['as' => 'api'])->except(['create' , 'edit']);
    Route::get('branch/{branch}/employee' , [BranchController::class , 'getStuff'])->name('api.branch.employee');
    Route::get('branch/{branch}/patient' , [BranchController::class , 'getPatient'])->name('api.branch.patient');
    Route::get('branch/{branch}/appointment' , [BranchController::class , 'getAppointment'])->name('api.branch.appointment');

    // Appointment
    Route::resource('appointment' ,AppointmentController::class , ['as' => 'api'])->except(['create' , 'edit']);
    Route::resource('appointment.comment' , AppointmentCommentController::class , ['as' => 'api'])->only(['store' , 'index' , 'destory']);

    // Application
    Route::resource('application/question' , QuestionController::class, ['as' => 'api'])->except(['create' , 'edit']);
    // Setting
    Route::post('setting' , [SettingController::class , 'update'] )->name('api.setting.update');
    Route::get('setting' , [SettingController::class , 'index'] )->name('api.setting.index');
});
