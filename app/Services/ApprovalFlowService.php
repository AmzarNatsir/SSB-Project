<?php

namespace App\Services;

use App\Models\ApprovalFlow;
use App\Models\ApprovalFlowLevel;
use App\Repositories\Interfaces\IApprovalFlowRepository;
use Illuminate\Database\Eloquent\Collection;

class ApprovalFlowService
{
    protected $repo;

    public function __construct(IApprovalFlowRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getFlows(): Collection
    {
        return $this->repo->getAll();
    }

    public function getFlowByCode(string $code): ?ApprovalFlow
    {
        return $this->repo->findByCode($code);
    }

    public function updateFlowLevels(int $id, array $levels): void
    {
        $this->repo->syncLevels($id, $levels);
    }

    /**
     * Get the approver for a specific level in a flow.
     */
    public function resolveApprover(ApprovalFlowLevel $level, $context = null)
    {
        switch ($level->approver_type) {
            case \App\Enums\ApproverType::USER:
                return \App\Models\User::find($level->approver_user_id);
            
            case \App\Enums\ApproverType::ROLE:
                // Find first user with this role for context purposes (e.g., display name)
                return \App\Models\User::role($level->approver_role_id)->first();

            case \App\Enums\ApproverType::DEPARTMENT:
                // TODO: Logic for Department head
                return null;
        }

        return null;
    }

    /**
     * Check if a specific user is an authorized approver for a level.
     */
    public function isUserApprover(int $userId, ApprovalFlowLevel $level, $context = null): bool
    {
        $user = \App\Models\User::find($userId);
        if (!$user) return false;

        switch ($level->approver_type) {
            case \App\Enums\ApproverType::USER:
                return $user->id === $level->approver_user_id;
            
            case \App\Enums\ApproverType::ROLE:
                // Check if user has the specific role ID
                // Spatie roles can be checked by ID or name
                return $user->roles()->where('id', $level->approver_role_id)->exists();

            case \App\Enums\ApproverType::DEPARTMENT:
                // TODO: Implement department check
                return false;
        }

        return false;
    }

    /**
     * Get all levels for a flow code.
     */
    public function getLevels(string $code): Collection
    {
        $flow = $this->getFlowByCode($code);
        return $flow ? $flow->levels : new Collection();
    }
}
