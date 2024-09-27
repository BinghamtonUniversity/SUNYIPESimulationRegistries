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
Route::post('/users',[UserController::class,'store'])->middleware('can:create,App\Models\User');
Route::put('/users/{user}/permissions',[UserController::class,'update_permissions'])->middleware('can:manage_user_permissions,App\Models\User');
Route::put('/users/{user}',[UserController::class,'update'])->middleware('can:update,App\Models\User');

/* Activity Routes */
Route::get('/activities',[ActivityController::class,'index'])->middleware('can:viewAny,App\Models\Activity');
Route::get('/activities/{activity}/logs',[ActivityController::class, 'index_logs'])->middleware('can:viewLogs,activity');
Route::get('/activities/{activity}',[ActivityController::class, 'show'])->middleware('can:view,activity');
Route::post('/activities',[ActivityController::class,'store']);//->middleware('can:create,App\Models\Activity');
Route::put('/activities/{activity}',[ActivityController::class,'update']);//->middleware('can:update,activity');
Route::delete('/activities/{activity}',[ActivityController::class,'destroy']);//->middleware('can:delete,activity');
Route::get('/activities/form_fields/default',[ActivityController::class,'get_form_fields']);
Route::get('/activities/form_fields/search',[ActivityController::class,'get_search_form_fields']);

/* Campuses */
Route::get('/campuses',[CampusController::class,'index'])->middleware('can:manage,App\Models\Campus');
Route::get('/campuses/{campus}',[CampusController::class, 'show'])->middleware('can:manage,App\Models\Campus');
Route::post('/campuses',[CampusController::class,'store'])->middleware('can:manage,App\Models\Campus');
Route::put('/campuses/{campus}',[CampusController::class,'update'])->middleware('can:manage,App\Models\Campus');

/* Site configurations routes */
Route::get('/site_configurations',[SiteConfigurationController::class,'index'])->middleware('can:manage,App\Models\SiteConfiguration');
Route::get('/site_configurations/{site_configuration}',[SiteConfigurationController::class, 'show'])->middleware('can:manage,App\Models\SiteConfiguration');
Route::post('/site_configurations',[SiteConfigurationController::class,'store'])->middleware('can:manage,App\Models\SiteConfiguration');
Route::put('/site_configurations/{site_configuration}',[SiteConfigurationController::class,'update'])->middleware('can:manage,App\Models\SiteConfiguration');

/* File routes */
Route::get('/files',[FileController::class,'index']);
Route::get('/files/{file}',[FileController::class, 'show']);
Route::post('/files',[FileController::class,'create']);
Route::put('/files/{file}',[FileController::class,'update']);
Route::delete('/files/{file}',[FileController::class,'destroy']);

/* Types */
Route::get('/types',[TypeController::class,'index'])->middleware('can:view,App\Models\Type');
Route::get('/types/{type}',[TypeController::class, 'show'])->middleware('can:view,App\Models\Type');
Route::post('/types',[TypeController::class,'store'])->middleware('can:manage,App\Models\Type');
Route::put('/types/{type}',[TypeController::class,'update'])->middleware('can:manage,App\Models\Type');
Route::delete('/types/{type}',[TypeController::class,'destroy'])->middleware('can:manage,App\Models\Type');

Route::get('/types/{type}/values',[TypeController::class,'value_index'])->middleware('can:manage,App\Models\Type');
Route::get('/types/{type}/values/{value}',[TypeController::class, 'value_show'])->middleware('can:manage,App\Models\Type');
Route::post('/types/{type}/values',[TypeController::class,'value_store'])->middleware('can:manage,App\Models\Type');
Route::put('/types/{type}/values/{value}',[TypeController::class,'value_update'])->middleware('can:manage,App\Models\Type');
Route::delete('/types/{type}/values/{value}',[TypeController::class,'value_destroy'])->middleware('can:manage,App\Models\Type');

