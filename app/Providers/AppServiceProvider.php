<?php

namespace App\Providers;

use App\Models\Discussion;
use App\Models\DiscussionPost;
use App\Models\User;
use App\Observers\ModelObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        User::observe([
            ModelObserver::class
        ]);
        Discussion::observe([
            ModelObserver::class
        ]);
        DiscussionPost::observe([
            ModelObserver::class
        ]);
    }
}
