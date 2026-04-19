<?php

namespace App\Services;

use App\Enums\ApprovalDecision;
use App\Enums\BudgetStatus;
use App\Models\ProjectBudget;
use App\Models\ProjectBudgetApproval;
use App\Models\ProjectBudgetApprovalTier;
use App\Models\ProjectBudgetRevision;
use App\Repositories\Interfaces\IProjectBudgetRepository;
use App\Repositories\Interfaces\IProjectBudgetItemRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class ProjectBudgetService
{
    protected $budgetRepo;
    protected $itemRepo;
    protected $auditService;
    protected $flowService;

    public function __construct(
        IProjectBudgetRepository $budgetRepo,
        IProjectBudgetItemRepository $itemRepo,
        AuditService $auditService,
        ApprovalFlowService $flowService
    ) {
        $this->budgetRepo = $budgetRepo;
        $this->itemRepo = $itemRepo;
        $this->auditService = $auditService;
        $this->flowService = $flowService;
    }

    public function createBudget(array $data, array $items = [])
    {
        return DB::transaction(function () use ($data, $items) {
            // Check project feasibility? - Passed in controller via Request validation or here
            // Assuming data is validated
            
            $data['status'] = BudgetStatus::DRAFT;
            $data['version'] = 1;
            $data['created_by'] = auth()->id();
            
            $budget = $this->budgetRepo->create($data);
            
            if (!empty($items)) {
                $this->itemRepo->createMany($budget->id, $items);
                $budget->calculateTotals(); // Updates totals and selling price
            }
            
            $this->auditService->log($budget, 'CREATE', auth()->id(), [], $budget->toArray());
            
            return $budget;
        });
    }

    public function updateBudget(int $id, array $data, array $items = [])
    {
        $budget = $this->budgetRepo->getById($id);
        
        if ($budget->isLocked()) {
             throw ValidationException::withMessages(['status' => 'Budget is locked and cannot be updated. Create a revision instead.']);
        }
        
        // Optimistic locking check
        if (isset($data['version']) && $budget->version != $data['version']) {
            throw ValidationException::withMessages(['version' => 'The budget has been modified by someone else. Please refresh.']);
        }

        return DB::transaction(function () use ($budget, $data, $items) {
            $oldValues = $budget->toArray();
            
            // Update items
            // Strategy: Wipe and recreate, or diff?
            // For simplicity in wizard, often wipe and recreate is safer for integrity if ID tracking isn't critical
            // But if we want to update specific items, we need IDs.
            // Let's assume $items contains ALL current items.
            
            // Update items
            // We always replace the items with the ones provided in the request
            $this->itemRepo->deleteByBudget($budget->id);
            if (!empty($items)) {
                $this->itemRepo->createMany($budget->id, $items);
            }
            
            $this->budgetRepo->update($budget, $data);
            $budget->refresh(); // Get new data
            $budget->calculateTotals();
            
            $this->auditService->log($budget, 'UPDATE', auth()->id(), $oldValues, $budget->toArray());
            
            return $budget;
        });
    }

    public function submitBudget(int $id)
    {
        $budget = $this->budgetRepo->getById($id);
        
        if ($budget->status !== BudgetStatus::DRAFT && $budget->status !== BudgetStatus::REVISION_REQUIRED) {
            throw ValidationException::withMessages(['status' => 'Only DRAFT or REVISION_REQUIRED budgets can be submitted.']);
        }
        
        if ($budget->items()->count() === 0) {
            throw ValidationException::withMessages(['items' => 'Cannot submit an empty budget.']);
        }

        // Resolve dynamic flow levels
        $levels = $this->flowService->getLevels('PROJECT_BUDGET');

        if ($levels->isEmpty()) {
            // No approval levels defined, immediately baseline
            $budget->status = BudgetStatus::BASELINE_APPROVED;
            $budget->current_approval_level = 0;
            $budget->baseline_locked_at = now();
            $message = 'Budget approved automatically (No approval levels defined).';
        } else {
            // Start approval flow
            $budget->status = BudgetStatus::SUBMITTED;
            $budget->current_approval_level = 1;
            $message = 'Budget submitted for approval.';
        }

        $budget->save();
        
        $this->auditService->log($budget, 'SUBMIT', auth()->id(), [], ['message' => $message]);
        
        return $budget;
    }

    public function processApproval(int $id, int $approverId, string $decision, ?string $notes)
    {
        return DB::transaction(function () use ($id, $approverId, $decision, $notes) {
            $budget = $this->budgetRepo->getById($id);
            
            $currentLevelNumber = $budget->current_approval_level;
            
            if ($currentLevelNumber === 0) {
                 throw ValidationException::withMessages(['status' => 'Budget is not in an approvable state.']);
            }
            
            // Resolve current level from dynamic flow
            $levels = $this->flowService->getLevels('PROJECT_BUDGET');
            $currentLevel = $levels->where('level_number', $currentLevelNumber)->first();
            
            if (!$currentLevel) {
                throw new Exception("Approval level configuration missing for level $currentLevelNumber");
            }

            ProjectBudgetApproval::create([
                'project_budget_id' => $budget->id,
                'level' => $currentLevelNumber,
                'approver_id' => $approverId,
                'decision' => $decision,
                'notes' => $notes,
                'decided_at' => now()
            ]);
            
            if ($decision === ApprovalDecision::APPROVED->value) {
                // Check if there is next level
                $nextLevel = $levels->where('level_number', $currentLevelNumber + 1)->first();
                
                if ($nextLevel) {
                    $budget->current_approval_level = $nextLevel->level_number;
                    
                    // Optional: Update status label for visibility
                    if ($budget->current_approval_level === 2) {
                        $budget->status = BudgetStatus::APPROVED_L1;
                    } elseif ($budget->current_approval_level === 3) {
                        $budget->status = BudgetStatus::APPROVED_L2;
                    }
                } else {
                    // Final approval
                    $budget->status = BudgetStatus::BASELINE_APPROVED;
                    $budget->current_approval_level = 0; // Reset or mark as done
                    $budget->baseline_locked_at = now();
                }
            } elseif ($decision === ApprovalDecision::REJECTED->value) {
                $budget->status = BudgetStatus::REJECTED;
                $budget->current_approval_level = 0;
            } elseif ($decision === ApprovalDecision::REVISION->value) {
                $budget->status = BudgetStatus::REVISION_REQUIRED;
                $budget->current_approval_level = 0;
            }
            
            $budget->save();
            $this->auditService->log($budget, 'APPROVE_DECISION_' . $decision, $approverId, ['level' => $currentLevelNumber]);
            
            return $budget;
        });
    }
    
    public function createRevision(int $id, string $reason, int $userId)
    {
        return DB::transaction(function () use ($id, $reason, $userId) {
            $originalBudget = $this->budgetRepo->getById($id);
            
            if (!$originalBudget->isLocked()) {
                throw ValidationException::withMessages(['status' => 'Only Baseline Approved budgets can be revised. Update the draft instead.']);
            }
            
            // Clone Budget
            $newBudget = $originalBudget->replicate();
            $newBudget->uid = null; // Reset uid so boot hook generates a new UUID
            $newBudget->version = $originalBudget->version + 1;
            $newBudget->status = BudgetStatus::DRAFT; // Or REVISION_REQUIRED?
            $newBudget->baseline_locked_at = null;
            $newBudget->created_by = $userId;
            $newBudget->created_at = now();
            $newBudget->updated_at = now();
            $newBudget->save();
            
            // Clone items
            foreach ($originalBudget->items as $item) {
                $newItem = $item->replicate();
                $newItem->project_budget_id = $newBudget->id;
                $newItem->created_at = now();
                $newItem->updated_at = now();
                $newItem->save();
            }
            
            // Log revision history on the OLD budget? Or just link them?
            // "ProjectBudgetRevision" table links to "budget_id".
            // Maybe it links the NEW budget to the OLD one?
            // Or it's just a log entry. 
            // Let's treat it as a log entry for the NEW budget saying "Derived from X"
            // OR we treat the whole things as one "Budget Entity" with strict versioning.
            // But we have separate IDs.
            
            ProjectBudgetRevision::create([
                'project_budget_id' => $newBudget->id, // Track revision on the new one?
                'revision_no' => $newBudget->version,
                'reasons' => $reason,
                'revised_by' => $userId,
                'revised_at' => now()
            ]);
            
            $this->auditService->log($originalBudget, 'REVISED_TO_V' . $newBudget->version, $userId);
            
            return $newBudget;
        });
    }

    private function getCurrentApprovalLevel(BudgetStatus $status): int
    {
        return match($status) {
            BudgetStatus::SUBMITTED => 1,
            BudgetStatus::APPROVED_L1 => 2,
            BudgetStatus::APPROVED_L2 => 3,
            default => 0
        };
    }
}
