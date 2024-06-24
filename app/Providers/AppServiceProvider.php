<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Providers\SocialiteBingWAYFProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $socialite = $this->app->make(Socialite::class);
 
        $socialite->extend('bingwayf', function () use ($socialite) {
            $config = config('services.bingwayf');
            return $socialite->buildProvider(SocialiteBingWAYFProvider::class, $config);
        });
    }
}
