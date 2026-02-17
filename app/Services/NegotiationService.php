<?php

namespace App\Services;

use App\Enums\NegotiationStatus;
use App\Models\Negotiation;
use App\Models\Quotation;
use App\Repositories\Interfaces\INegotiationRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class NegotiationService
{
    protected $flowService;

    public function __construct(INegotiationRepository $repo, AuditService $auditService, ApprovalFlowService $flowService)
    {
        $this->repo = $repo;
        $this->auditService = $auditService;
        $this->flowService = $flowService;
    }

    // ... initiate and addRound methods ...

    public function submit(string $uid)
    {
        $negotiation = $this->repo->findByUid($uid);
        
        if ($negotiation->rounds()->count() === 0) {
             throw new Exception("Cannot submit negotiation without any rounds.");
        }

        // Resolve dynamic flow levels
        $levels = $this->flowService->getLevels('NEGOTIATION');

        if ($levels->isEmpty()) {
            // No approval levels defined, immediately approve
            $negotiation->status = NegotiationStatus::APPROVED;
            $negotiation->approved_by = auth()->id();
            $negotiation->approved_at = now();
            $negotiation->final_agreed_value = $negotiation->company_offer_value;
            $message = 'Negotiation approved automatically (No approval levels defined).';
        } else {
            // Start approval flow
            $negotiation->status = NegotiationStatus::SUBMITTED;
            $negotiation->current_approval_level = 1;
            $message = 'Negotiation submitted for approval.';
        }

        $negotiation->save();
        
        $this->auditService->log($negotiation, 'NEGOTIATION_SUBMITTED', auth()->id(), [], ['message' => $message]);
        
        return $negotiation;
    }

    public function processApproval(string $uid, int $approverId, string $decision, ?string $remarks)
    {
        return DB::transaction(function () use ($uid, $approverId, $decision, $remarks) {
            $negotiation = $this->repo->findByUid($uid);
            
            $currentLevelNumber = $negotiation->current_approval_level;
            
            if ($currentLevelNumber === 0 && $negotiation->status !== NegotiationStatus::SUBMITTED) {
                 throw new Exception("Negotiation is not in an approvable state.");
            }
            
            // Resolve current level
            $levels = $this->flowService->getLevels('NEGOTIATION');
            $currentLevel = $levels->where('level_number', $currentLevelNumber)->first();
            
            if (!$currentLevel) {
                // Fallback if level missing?
                throw new Exception("Approval level configuration missing for level $currentLevelNumber");
            }

            // Check if user is authorized approver
            if (!$this->flowService->isUserApprover($approverId, $currentLevel)) {
                 throw new Exception("User is not authorized to approve at this level.");
            }

            // Record Approval
            \App\Models\NegotiationApproval::create([
                'negotiation_id' => $negotiation->id,
                'level' => $currentLevelNumber,
                'approver_id' => $approverId,
                'status' => $decision,
                'remarks' => $remarks,
                'decided_at' => now()
            ]);

            if ($decision === 'APPROVED') {
                // Check for next level
                $nextLevel = $levels->where('level_number', $currentLevelNumber + 1)->first();
                
                if ($nextLevel) {
                    $negotiation->current_approval_level = $nextLevel->level_number;
                } else {
                    // Final Approval
                    $negotiation->status = NegotiationStatus::APPROVED;
                    $negotiation->approved_by = $approverId;
                    $negotiation->approved_at = now();
                    $negotiation->final_agreed_value = $negotiation->company_offer_value;
                    $negotiation->current_approval_level = 0; // Completed
                }
            } elseif ($decision === 'REJECTED') {
                $negotiation->status = NegotiationStatus::REJECTED;
                $negotiation->current_approval_level = 0;
            } elseif ($decision === 'REVISION') {
                $negotiation->status = NegotiationStatus::NEGOTIATING; // Back to draft/negotiating
                $negotiation->current_approval_level = 0;
            }

            $negotiation->notes = $remarks; // Save latest remark to main table?
            $negotiation->save();

            $this->auditService->log($negotiation, 'NEGOTIATION_DECISION_' . $decision, $approverId, [], ['notes' => $remarks]);
            
            return $negotiation;
        });
    }

    public function initiate(Quotation $quotation, int $userId): Negotiation
    {
        return DB::transaction(function () use ($quotation, $userId) {
            // Check if active negotiation exists
            $existing = Negotiation::where('quotation_id', $quotation->id)
                ->whereIn('status', [NegotiationStatus::DRAFT, NegotiationStatus::NEGOTIATING])
                ->first();

            if ($existing) {
                return $existing;
            }

            // Generate Number
            $count = Negotiation::whereYear('created_at', now()->year)->count() + 1;
            $number = 'NEG/' . now()->year . '/' . str_pad($count, 3, '0', STR_PAD_LEFT);

            return $this->repo->create([
                'project_id' => $quotation->project_id,
                'quotation_id' => $quotation->id,
                'negotiation_number' => $number,
                'negotiation_date' => now(),
                'client_offer_value' => 0, // Initial unknown
                'company_offer_value' => $quotation->selling_price, // Start with quote price
                'status' => NegotiationStatus::DRAFT,
                'created_by' => $userId,
            ]);

            $this->auditService->log($negotiation, 'NEGOTIATION_INITIATED', $userId, [], ['number' => $negotiation->negotiation_number]);
            
            return $negotiation;
        });
    }

    public function addRound(string $uid, array $data, int $userId)
    {
        $negotiation = $this->repo->findByUid($uid);
        
        if (!$negotiation->canAddRound()) {
            throw new Exception("Cannot add round to negotiation in status {$negotiation->status->label()}");
        }

        return DB::transaction(function () use ($negotiation, $data, $userId) {
            $roundNumber = $negotiation->rounds()->count() + 1;

            // Handle file upload if present (controller should pass path)
            // Assuming $data['attachment_path'] is already handled

            $this->repo->addRound($negotiation, [
                'round_number' => $roundNumber,
                'client_offer_value' => $data['client_offer_value'],
                'company_counter_offer' => $data['company_counter_offer'],
                'meeting_date' => $data['meeting_date'],
                'summary_notes' => $data['summary_notes'] ?? null,
                'attachment_path' => $data['attachment_path'] ?? null,
                'created_by' => $userId,
            ]);

            // Update main negotiation values
            $this->repo->update($negotiation, [
                'client_offer_value' => $data['client_offer_value'],
                'company_offer_value' => $data['company_counter_offer'],
                'status' => NegotiationStatus::NEGOTIATING,
            ]);
            
            $this->auditService->log($negotiation, 'NEGOTIATION_ROUND_ADDED', $userId, [], [
                'round' => $roundNumber,
                'client_offer' => $data['client_offer_value'],
                'company_counter' => $data['company_counter_offer']
            ]);
            
            return $negotiation;
        });
    }

    
    public function generateLetter(Negotiation $negotiation)
    {
        // $negotiation is already loaded
        $pdf = Pdf::loadView('negotiations.pdf.letter', compact('negotiation'));
        return $pdf;
    }
}
