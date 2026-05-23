<?php

namespace App\Repositories\Interfaces;

use App\Models\UnitReplacement;
use Illuminate\Database\Eloquent\Collection;

interface IUnitReplacementRepository
{
    public function create(array $data): UnitReplacement;
    public function findByUid(string $uid): ?UnitReplacement;
    public function update(UnitReplacement $unitReplacement, array $data): bool;
    public function delete(UnitReplacement $unitReplacement): bool;

    /**
     * Project yang punya UR dengan status APPROVED_FROM_WORKSHOP — kandidat sumber data PTU.
     */
    public function getEligibleProjects(): Collection;

    /**
     * UR aktif (APPROVED_FROM_WORKSHOP) milik project — sumber items yang bisa diganti.
     */
    public function getEligibleUnitRequests(int $projectId): Collection;

    /**
     * Master alat berat dari Workshop API — kandidat unit pengganti.
     *
     * @return array<int,array>
     */
    public function getReplacementCandidates(int $projectId): array;

    public function createItems(UnitReplacement $unitReplacement, array $items): void;
    public function syncItems(UnitReplacement $unitReplacement, array $items): void;
}
