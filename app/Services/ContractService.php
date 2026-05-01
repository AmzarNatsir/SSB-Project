<?php

namespace App\Services;

use App\Enums\ContractStatus;
use App\Enums\NegotiationStatus;
use App\Models\Contract;
use App\Models\Negotiation;
use App\Models\Project;
use App\Repositories\ContractRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContractService
{
    public function __construct(
        protected ContractRepository $contractRepository,
        protected ContractNumberGeneratorService $numberGenerator
    ) {}

    /**
     * Create a new contract from a project negotiation
     */
    public function createContract(array $data): Contract
    {
        $project = Project::with(['latest_negotiation.quotation.items'])->findOrFail($data['project_id']);
        $negotiation = $project->latest_negotiation;

        if (!$negotiation || $negotiation->status !== NegotiationStatus::APPROVED) {
            throw new Exception("Cannot create contract. Project negotiation is not approved.");
        }

        return DB::transaction(function () use ($project, $negotiation, $data) {
            // Generate contract number
            $contractNumber = $this->numberGenerator->generate($project);

            // Handle file upload
            $attachmentPath = null;
            if (isset($data['attachment']) && $data['attachment']->isValid()) {
                $attachmentPath = $data['attachment']->store('contracts', 'public');
            }

            // Create contract record
            $contractData = [
                'contract_number' => $contractNumber,
                'project_id' => $project->id,
                'negotiation_id' => $negotiation->id,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'attachment_path' => $attachmentPath,
                'status' => ContractStatus::ACTIVE,
                'created_by' => auth()->id(),
            ];

            $contract = $this->contractRepository->create($contractData);

            // Snapshot items from quotation
            $this->snapshotItems($contract, $negotiation->quotation);

            return $contract;
        });
    }

    /**
     * Snapshot items from quotation into contract_items
     */
    protected function snapshotItems(Contract $contract, $quotation): void
    {
        $items = [];
        foreach ($quotation->items as $item) {
            $items[] = [
                'unit_name' => $item->unit_name,
                'unit_id' => $item->unit_id,
                'qty' => $item->quantity,
                'unit_price' => $item->rate,
                'total_price' => $item->total_price,
                'duration' => $item->duration,
                'fuel_cost' => 0, // Need to clarify where this comes from if not in quotation_items
                'tax' => 0,       // Need to clarify where this comes from
            ];
        }

        $this->contractRepository->createItems($contract, $items);
    }

    /**
     * Load contract data for project selection
     */
    public function getContractPreviewData(Project $project): array
    {
        $project->load(['latest_negotiation.quotation.items']);
        $negotiation = $project->latest_negotiation;

        if (!$negotiation || $negotiation->status !== NegotiationStatus::APPROVED) {
            throw new Exception("Negotiation for this project is not approved.");
        }

        return [
            'project' => $project,
            'negotiation' => $negotiation,
            'agreed_value' => $negotiation->final_agreed_value,
            'items' => $negotiation->quotation->items,
        ];
    }
    /**
     * Update an existing contract
     */
    public function updateContract(Contract $contract, array $data): Contract
    {
        return DB::transaction(function () use ($contract, $data) {
            // Handle file upload
            if (isset($data['attachment']) && $data['attachment']->isValid()) {
                // Delete old file if exists
                if ($contract->attachment_path) {
                    Storage::disk('public')->delete($contract->attachment_path);
                }
                $contract->attachment_path = $data['attachment']->store('contracts', 'public');
            }

            $contract->start_date = $data['start_date'];
            $contract->end_date = $data['end_date'];
            $contract->save();

            return $contract;
        });
    }
}
