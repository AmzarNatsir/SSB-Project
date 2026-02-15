<?php

namespace App\Policies;

use App\Models\ProjectBudget;
use App\Models\ProjectBudgetApprovalTier;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectBudgetPolicy
{
    use HandlesAuthorization;

    // View Any
    public function viewAny(User $user)
    {
        return true; // Allow all authenticated users to see list, filtered by their project access in Controller/Repo
    }

    // View Single
    public function view(User $user, ProjectBudget $budget)
    {
        // Check if user is part of project?
        // Assuming user has project_id or ProjectMember relationship
        // For now, allow all (MVP) or implement logic
        return true; 
    }

    // Create
    public function create(User $user)
    {
        // Only analysts or PMs
        return true; // Placeholder for role check: $user->hasRole('Analyst')
    }

    // Update
    public function update(User $user, ProjectBudget $budget)
    {
        if ($budget->isLocked()) return false;
        
        // Only creator or PM
        // return $user->id === $budget->created_by || $user->hasRole('PM');
        return true; 
    }

    // Delete (Soft)
    public function delete(User $user, ProjectBudget $budget)
    {
         if ($budget->isLocked()) return false;
         return $user->id === $budget->created_by;
    }

    // Submit
    public function submit(User $user, ProjectBudget $budget)
    {
        return $user->id === $budget->created_by && !$budget->isLocked();
    }

    // Approve
    public function approve(User $user, ProjectBudget $budget)
    {
        if ($budget->current_approval_level === 0) return false;

        $flowService = app(\App\Services\ApprovalFlowService::class);
        $levels = $flowService->getLevels('PROJECT_BUDGET');
        $currentLevel = $levels->where('level_number', $budget->current_approval_level)->first();

        if (!$currentLevel) return false;

        return $flowService->isUserApprover($user->id, $currentLevel);
    }
}
