<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\SUNYCampusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class,'home']);
Route::get('/home',[PagesController::class,'home']);

// IPEs
Route::get('/ipes/{ipe}',[PagesController::class,'ipe']);
Route::get('/ipes',[PagesController::class,'ipes']);

// Simulations
Route::get('/simulations/{simulation}',[PagesController::class,'simulation']);
Route::get('/simulations',[PagesController::class,'simulations']);
