<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\UpdateLastSeen;

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
        Event::listen(  
            
            'Illuminate\Auth\Events\Login',
            [UpdateLastSeen::class, 'handle']

        );
    }
}
