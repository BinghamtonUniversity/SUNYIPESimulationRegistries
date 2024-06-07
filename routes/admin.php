<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\SUNYCampusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',[AdminController::class,'admin'])->name('admin');
Route::get('/users',[AdminController::class,'admin']);
Route::get('/ipes',[AdminController::class,'ipes']);
Route::get('/simulations',[AdminController::class,'simulations']);
Route::get('/suny_campuses',[AdminController::class,'suny_campuses']);
Route::get('/site_configurations',[AdminController::class,'site_configurations']);
