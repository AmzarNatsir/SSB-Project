<?php

namespace App\Repositories;

use App\Enums\UnitRequestStatus;
use App\Models\Project;
use App\Models\UnitRequest;
use App\Models\UnitTransfer;
use App\Repositories\Interfaces\IUnitTransferRepository;
use Illuminate\Database\Eloquent\Collection;

class UnitTransferRepository implements IUnitTransferRepository
{
    public function create(array $data): UnitTransfer
    {
        return UnitTransfer::create($data);
    }

    public function findByUid(string $uid): ?UnitTransfer
    {
        return UnitTransfer::with([
            'sourceProject',
            'destinationProject',
            'sourceUnitRequest',
            'items.originalUnitRequestItem',
            'creator',
        ])->where('uid', $uid)->first();
    }

    public function update(UnitTransfer $unitTransfer, array $data): bool
    {
        return $unitTransfer->update($data);
    }

    public function delete(UnitTransfer $unitTransfer): bool
    {
        return $unitTransfer->delete();
    }

    /**
     * Project sumber: yang punya UR APPROVED_FROM_WORKSHOP dengan item yang masih
     * memiliki sisa qty (belum returned penuh & belum transferred penuh).
     */
    public function getEligibleSourceProjects(): Collection
    {
        return Project::whereHas('unitRequests', function ($q) {
            $q->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP)
              ->whereHas('items', function ($q2) {
                  $q2->whereRaw('qty > (returned_qty + transferred_qty)');
              });
        })
        ->orderBy('project_name')
        ->get(['id', 'project_code', 'project_number', 'project_name', 'project_location']);
    }

    public function getEligibleUnitRequests(int $projectId): Collection
    {
        return UnitRequest::with(['items' => function ($q) {
                $q->whereRaw('qty > (returned_qty + transferred_qty)');
            }])
            ->where('project_id', $projectId)
            ->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP)
            ->whereHas('items', fn ($q) => $q->whereRaw('qty > (returned_qty + transferred_qty)'))
            ->latest()
            ->get();
    }

    public function getDestinationProjects(int $excludeProjectId): Collection
    {
        return Project::where('id', '!=', $excludeProjectId)
            ->orderBy('project_name')
            ->get(['id', 'project_code', 'project_number', 'project_name', 'project_location']);
    }

    public function createItems(UnitTransfer $unitTransfer, array $items): void
    {
        $unitTransfer->items()->createMany($items);
    }

    public function syncItems(UnitTransfer $unitTransfer, array $items): void
    {
        $unitTransfer->items()->delete();
        $unitTransfer->items()->createMany($items);
    }
}
