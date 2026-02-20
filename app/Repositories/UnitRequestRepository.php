<?php

namespace App\Repositories;

use App\Models\UnitRequest;
use App\Models\Project;
use App\Enums\NegotiationStatus;
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
            'quotation.items',
            'negotiation',
            'items.quotationItem',
            // 'items.equipment', // Commented out - Equipment model not yet available
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

    public function getEligibleProjects(): Collection
    {
        return Project::whereHas('negotiations', function ($query) {
            $query->where('status', NegotiationStatus::APPROVED);
        })
        ->whereDoesntHave('unitRequests', function ($query) {
            $query->whereIn('status', [
                UnitRequestStatus::DRAFT,
                UnitRequestStatus::SUBMITTED,
                UnitRequestStatus::APPROVED,
                UnitRequestStatus::FORWARDED_TO_WORKSHOP
            ]);
        })
        ->with(['negotiations' => function ($query) {
            $query->where('status', NegotiationStatus::APPROVED)
                  ->with('quotation.items');
        }])
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
