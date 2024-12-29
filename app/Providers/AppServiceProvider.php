<?php

namespace App\Providers;

use App\Models\Church;
use App\Models\Preaching;
use App\Policies\ChurchPolicy;
use App\Policies\PreachingPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Gate::policy(Church::class, ChurchPolicy::class);
        Gate::policy(Preaching::class, PreachingPolicy::class);
    }
}
