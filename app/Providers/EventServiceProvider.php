<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\Survey\Events\SurveyCreated;
use App\Domain\Survey\Events\ScoreSubmitted;
use App\Domain\Survey\Events\SurveyCompleted;
use App\Application\Survey\Listeners\LogSurveyActivity;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SurveyCreated::class => [
            LogSurveyActivity::class,
        ],
        ScoreSubmitted::class => [
            // Add score submission listeners here
        ],
        SurveyCompleted::class => [
            // Add completion listeners here
        ],
        \App\Events\BudgetSubmitted::class => [
            \App\Listeners\SendApprovalNotification::class,
        ],
        \App\Events\BudgetApproved::class => [
            \App\Listeners\SendApprovalNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
