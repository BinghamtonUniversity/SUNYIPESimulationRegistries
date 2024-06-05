<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('end_user.home',[
        'title'=>'Home'
    ]);
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/',[AdminController::class,'admin'])->name('admin');
    Route::get('/users',[AdminController::class,'admin']);
    Route::get('/ipes',[AdminController::class,'ipes']);
    Route::get('/simulations',[AdminController::class,'simulations']);
    Route::get('/site_configurations',[AdminController::class,'site_configurations']);
});


Route::group(['prefix' => 'api'], function () {
    /* User Routes */
    Route::get('/users/search/{search_string?}',[UserController::class,'search']);
    Route::get('/users',[UserController::class,'index']);
    Route::get('/users/{user}',[UserController::class, 'show']);
    Route::post('/users',[UserController::class,'create']);
    Route::put('/users/{user}',[UserController::class,'update']);

    /* IPE Routes */
    Route::get('/ipes',[IPEController::class,'index']);
    Route::get('/ipes/{ipe}',[IPEController::class, 'show']);
    Route::post('/ipes',[IPEController::class,'create']);
    Route::put('/ipes/{ipe}',[IPEController::class,'update']);

    /* Simulation Routes */
    Route::get('/simulations',[SimulationController::class,'index']);
    Route::get('/simulations/{simulation}',[SimulationController::class, 'show']);
    Route::post('/simulations',[SimulationController::class,'create']);
    Route::put('/simulations/{simulation}',[SimulationController::class,'update']);

    /*    Site configurations routes    */
    Route::get('/site_configurations',[SiteConfigurationController::class,'index']);
    Route::get('/site_configurations/{site_configuration}',[SiteConfigurationController::class, 'show']);
    Route::post('/site_configurations',[SiteConfigurationController::class,'create']);
    Route::put('/site_configurations/{site_configuration}',[SiteConfigurationController::class,'update']);
});
