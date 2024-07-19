<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',[AdminController::class,'admin'])->name('admin');
Route::get('/users',[AdminController::class,'users']);
Route::get('/activities',[AdminController::class,'activities']);
Route::get('/suny_campuses',[AdminController::class,'suny_campuses']);
Route::get('/site_configurations',[AdminController::class,'site_configurations']);
