<?php

namespace App\Policies;

use App\Enums\UnitReplacementStatus;
use App\Models\UnitReplacement;
use App\Models\User;

class UnitReplacementPolicy
{
    public function view(User $user, UnitReplacement $unitReplacement): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function edit(User $user, UnitReplacement $unitReplacement): bool
    {
        return $unitReplacement->isEditable() && $user->id === $unitReplacement->created_by;
    }

    public function submit(User $user, UnitReplacement $unitReplacement): bool
    {
        return $unitReplacement->canSubmit() && $user->id === $unitReplacement->created_by;
    }

    public function approve(User $user, UnitReplacement $unitReplacement): bool
    {
        if (! $unitReplacement->canApprove()) {
            return false;
        }

        $pending = $unitReplacement->approvals()->where('status', 'pending')->first();
        if (! $pending) {
            return false;
        }

        $flowService = app(\App\Services\ApprovalFlowService::class);
        $flow = $flowService->getFlowByCode('UnitReplacement');
        if (! $flow) {
            return false;
        }

        $level = $flow->levels()->where('level_number', $pending->level)->first();
        if (! $level) {
            return false;
        }

        return $flowService->isUserApprover($user->id, $level, $unitReplacement);
    }

    public function forward(User $user, UnitReplacement $unitReplacement): bool
    {
        if (! $unitReplacement->canForward()) {
            return false;
        }

        if ($user->id === $unitReplacement->created_by) {
            return true;
        }

        if (method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames()->map(fn ($r) => strtolower($r));
            foreach (['workshop', 'admin', 'super-admin', 'project-manager', 'manager-project'] as $allowed) {
                if ($roles->contains(fn ($r) => str_contains($r, $allowed))) {
                    return true;
                }
            }
        }

        return false;
    }

    public function workshopDecide(User $user, UnitReplacement $unitReplacement): bool
    {
        if ($unitReplacement->status !== UnitReplacementStatus::FORWARDED_TO_WORKSHOP) {
            return false;
        }

        if (method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames()->map(fn ($r) => strtolower($r));
            foreach (['workshop', 'admin', 'super-admin'] as $allowed) {
                if ($roles->contains(fn ($r) => str_contains($r, $allowed))) {
                    return true;
                }
            }
        }

        return false;
    }

    public function delete(User $user, UnitReplacement $unitReplacement): bool
    {
        return $unitReplacement->status === UnitReplacementStatus::DRAFT
            && $user->id === $unitReplacement->created_by;
    }
}
