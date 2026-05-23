<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Models\UnitRequest;
use App\Models\Project;
use App\Enums\ContractStatus;
use App\Enums\UnitRequestStatus;
use App\Repositories\Interfaces\IUnitRequestRepository;
use Illuminate\Database\Eloquent\Collection;

class UnitRequestRepository implements IUnitRequestRepository
{
    public function create(array $data): UnitRequest
    {
        return UnitRequest::create($data);
    }

    public function findByUid(string $uid): ?UnitRequest
    {
        return UnitRequest::with([
            'project',
            'contract.items',
            'quotation.items',
            'negotiation',
            'items.contractItem',
            'items.quotationItem',
            'creator',
            'approver',
            'approvals.approver'
        ])->where('uid', $uid)->first();
    }

    public function update(UnitRequest $unitRequest, array $data): bool
    {
        return $unitRequest->update($data);
    }

    public function delete(UnitRequest $unitRequest): bool
    {
        return $unitRequest->delete();
    }

    /**
     * Project yang punya minimal 1 Kontrak ACTIVE yang belum dijadikan Permintaan Unit aktif.
     *
     * Per-contract scoping: kalau project punya 2 kontrak dan salah satunya sudah
     * punya UR, project tetap muncul (cascade ke contract dropdown akan filter).
     */
    public function getEligibleProjects(): Collection
    {
        return Project::whereHas('contracts', function ($q) {
            $q->where('status', ContractStatus::ACTIVE)
              ->whereDoesntHave('unitRequests', function ($qq) {
                  $qq->whereIn('status', [
                      UnitRequestStatus::DRAFT,
                      UnitRequestStatus::SUBMITTED,
                      UnitRequestStatus::APPROVED,
                      UnitRequestStatus::FORWARDED_TO_WORKSHOP,
                  ]);
              });
        })
        ->orderBy('project_name')
        ->get(['id', 'project_code', 'project_name']);
    }

    /**
     * Kontrak ACTIVE milik project yang belum punya Permintaan Unit aktif.
     * Dipakai oleh cascade dropdown di form create.
     */
    public function getEligibleContracts(int $projectId): Collection
    {
        return Contract::where('project_id', $projectId)
            ->where('status', ContractStatus::ACTIVE)
            ->whereDoesntHave('unitRequests', function ($q) {
                $q->whereIn('status', [
                    UnitRequestStatus::DRAFT,
                    UnitRequestStatus::SUBMITTED,
                    UnitRequestStatus::APPROVED,
                    UnitRequestStatus::FORWARDED_TO_WORKSHOP,
                ]);
            })
            ->with('items')
            ->orderByDesc('start_date')
            ->get();
    }

    public function createItems(UnitRequest $unitRequest, array $items): void
    {
        $unitRequest->items()->createMany($items);
    }

    public function updateItems(UnitRequest $unitRequest, array $items): void
    {
        foreach ($items as $itemData) {
            if (isset($itemData['id'])) {
                $item = $unitRequest->items()->find($itemData['id']);
                if ($item) {
                    $item->update([
                        'duration_days' => $itemData['duration_days'] ?? $item->duration_days,
                        'remarks'       => $itemData['remarks'] ?? $item->remarks,
                    ]);
                }
            }
        }
    }

}
