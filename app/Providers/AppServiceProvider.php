<?php

namespace App\Providers;

use App\Models\UnitReplacement;
use App\Models\UnitRequest;
use App\Policies\UnitReplacementPolicy;
use App\Policies\UnitRequestPolicy;
use App\Socialite\SsbIdpProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

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

        // Daftarkan custom Socialite driver untuk SSO dengan IdP (ssb-project HRD).
        $this->app->make(SocialiteFactory::class)->extend('ssb-idp', function () {
            $config = config('services.ssb-idp');
            return $this->app->make(SocialiteFactory::class)
                ->buildProvider(SsbIdpProvider::class, $config);
        });
    }
}

