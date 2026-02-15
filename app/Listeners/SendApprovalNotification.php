<?php

namespace App\Listeners;

use App\Events\BudgetSubmitted;
use App\Events\BudgetApproved;
use App\Models\ProjectBudgetApprovalTier;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\BudgetApprovalNotification; // Assuming this exists or just log for now

class SendApprovalNotification
{
    public function handle($event)
    {
        $budget = $event->budget;
        $nextLevel = 0;
        
        if ($event instanceof BudgetSubmitted) {
            $nextLevel = 1; // Submitted triggers Level 1
        } elseif ($event instanceof BudgetApproved) {
            // Find next level logic, or it was passed?
            // If approved at level 1, notify level 2
            $nextLevel = $event->level + 1;
        }

        if ($nextLevel > 0) {
            $tier = ProjectBudgetApprovalTier::where('level', $nextLevel)->first();
            if ($tier) {
                // Find users with this role
                // This depends on how roles are stored. 
                // $approvers = User::role($tier->role_name)->get();
                // For now, let's just log it to demonstrate logic
                \Illuminate\Support\Facades\Log::info("Notification: Budget #{$budget->id} needs approval from {$tier->role_name} (Level {$nextLevel})");
                
                // Notification::send($approvers, new BudgetApprovalNotification($budget));
            }
        }
    }
}
