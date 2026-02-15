<?php

namespace App\Repositories\Interfaces;

use App\Models\ApprovalFlow;
use Illuminate\Database\Eloquent\Collection;

interface IApprovalFlowRepository
{
    public function getAll(): Collection;
    public function findByCode(string $code): ?ApprovalFlow;
    public function findById(int $id): ?ApprovalFlow;
    public function create(array $data): ApprovalFlow;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function syncLevels(int $id, array $levels): void;
}
