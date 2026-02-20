<?php

namespace App\Repositories\Interfaces;

use App\Models\UnitRequest;
use Illuminate\Database\Eloquent\Collection;

interface IUnitRequestRepository
{
    public function create(array $data): UnitRequest;
    public function findByUid(string $uid): ?UnitRequest;
    public function update(UnitRequest $unitRequest, array $data): bool;
    public function delete(UnitRequest $unitRequest): bool;
    public function getEligibleProjects(): Collection;
    public function createItems(UnitRequest $unitRequest, array $items): void;
    public function updateItems(UnitRequest $unitRequest, array $items): void;
}
