<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\EmployeeController;
use App\Http\Controllers\User\PatientController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'dashboard' , 'middleware' => 'auth' ] , function (){
    Route::get('test' , [TestController::class , 'index']);
    Route::get('/', [DashboardController::class , 'index'])->name('dashboard.index');
    Route::get('logout' , [LoginController::class , 'logout'])->name('dashboard.logout');

    // Admin
    Route::resource('admin' , AdminController::class)->except(['store' , 'update' , 'destory' ]);
    // Employee
    Route::resource('employee' , EmployeeController::class)->except(['store' , 'update' , 'destory' ]);
    // Patient
    Route::resource('patient' , PatientController::class)->except(['store' , 'update' , 'destory' ]);


    // Setting Group
    Route::group(['prefix' => 'setting'] , function(){

        // General
        Route::get('general' , [SettingController::class , 'index'])->name('setting.index');
    });
});
Route::get('/', function () {
    return redirect('dashboard');
});

