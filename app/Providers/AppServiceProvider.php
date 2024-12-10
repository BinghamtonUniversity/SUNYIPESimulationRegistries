<?php

namespace App\Providers;

use App\Models\Activity;
use App\Observers\ActivityObserver;
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
        Activity::observe(ActivityObserver::class);
        $socialite = $this->app->make(Socialite::class);

        $socialite->extend('bingwayf', function () use ($socialite) {
            $config = config('services.bingwayf');
            return $socialite->buildProvider(SocialiteBingWAYFProvider::class, $config);
        });
    }
}
