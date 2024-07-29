<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',[AdminController::class,'admin'])->name('admin');
Route::get('/users',[AdminController::class,'users']);
Route::get('/activities/{activity}/logs',[AdminController::class,'activity_logs']);
Route::get('/activities',[AdminController::class,'activities']);
Route::get('/types',[AdminController::class,'types']);
Route::get('/types/{type}/values',[AdminController::class,'values']);
Route::get('/campuses',[AdminController::class,'campuses']);
Route::get('/site_configurations',[AdminController::class,'site_configurations']);
