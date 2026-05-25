<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectUnitReturn;
use Illuminate\Database\Eloquent\Collection;

interface IUnitReturnRepository
{
    public function create(array $data): ProjectUnitReturn;
    public function findByUid(string $uid): ?ProjectUnitReturn;
    public function update(ProjectUnitReturn $unitReturn, array $data): bool;
    public function delete(ProjectUnitReturn $unitReturn): bool;

    /**
     * Project yang punya UR APPROVED_FROM_WORKSHOP dengan item yang belum dikembalikan.
     */
    public function getEligibleProjects(): Collection;

    /**
     * UR APPROVED_FROM_WORKSHOP milik project, beserta item yang belum dikembalikan.
     */
    public function getEligibleUnitRequests(int $projectId): Collection;

    public function createItems(ProjectUnitReturn $unitReturn, array $items): void;
    public function syncItems(ProjectUnitReturn $unitReturn, array $items): void;
}
