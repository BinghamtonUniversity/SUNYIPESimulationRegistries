<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;

/* User Routes */
Route::get('/users/search/{search_string?}',[UserController::class,'search'])->middleware('can:viewAny,App\Models\User');
Route::get('/users',[UserController::class,'index'])->middleware('can:view,App\Models\User');
Route::get('/users/{user}/activities',[UserController::class,'get_user_activites']);
Route::get('/users/{user}',[UserController::class, 'show'])->middleware('can:view,App\Models\User');
Route::post('/users/{user}/activities',[UserController::class,'add_user_activity']);
Route::post('/users',[UserController::class,'store'])->middleware('can:create,App\Models\User');
Route::put('/users/{user}/permissions',[UserController::class,'update_permissions'])->middleware('can:manage_user_permissions,App\Models\User');
Route::put('/users/{user}',[UserController::class,'update'])->middleware('can:update,App\Models\User');

/* Activity Routes */
Route::get('/activities',[ActivityController::class,'index']);
Route::get('/activities/{activity}/logs',[ActivityController::class, 'index_logs']);
Route::get('/activities/{activity}',[ActivityController::class, 'show']);
Route::post('/activities',[ActivityController::class,'store']);
Route::put('/activities/{activity}',[ActivityController::class,'update']);
Route::delete('/activities/{activity}',[ActivityController::class,'destroy']);

/* Campuses */
Route::get('/campuses',[CampusController::class,'index']);
Route::get('/campuses/{campus}',[CampusController::class, 'show']);
Route::post('/campuses',[CampusController::class,'store']);
Route::put('/campuses/{campus}',[CampusController::class,'update']);

/* Site configurations routes */
Route::get('/site_configurations',[SiteConfigurationController::class,'index']);
Route::get('/site_configurations/{site_configuration}',[SiteConfigurationController::class, 'show']);
Route::post('/site_configurations',[SiteConfigurationController::class,'store']);
Route::put('/site_configurations/{site_configuration}',[SiteConfigurationController::class,'update']);

/* File routes */
Route::get('/files',[FileController::class,'index']);
Route::get('/files/{file}',[FileController::class, 'show']);
Route::post('/files',[FileController::class,'create']);
Route::put('/files/{file}',[FileController::class,'update']);
Route::delete('/files/{file}',[FileController::class,'destroy']);

/* Types */
Route::get('/types',[TypeController::class,'index']);
Route::get('/types/{type}',[TypeController::class, 'show']);
Route::post('/types',[TypeController::class,'store']);
Route::put('/types/{type}',[TypeController::class,'update']);
Route::delete('/types/{type}',[TypeController::class,'destroy']);

Route::get('/types/{type}/values',[TypeController::class,'value_index']);
Route::get('/types/{type}/values/{value}',[TypeController::class, 'value_show']);
Route::post('/types/{type}/values',[TypeController::class,'value_store']);
Route::put('/types/{type}/values/{value}',[TypeController::class,'value_update']);
Route::delete('/types/{type}/values/{value}',[TypeController::class,'value_destroy']);

