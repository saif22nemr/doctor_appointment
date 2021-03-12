<?php

use App\Http\Controllers\TestController;
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

Route::group(['prefix' => 'dashboard' ] , function (){
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard.index');
    Route::get('test' , [TestController::class , 'index']);
    Route::get('logout' , [TestController::class , 'index'])->name('logout');
});
Route::get('/', function () {
    return redirect('dashboard');
});

