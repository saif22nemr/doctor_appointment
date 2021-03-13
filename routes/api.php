<?php

use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\Users\AdminController;
use App\Http\Controllers\Api\Users\EmployeeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'] , function(){

   Route::get('user' , [UserController::class , 'index'])->name('api.user.index');
    // Admin
    Route::resource('admin', AdminController::class , ['as' => 'api'])->except(['create' , 'edit' ]);
    // Employee
    Route::resource('employee', EmployeeController::class , ['as' => 'api'])->except(['create' , 'edit' ]);
    // Patient
    Route::resource('patient', PatientController::class , ['as' => 'api'])->except(['create' , 'edit' ]);

    // Application
    Route::resource('application/question' , QuestionController::class)->except(['create' , 'edit']);
    // Setting
    Route::post('setting' , [SettingController::class , 'update'] )->name('api.setting.update');
    Route::get('setting' , [SettingController::class , 'index'] )->name('api.setting.index');
});
