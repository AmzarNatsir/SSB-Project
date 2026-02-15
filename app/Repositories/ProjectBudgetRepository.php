<?php

namespace App\Repositories;

use App\Models\ProjectBudget;
use App\Repositories\Interfaces\IProjectBudgetRepository;
use Illuminate\Support\Facades\DB;

class ProjectBudgetRepository implements IProjectBudgetRepository
{
    public function getAll(array $filters = [])
    {
        return $this->getQuery($filters)->latest()->get();
    }

    public function getQuery(array $filters = [])
    {
        $query = ProjectBudget::with(['project', 'creator']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        return $query;
    }

    public function getById(int $id): ?ProjectBudget
    {
        return ProjectBudget::with(['project', 'items', 'approvals.approver', 'revisions.reviser', 'creator'])
            ->find($id);
    }

    public function getByUid(string $uid): ?ProjectBudget
    {
        return ProjectBudget::with(['project', 'items', 'approvals.approver', 'revisions.reviser', 'creator'])
            ->where('uid', $uid)
            ->first();
    }

    public function getByProjectId(int $projectId): ?ProjectBudget
    {
        return ProjectBudget::where('project_id', $projectId)
            ->with(['items'])
            ->latest('version')
            ->first();
    }

    public function create(array $data): ProjectBudget
    {
        return ProjectBudget::create($data);
    }

    public function update(ProjectBudget $budget, array $data): bool
    {
        return $budget->update($data);
    }

    public function delete(ProjectBudget $budget): bool
    {
        return $budget->delete();
    }

    public function findActiveByProject(int $projectId): ?ProjectBudget
    {
        // "Active" could mean the latest non-rejected one, or specifically the one in progress
        // For now, let's get the latest version
        return ProjectBudget::where('project_id', $projectId)
            ->orderByDesc('version')
            ->first();
    }

    public function getHistory(int $projectId)
    {
        return ProjectBudget::where('project_id', $projectId)
            ->with(['creator', 'revisions'])
            ->withTrashed() // Include deleted/archived versions if we use soft deletes for versioning
            ->orderByDesc('version')
            ->get();
    }
}
