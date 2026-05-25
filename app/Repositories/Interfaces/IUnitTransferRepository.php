<?php

namespace App\Repositories\Interfaces;

use App\Models\UnitTransfer;
use Illuminate\Database\Eloquent\Collection;

interface IUnitTransferRepository
{
    public function create(array $data): UnitTransfer;

    public function findByUid(string $uid): ?UnitTransfer;

    public function update(UnitTransfer $unitTransfer, array $data): bool;

    public function delete(UnitTransfer $unitTransfer): bool;

    public function getEligibleSourceProjects(): Collection;

    public function getEligibleUnitRequests(int $projectId): Collection;

    public function getDestinationProjects(int $excludeProjectId): Collection;

    public function createItems(UnitTransfer $unitTransfer, array $items): void;

    public function syncItems(UnitTransfer $unitTransfer, array $items): void;
}
