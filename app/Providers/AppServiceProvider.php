<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\Patient;
use App\Models\User;
use App\Observers\ModelObserver;
use Illuminate\Support\ServiceProvider;

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
        User::observe([
            ModelObserver::class
        ]);

        Patient::observe([
            ModelObserver::class
        ]);

        Document::observe([
            ModelObserver::class
        ]);
    }
}
