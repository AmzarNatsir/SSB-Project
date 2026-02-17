<?php

namespace App\Services;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Project;
use App\Models\ApprovalFlow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\ApprovalDecision;
use App\Models\QuotationApproval;
use App\Services\AuditService;
use App\Services\ApprovalFlowService;

class QuotationService
{
    protected $auditService;
    protected $flowService;

    public function __construct(AuditService $auditService, ApprovalFlowService $flowService)
    {
        $this->auditService = $auditService;
        $this->flowService = $flowService;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $quotation = Quotation::create([
                'project_id' => $data['project_id'],
                'project_budget_id' => $data['project_budget_id'] ?? null,
                'created_by' => auth()->id(),
                'status' => 'DRAFT',
            ]);

            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $quotation->items()->create($item);
                }
            }

            $quotation->calculateTotals();
            return $quotation;
        });
    }

    public function update(Quotation $quotation, array $data)
    {
        return DB::transaction(function () use ($quotation, $data) {
            $quotation->update([
                'valid_until' => $data['valid_until'] ?? $quotation->valid_until,
                'terms_conditions' => $data['terms_conditions'] ?? $quotation->terms_conditions,
                'updated_by' => auth()->id(),
            ]);

            // If updating items (full replacement or sync logic)
            // For now, let's assume specific methods for adding/removing items, 
            // or this method handles full sync if 'items' key exists.
            if (isset($data['items'])) {
                $quotation->items()->delete();
                foreach ($data['items'] as $item) {
                    $quotation->items()->create($item);
                }
            }
            
            // Manual override of margin if provided
            if (isset($data['profit_margin_percent'])) {
                 // Recalculate selling price based on new margin
                 // Logic: Selling Price = Cost + (Cost * Margin%)
                 // But wait, our model logic says: Profit = Revenue - Cost.
                 // If user sets Margin, they effectively want to adjust the Selling Price (Revenue)
                 // to achieve that margin over the Cost.
                 // target_selling_price = cost / (1 - margin%) ? No, margin is usually markup on cost in this context?
                 // Requirement: SELLING_PRICE = QUOTATION_PRICE × (1 + profit_margin%)
                 
                 $cost = $quotation->quotation_price;
                 $margin = $data['profit_margin_percent'];
                 $sellingPrice = $cost * (1 + ($margin / 100));
                 
                 // To achieve this selling price via items, we might need to adjust item rates proportionally?
                 // OR, the 'Selling Price' is a top-level override?
                 // The Model logic `calculateTotals` currently sets `selling_price = total_project_value`.
                 // If we want to enforce a margin, we might need to introduce a 'manual_adjustment' or similar.
                 // OR simply, the 'items' define the 'total_project_value' (Revenue).
                 // The 'profit_margin_percent' is an OUTPUT, not an input usually, unless we are doing Top-Down pricing.
                 
                 // "PHASE 4 – Profit Planning... Profit margin (%) ... Target revenue"
                 // Implies user inputs Margin, system calculates Target Revenue.
                 // IF user accepts this Target Revenue, we probably need to scale the Item Rates?
                 // Or just save the desired Selling Price.
                 // Let's assume for now we just verify the math and maybe start a 'negotiation' field if strictly needed.
                 // But the requirement says: "The system automatically calculates... SELLING_PRICE = QUOTATION_PRICE × (1 + profit_margin%)"
                 
                 // So maybe the Items define the COST?
                 // "Unit/Equipment ... Rate per unit ... Duration" -> This looks like Revenue generation (Rental).
                 // "QUOTATION_PRICE = total cost of goods sold (from Budget Baseline)" -> This is the Cost.
                 
                 // So:
                 // Cost = Budget Baseline.
                 // Revenue (Items) = what we charge the client.
                 
                 // If User inputs "Profit Margin %", we should probably suggest a "Target Selling Price".
                 // BUT the actual Selling Price is sum of Items.
                 // So if User wants X% margin, they need to increase Item Rates.
                 
                 // For the Service `update`, we'll strictly update fields passed.
            }

            $quotation->calculateTotals();
            return $quotation;
        });
    }

    public function submit(Quotation $quotation)
    {
        if ($quotation->status !== 'DRAFT' && $quotation->status !== 'REVISION_REQUIRED') {
            throw new \Exception("Only DRAFT or REVISION_REQUIRED quotations can be submitted.");
        }

        if ($quotation->items()->count() === 0) {
            throw new \Exception("Cannot submit a quotation without items.");
        }

        // Resolve dynamic flow levels
        $levels = $this->flowService->getLevels('QUOTATION');

        if ($levels->isEmpty()) {
            // No approval levels defined, immediately approve
            $quotation->status = 'APPROVED';
            $quotation->current_approval_level = 0;
            $message = 'Quotation approved automatically (No approval levels defined).';
        } else {
            // Start approval flow
            $quotation->status = 'SUBMITTED';
            $quotation->current_approval_level = 1;
            $message = 'Quotation submitted for approval.';
        }

        $quotation->save();
        
        $this->auditService->log($quotation, 'SUBMIT', auth()->id(), [], ['message' => $message]);
        
        return $quotation;
    }

    public function processApproval(Quotation $quotation, int $approverId, string $decision, ?string $notes)
    {
        return DB::transaction(function () use ($quotation, $approverId, $decision, $notes) {
            $currentLevelNumber = $quotation->current_approval_level;
            
            if ($currentLevelNumber === 0) {
                 throw new \Exception("Quotation is not in an approvable state.");
            }
            
            // Resolve current level from dynamic flow
            $levels = $this->flowService->getLevels('QUOTATION');
            $currentLevel = $levels->where('level_number', $currentLevelNumber)->first();
            
            if (!$currentLevel) {
                throw new \Exception("Approval level configuration missing for level $currentLevelNumber");
            }

            QuotationApproval::create([
                'quotation_id' => $quotation->id,
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
                    $quotation->current_approval_level = $nextLevel->level_number;
                    // Update status label for visibility if needed
                    // For now keeping as SUBMITTED until final approval
                } else {
                    // Final approval
                    $quotation->status = 'APPROVED';
                    $quotation->current_approval_level = 0;
                }
            } elseif ($decision === ApprovalDecision::REJECTED->value) {
                $quotation->status = 'REJECTED';
                $quotation->current_approval_level = 0;
            } elseif ($decision === ApprovalDecision::REVISION->value) {
                $quotation->status = 'REVISION_REQUIRED';
                $quotation->current_approval_level = 0;
            }
            
            $quotation->save();
            $this->auditService->log($quotation, 'APPROVE_DECISION_' . $decision, $approverId, ['level' => $currentLevelNumber]);
            
            return $quotation;
        });
    }
    
    public function generatePdf(Quotation $quotation)
    {
        $data = [
            'quotation' => $quotation,
            'company' => [
                'name' => 'PT. SUMBER SETIA BUDI',
                'address' => 'Head Office Address...',
                'phone' => '+62...',
            ]
        ];
        
        $pdf = Pdf::loadView('quotations.pdf', $data);
        return $pdf;
    }
}
