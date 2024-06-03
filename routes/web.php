<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('admin.admin',[
//        'title'=>'Home'
//    ]);
//});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/',[AdminController::class,'admin']);
    Route::get('/users',[AdminController::class,'admin']);
});


Route::group(['prefix' => 'api'], function () {
    /* User Routes */
    Route::get('/users',[UserController::class,'index']);
    Route::get('/users/{user}',[UserController::class, 'show']);
    Route::post('/users',[UserController::class,'create']);
    Route::put('/users/{user}',[UserController::class,'update']);
});
