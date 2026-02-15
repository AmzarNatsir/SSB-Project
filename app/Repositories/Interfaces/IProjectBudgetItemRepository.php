<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectBudgetItem;

interface IProjectBudgetItemRepository
{
    public function createMany(int $budgetId, array $items);
    public function deleteByBudget(int $budgetId);
    public function update(int $itemId, array $data): bool;
    public function delete(int $itemId): bool;
}
