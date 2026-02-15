<?php

namespace App\Repositories;

use App\Models\ProjectBudgetItem;
use App\Repositories\Interfaces\IProjectBudgetItemRepository;

class ProjectBudgetItemRepository implements IProjectBudgetItemRepository
{
    public function createMany(int $budgetId, array $items)
    {
        $dataToInsert = [];
        foreach ($items as $item) {
            $dataToInsert[] = array_merge($item, ['project_budget_id' => $budgetId, 'created_at' => now(), 'updated_at' => now()]);
        }
        
        // Note: insert() doesn't trigger Eloquent events (like calculation in boot), 
        // ensuring we calculate totals before inserting or iterate and create.
        // For performance, bulk insert is better, but we need to ensure 'total_cost' is set.
        
        foreach ($dataToInsert as &$item) {
            if (!isset($item['total_cost'])) {
                $item['total_cost'] = $item['qty'] * $item['unit_cost'];
            }
        }
        
        return ProjectBudgetItem::insert($dataToInsert);
    }

    public function deleteByBudget(int $budgetId)
    {
        return ProjectBudgetItem::where('project_budget_id', $budgetId)->delete();
    }
    
    public function update(int $itemId, array $data): bool
    {
        $item = ProjectBudgetItem::find($itemId);
        if ($item) {
            // Recalculate if needed
            if (isset($data['qty']) || isset($data['unit_cost'])) {
                $qty = $data['qty'] ?? $item->qty;
                $cost = $data['unit_cost'] ?? $item->unit_cost;
                $data['total_cost'] = $qty * $cost;
            }
            return $item->update($data);
        }
        return false;
    }
    
    public function delete(int $itemId): bool
    {
        return ProjectBudgetItem::destroy($itemId) > 0;
    }
}
