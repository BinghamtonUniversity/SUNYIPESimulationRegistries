<?php

namespace App\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use App\Models\Activity;
use App\Observers\ActivityObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ]
    ];
    public function boot(){
        Activity::observe(ActivityObserver::class);
    }

    public function shouldDiscoverEvents(){
        return false;
    }
}
