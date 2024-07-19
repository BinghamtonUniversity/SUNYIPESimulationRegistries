<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\SUNYCampusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/* User Routes */
Route::get('/users/search/{search_string?}',[UserController::class,'search']);
Route::get('/users',[UserController::class,'index']);
Route::get('/users/{user}',[UserController::class, 'show']);
Route::post('/users',[UserController::class,'create']);
Route::put('/users/{user}/permissions',[UserController::class,'update_permissions']);
Route::put('/users/{user}',[UserController::class,'update']);

/* Activity Routes */
Route::get('/activities',[ActivityController::class,'index']);
Route::get('/activities/{activity}',[ActivityController::class, 'show']);
Route::post('/activities',[ActivityController::class,'create']);
Route::put('/activities/{activity}',[ActivityController::class,'update']);
Route::delete('/activities/{activity}',[ActivityController::class,'delete']);

/* SUNY Campuses */
Route::get('/suny_campuses',[SUNYCampusController::class,'index']);
Route::get('/suny_campuses/{suny_campus}',[SUNYCampusController::class, 'show']);
Route::post('/suny_campuses',[SUNYCampusController::class,'create']);
Route::put('/suny_campuses/{suny_campus}',[SUNYCampusController::class,'update']);

/*    Site configurations routes    */
Route::get('/site_configurations',[SiteConfigurationController::class,'index']);
Route::get('/site_configurations/{site_configuration}',[SiteConfigurationController::class, 'show']);
Route::post('/site_configurations',[SiteConfigurationController::class,'create']);
Route::put('/site_configurations/{site_configuration}',[SiteConfigurationController::class,'update']);

/*    File routes    */
Route::get('/files',[FileController::class,'index']);
Route::get('/files/{file}',[FileController::class, 'show']);
Route::post('/files',[FileController::class,'create']);
Route::put('/files/{file}',[FileController::class,'update']);
Route::delete('/files/{file}',[FileController::class,'delete']);

