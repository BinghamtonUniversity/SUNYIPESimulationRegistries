<?php

namespace App\Providers;

use App\Models\Activity;
use App\Observers\ActivityObserver;
use App\Listeners\AddSesTenantHeader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Mail\Events\MessageSending;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Activity::observe(ActivityObserver::class);

        // Migrated from EventServiceProvider
        Event::listen(Registered::class, SendEmailVerificationNotification::class);
        Event::listen(MessageSending::class, AddSesTenantHeader::class);

        // Safe deferred Socialite extension
        $this->app->resolving(Socialite::class, function (Socialite $socialite) {
            $socialite->extend('bingwayf', function () use ($socialite) {
                $config = config('services.bingwayf');
                return $socialite->buildProvider(SocialiteBingWAYFProvider::class, $config);
            });
        });
    }
}