<?php

namespace App\Repositories;

use App\Enums\UnitRequestStatus;
use App\Models\Project;
use App\Models\UnitReplacement;
use App\Models\UnitRequest;
use App\Repositories\Interfaces\IUnitReplacementRepository;
use App\Services\WorkshopApiService;
use Illuminate\Database\Eloquent\Collection;

class UnitReplacementRepository implements IUnitReplacementRepository
{
    public function __construct(protected WorkshopApiService $workshopApi)
    {
    }

    public function create(array $data): UnitReplacement
    {
        return UnitReplacement::create($data);
    }

    public function findByUid(string $uid): ?UnitReplacement
    {
        return UnitReplacement::with([
            'project',
            'unitRequest.items',
            'contract',
            'items.originalUnitRequestItem',
            'creator',
            'approver',
            'approvals.approver',
        ])->where('uid', $uid)->first();
    }

    public function update(UnitReplacement $unitReplacement, array $data): bool
    {
        return $unitReplacement->update($data);
    }

    public function delete(UnitReplacement $unitReplacement): bool
    {
        return $unitReplacement->delete();
    }

    public function getEligibleProjects(): Collection
    {
        return Project::whereHas('unitRequests', function ($q) {
            $q->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP);
        })
        ->orderBy('project_name')
        ->get(['id', 'project_code', 'project_name']);
    }

    public function getEligibleUnitRequests(int $projectId): Collection
    {
        return UnitRequest::with(['items' => function ($q) {
                $q->whereNull('replaced_at'); // hanya item yang belum diganti
            }, 'contract:id,contract_number'])
            ->where('project_id', $projectId)
            ->where('status', UnitRequestStatus::APPROVED_FROM_WORKSHOP)
            ->latest()
            ->get();
    }

    public function getReplacementCandidates(int $projectId): array
    {
        // Sumber data: Workshop API (master alat berat). Project scope tidak relevan karena
        // master alat berat bersifat global; parameter $projectId dipertahankan untuk
        // kompatibilitas signature interface.
        return $this->workshopApi->all();
    }

    public function createItems(UnitReplacement $unitReplacement, array $items): void
    {
        $unitReplacement->items()->createMany($items);
    }

    public function syncItems(UnitReplacement $unitReplacement, array $items): void
    {
        $unitReplacement->items()->delete();
        $unitReplacement->items()->createMany($items);
    }
}
