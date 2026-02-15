<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectBudget;
use Illuminate\Database\Eloquent\Collection;

interface IProjectBudgetRepository
{
    public function getAll(array $filters = []);
    public function getQuery(array $filters = []);
    public function getById(int $id): ?ProjectBudget;
    public function getByUid(string $uid): ?ProjectBudget;
    public function getByProjectId(int $projectId): ?ProjectBudget;
    public function create(array $data): ProjectBudget;
    public function update(ProjectBudget $budget, array $data): bool;
    public function delete(ProjectBudget $budget): bool;
    
    public function findActiveByProject(int $projectId): ?ProjectBudget;
    public function getHistory(int $projectId);
}
