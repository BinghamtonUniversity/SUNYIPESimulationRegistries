<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\SUNYCampusController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
 
Route::get('/login', function () {
    return redirect('/auth/redirect');
})->name('login');

Route::prefix('auth')->group(function () {
    Route::get('redirect', function () {
        return Socialite::driver('bingwayf')->redirect();
    });
    Route::get('callback', function () {
        $bingwayfuser = Socialite::driver('bingwayf')->stateless()->user();
        $user = User::where('email',$bingwayfuser->user['email'])->first();
        if (is_null($user)) {
            return response('Permission Deined',301);
        }
        Auth::login($user);
        return redirect(route('home'));
    });
});

Route::middleware(['web','auth','auth.session'])->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return ("You are logged out!");
    });
    
    Route::get('/', [PagesController::class,'home']);
    Route::get('/home',[PagesController::class,'home'])->name('home');

    // IPEs
    Route::get('/ipes/{ipe}',[PagesController::class,'ipe']);
    Route::get('/ipes',[PagesController::class,'ipes']);

    // Simulations
    Route::get('/simulations/{simulation}',[PagesController::class,'simulation']);
    Route::get('/simulations',[PagesController::class,'simulations']);
});