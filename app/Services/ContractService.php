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
     * Create a new contract from a project negotiation.
     *
     * Negotiation di-resolve eksplisit dari $data['negotiation_id']. Kalau tidak ada
     * (backward-compat), fallback ke negosiasi APPROVED terlama yang belum punya kontrak.
     */
    public function createContract(array $data): Contract
    {
        $project = Project::findOrFail($data['project_id']);
        $negotiation = $this->resolveNegotiation($project, $data['negotiation_id'] ?? null);

        // Eager-load quotation.items untuk snapshot
        $negotiation->load('quotation.items');

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
     * Snapshot items dari quotation ke contract_items.
     *
     * Field tambahan (uid_unit, duration_unit) di-propagate dari quotation_items.
     * equipment_code di-lookup dari Workshop API (best-effort, null kalau gagal).
     */
    protected function snapshotItems(Contract $contract, $quotation): void
    {
        // Pre-fetch equipment codes via Workshop API (best-effort)
        $unitIds = $quotation->items->pluck('unit_id')->filter()->unique()->all();
        $workshopUnits = [];
        if (! empty($unitIds)) {
            try {
                $workshop = app(\App\Services\WorkshopApiService::class);
                $workshopUnits = $workshop->findMany($unitIds); // keyed by id
            } catch (\Throwable $e) {
                // Fallback silent — equipment_code akan null
                $workshopUnits = [];
            }
        }

        $items = [];
        foreach ($quotation->items as $item) {
            $equipmentCode = $workshopUnits[$item->unit_id]['equipment_code']
                ?? $workshopUnits[$item->unit_id]['code']
                ?? null;

            $items[] = [
                'unit_name'      => $item->unit_name,
                'unit_id'        => $item->unit_id,
                'uid_unit'       => $item->uid_unit,
                'equipment_code' => $equipmentCode,
                'qty'            => $item->quantity,
                'unit_price'     => $item->rate,
                'total_price'    => $item->total_price,
                'duration'       => $item->duration,
                'duration_unit'  => $item->duration_unit ?? 'MONTH',
                'fuel_cost'      => 0, // negotiated separately — editable di kontrak nanti
                'tax'            => 0, // negotiated separately
                'notes'          => null,
            ];
        }

        $this->contractRepository->createItems($contract, $items);
    }

    /**
     * Load contract data for project selection (preview AJAX).
     * Negotiation di-resolve dari parameter eksplisit atau fallback ke yang belum punya kontrak.
     */
    public function getContractPreviewData(Project $project, ?int $negotiationId = null): array
    {
        $negotiation = $this->resolveNegotiation($project, $negotiationId);
        $negotiation->load('quotation.items');

        return [
            'project' => $project,
            'negotiation' => $negotiation,
            'agreed_value' => $negotiation->final_agreed_value,
            'items' => $negotiation->quotation->items,
        ];
    }

    /**
     * Resolve negotiation untuk pembuatan kontrak.
     *
     * Strategi:
     *  1. Kalau $negotiationId di-pass → validasi: harus milik project, APPROVED, belum punya kontrak.
     *  2. Kalau tidak (backward-compat) → ambil negosiasi APPROVED tertua yg belum punya kontrak.
     *
     * Throw exception kalau tidak ada kandidat valid.
     */
    protected function resolveNegotiation(Project $project, ?int $negotiationId): Negotiation
    {
        if ($negotiationId) {
            $negotiation = Negotiation::where('id', $negotiationId)
                ->where('project_id', $project->id)
                ->first();

            if (! $negotiation) {
                throw new Exception('Negosiasi tidak ditemukan untuk proyek ini.');
            }
            if ($negotiation->status !== NegotiationStatus::APPROVED) {
                throw new Exception('Negosiasi belum disetujui.');
            }
            if ($negotiation->contract()->exists()) {
                throw new Exception('Negosiasi ini sudah memiliki kontrak.');
            }
            return $negotiation;
        }

        $negotiation = Negotiation::where('project_id', $project->id)
            ->where('status', NegotiationStatus::APPROVED)
            ->whereDoesntHave('contract')
            ->orderBy('negotiation_date')
            ->first();

        if (! $negotiation) {
            throw new Exception('Tidak ada negosiasi APPROVED tersedia (semua sudah memiliki kontrak).');
        }

        return $negotiation;
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
