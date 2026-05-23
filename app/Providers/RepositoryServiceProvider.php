<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\IProjectSurveyRepository::class,
            \App\Repositories\ProjectSurveyRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IProjectBudgetRepository::class,
            \App\Repositories\ProjectBudgetRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IProjectBudgetItemRepository::class,
            \App\Repositories\ProjectBudgetItemRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IApprovalFlowRepository::class,
            \App\Repositories\ApprovalFlowRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IUnitRequestRepository::class,
            \App\Repositories\UnitRequestRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IUnitReplacementRepository::class,
            \App\Repositories\UnitReplacementRepository::class
        );

        $this->app->bind(
            \App\Repositories\ContractRepository::class,
            \App\Repositories\ContractRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
