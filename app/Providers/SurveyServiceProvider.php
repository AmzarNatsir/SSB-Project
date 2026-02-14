<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Survey\Services\ScoringEngine;
use App\Domain\Survey\Services\SurveyWorkflowService;
use App\Application\Survey\Services\SurveyApplicationService;

class SurveyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Domain Services as singletons
        $this->app->singleton(ScoringEngine::class, function ($app) {
            return new ScoringEngine();
        });
        
        $this->app->singleton(SurveyWorkflowService::class, function ($app) {
            return new SurveyWorkflowService(
                $app->make(ScoringEngine::class)
            );
        });
        
        // Register Application Services
        $this->app->singleton(SurveyApplicationService::class, function ($app) {
            return new SurveyApplicationService(
                $app->make(SurveyWorkflowService::class),
                $app->make(ScoringEngine::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
