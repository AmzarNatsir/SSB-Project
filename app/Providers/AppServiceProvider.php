<?php

namespace App\Providers;

use App\Models\UnitReplacement;
use App\Models\UnitRequest;
use App\Policies\UnitReplacementPolicy;
use App\Policies\UnitRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind repository interfaces to their implementations
        $this->app->bind(
            \App\Repositories\Interfaces\IProjectSurveyRepository::class,
            \App\Repositories\ProjectSurveyRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\INegotiationRepository::class,
            \App\Repositories\NegotiationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register UnitRequest policy
        Gate::policy(UnitRequest::class, UnitRequestPolicy::class);
        Gate::policy(UnitReplacement::class, UnitReplacementPolicy::class);
    }
}

