<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\SimulationController;
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

