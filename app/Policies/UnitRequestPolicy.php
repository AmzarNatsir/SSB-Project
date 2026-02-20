<?php

namespace App\Policies;

use App\Enums\UnitRequestStatus;
use App\Models\UnitRequest;
use App\Models\User;

class UnitRequestPolicy
{
    /**
     * Any authenticated user can view a unit request.
     */
    public function view(User $user, UnitRequest $unitRequest): bool
    {
        return true;
    }

    /**
     * Any authenticated user can create a unit request.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only edit when DRAFT or REJECTED, and only by the creator.
     */
    public function edit(User $user, UnitRequest $unitRequest): bool
    {
        return $unitRequest->isEditable() && $user->id === $unitRequest->created_by;
    }

    /**
     * Submit: only creator, and only when DRAFT or REJECTED.
     */
    public function submit(User $user, UnitRequest $unitRequest): bool
    {
        return $unitRequest->canSubmit() && $user->id === $unitRequest->created_by;
    }

    /**
     * Approve/Reject: only when SUBMITTED and user is an authorized approver for the current level.
     */
    public function approve(User $user, UnitRequest $unitRequest): bool
    {
        if (!$unitRequest->canApprove()) {
            return false;
        }

        // Get the current pending approval record
        $pendingApproval = $unitRequest->approvals()->where('status', 'pending')->first();
        if (!$pendingApproval) {
            return false;
        }

        // Use ApprovalFlowService to check if user is an authorized approver for this level
        $flowService = app(\App\Services\ApprovalFlowService::class);
        $flow = $flowService->getFlowByCode('UnitRequest');
        if (!$flow) {
            return false;
        }

        $level = $flow->levels()->where('level_number', $pendingApproval->level)->first();
        if (!$level) {
            return false;
        }

        return $flowService->isUserApprover($user->id, $level, $unitRequest);
    }


    /**
     * Forward to workshop: only when APPROVED.
     */
    public function forward(User $user, UnitRequest $unitRequest): bool
    {
        return $unitRequest->canForward();
    }

    /**
     * Delete: only DRAFT, only by creator.
     */
    public function delete(User $user, UnitRequest $unitRequest): bool
    {
        return $unitRequest->status === UnitRequestStatus::DRAFT
            && $user->id === $unitRequest->created_by;
    }
}
