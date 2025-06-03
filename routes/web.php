<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IPEController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// No Authentication Required!
Route::get('/', [PagesController::class,'home'])->name('home');
Route::get('/browse',[PagesController::class,'browse'])->name('browse');
Route::get('/activities/{activity}',[PagesController::class,'activity']);
Route::get('/glossary',[PagesController::class,'glossary'])->name('glossary');

Route::middleware(['web','auth','auth.session'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/',[AdminController::class,'activities'])->name('admin')->can('admin',App\Models\User::class);
        Route::get('/users',[AdminController::class,'users'])->can('admin',App\Models\User::class);
        Route::get('/activities/{activity}/logs',[AdminController::class,'activity_logs'])->can('admin',App\Models\User::class);
        Route::get('/activities',[AdminController::class,'activities'])->can('admin',App\Models\User::class);
        Route::get('/types',[AdminController::class,'types'])->can('admin',App\Models\User::class);
        Route::get('/types/{type}/values',[AdminController::class,'values'])->can('admin',App\Models\User::class);
        Route::get('/campuses',[AdminController::class,'campuses'])->can('admin',App\Models\User::class);
        Route::get('/site_configurations',[AdminController::class,'site_configurations'])->can('admin',App\Models\User::class);
    });
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('https://bingwayf.binghamton.edu/logout');
    })->name('logout');;
    Route::get('/manage', [PagesController::class,'manage'])->name('manage');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect(route('home'));
    }
    return redirect('/auth/redirect');
})->name('login');

Route::prefix('auth')->group(function () {
    Route::get('redirect', function () {
        return Socialite::driver('bingwayf')->redirect();
    });
    Route::get('callback', function () {
        $bingwayfuser = Socialite::driver('bingwayf')->stateless()->user();
        $user = User::where('unique_id',$bingwayfuser->user['preferred_username'])->first();
        if (is_null($user)) {
            $user = new User([
                'first_name' => $bingwayfuser->user['given_name'],
                'last_name' => $bingwayfuser->user['family_name'],
                'unique_id' => $bingwayfuser->user['preferred_username'],
                'email' => $bingwayfuser->user['email'],
            ]);
            $user->save();
        }
        Auth::login($user);
        return redirect(route('home'));
    });
});

