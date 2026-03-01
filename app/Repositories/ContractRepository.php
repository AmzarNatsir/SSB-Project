<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Models\Project;
use App\Repositories\Interfaces\IContractRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractRepository
{
    /**
     * Get all contracts with relations
     */
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Contract::with(['project', 'negotiation', 'creator']);

        if (!empty($filters['contract_number'])) {
            $query->where('contract_number', 'like', '%' . $filters['contract_number'] . '%');
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('end_date', '<=', $filters['end_date']);
        }

        return $query->latest()
            ->paginate($perPage);
    }

    /**
     * Find contract by UID
     */
    public function findByUid(string $uid): ?Contract
    {
        return Contract::with(['project', 'negotiation', 'items', 'creator', 'approver'])
            ->where('uid', $uid)
            ->first();
    }

    /**
     * Create a new contract
     */
    public function create(array $data): Contract
    {
        return Contract::create($data);
    }

    /**
     * Attach items to contract
     */
    public function createItems(Contract $contract, array $items): void
    {
        foreach ($items as $item) {
            $contract->items()->create($item);
        }
    }

    /**
     * Get expiring contracts
     */
    public function getExpiring(int $days = 30)
    {
        return Contract::expiring($days)->get();
    }
}
