<?php

namespace App\Events;

use App\Models\ProjectBudget;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BudgetApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $budget;
    public $level;

    public function __construct(ProjectBudget $budget, int $level)
    {
        $this->budget = $budget;
        $this->level = $level;
    }
}
