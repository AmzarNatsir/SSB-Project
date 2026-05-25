<?php

namespace App\Repositories;

use App\Enums\UnitRequestStatus;
use App\Models\Project;
use App\Models\ProjectUnitReturn;
use App\Models\UnitRequest;
use App\Repositories\Interfaces\IUnitReturnRepository;
use Illuminate\Database\Eloquent\Collection;

class UnitReturnRepository implements IUnitReturnRepository
{
    public function create(array $data): ProjectUnitReturn
    {
        return ProjectUnitReturn::create($data);
    }

    public function findByUid(string $uid): ?ProjectUnitReturn
    {
        return ProjectUnitReturn::with([
            'project',
            'unitRequest.items',
            'contract',
            'items.originalUnitRequestItem',
            'creator',
            'approver',
            'approvals.approver',
        ])->where('uid', $uid)->first();
    }

    public function update(ProjectUnitReturn $unitReturn, array $data): bool
    {
        return $unitReturn->update($data);
    }

    public function delete(ProjectUnitReturn $unitReturn): bool
    {
        return $unitReturn->delete();
    }

    public function getEligibleProjects(): Collection
    {
        return Project::whereHas('unitRequests', function ($q) {
            $q->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP)
              ->whereHas('items', function ($q2) {
                  $q2->whereColumn('returned_qty', '<', 'qty');
              });
        })
        ->orderBy('project_name')
        ->get(['id', 'project_code', 'project_name']);
    }

    public function getEligibleUnitRequests(int $projectId): Collection
    {
        return UnitRequest::with(['items' => function ($q) {
                $q->whereColumn('returned_qty', '<', 'qty');
            }, 'contract:id,contract_number'])
            ->where('project_id', $projectId)
            ->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP)
            ->whereHas('items', fn ($q) => $q->whereColumn('returned_qty', '<', 'qty'))
            ->latest()
            ->get();
    }

    public function createItems(ProjectUnitReturn $unitReturn, array $items): void
    {
        $unitReturn->items()->createMany($items);
    }

    public function syncItems(ProjectUnitReturn $unitReturn, array $items): void
    {
        $unitReturn->items()->delete();
        $unitReturn->items()->createMany($items);
    }
}
