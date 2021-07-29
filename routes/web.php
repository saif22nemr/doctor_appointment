<?php

use App\Http\Controllers\Api\AppointmentCommentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\EmployeeController;
use App\Http\Controllers\User\PatientController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Dashboard ******************************************************************
Route::get('dashboard/login' , [LoginController::class , 'login'])->name('dashboard.login');
Route::post('dashboard/login' , [LoginController::class , 'login']);
Route::get('dashboard/forget_password' , [LoginController::class , 'forgetPasswordGet'])->name('dashboard.forget_password');
Route::post('dashboard/forget_password' , [LoginController::class , 'forgetPasswordPost']);
Route::get('dashboard/reset_password/{token}' , [LoginController::class , 'resetPasswordGet'])->name('dashboard.reset_password');
Route::post('dashboard/reset_password/{token}' , [LoginController::class , 'resetPasswordPost']);
Route::get('dashboard', [DashboardController::class , 'index'])->name('dashboard.index');
Route::group(['prefix' => 'dashboard' , 'middleware' => ['auth' , 'route_permission'] ] , function (){
    // Route::get('test' , [TestController::class , 'index']);
    
    Route::get('logout' , [LoginController::class , 'logout'])->name('dashboard.logout');

    Route::resource('profile' , ProfileController::class , ['as' => 'dashboard'])->only(['index']);
    Route::get('profile/edit' , [ProfileController::class , 'edit'])->name('dashboard.profile.edit');
    
    // Admin
    Route::resource('admin' , AdminController::class)->except(['store' , 'update' , 'destory' ]);
    // Employee
    Route::resource('employee' , EmployeeController::class)->except(['store' , 'update' , 'destory' ]);
    // Patient
    Route::resource('patient' , PatientController::class)->except(['store' , 'update' , 'destory' ]);
    Route::get('patient/{patient}/application' , [PatientController::class , 'createApplication'])->name('patient.application.create');
    Route::get('patient/{patient}/application/{applicationQuestion}' , [PatientController::class , 'editApplication'])->name('patient.application.edit');
    // Branch
    Route::resource('branch' , BranchController::class)->except(['store' , 'update' , 'destory' ]);


    // Appointments 
    Route::resource('appointment' , AppointmentController::class)->except(['store' , 'update' , 'destory']);
   
    // Setting Group
    Route::group(['prefix' => 'setting'] , function(){

        // General
        Route::get('general' , [SettingController::class , 'index'])->name('setting.index');
        Route::get('application' , [ApplicationController::class , 'index'])->name('setting.application.index');
        Route::get('application/question/create' , [ApplicationController::class , 'create'])->name('setting.application.create');
        Route::get('application/question/{question}/edit' , [ApplicationController::class , 'edit'])->name('setting.application.edit');
    });
});
Route::get('/', function () {
    return redirect('dashboard');
})->name('home');

