<?php

namespace App\Repositories;

use App\Models\ApprovalFlow;
use App\Models\ApprovalFlowLevel;
use App\Repositories\Interfaces\IApprovalFlowRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ApprovalFlowRepository implements IApprovalFlowRepository
{
    public function getAll(): Collection
    {
        return ApprovalFlow::with('levels')->get();
    }

    public function findByCode(string $code): ?ApprovalFlow
    {
        return ApprovalFlow::where('code', $code)->with('levels')->first();
    }

    public function findById(int $id): ?ApprovalFlow
    {
        return ApprovalFlow::with('levels')->find($id);
    }

    public function create(array $data): ApprovalFlow
    {
        return ApprovalFlow::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $flow = ApprovalFlow::find($id);
        if (!$flow) return false;
        return $flow->update($data);
    }

    public function delete(int $id): bool
    {
        $flow = ApprovalFlow::find($id);
        if (!$flow) return false;
        return $flow->delete();
    }

    public function syncLevels(int $id, array $levels): void
    {
        DB::transaction(function () use ($id, $levels) {
            // Remove existing levels
            ApprovalFlowLevel::where('approval_flow_id', $id)->delete();

            // Create new levels
            foreach ($levels as $index => $levelData) {
                ApprovalFlowLevel::create(array_merge($levelData, [
                    'approval_flow_id' => $id,
                    'level_number' => $index + 1
                ]));
            }
        });
    }
}
