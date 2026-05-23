<?php

namespace App\Services;

use App\Enums\UnitReplacementStatus;
use App\Models\UnitReplacement;
use App\Models\UnitReplacementApproval;
use App\Models\UnitRequestItem;
use App\Repositories\Interfaces\IUnitReplacementRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UnitReplacementService
{
    protected IUnitReplacementRepository $repo;
    protected AuditService $auditService;
    protected ApprovalFlowService $flowService;
    protected WorkshopApiService $workshopApi;

    public function __construct(
        IUnitReplacementRepository $repo,
        AuditService $auditService,
        ApprovalFlowService $flowService,
        WorkshopApiService $workshopApi
    ) {
        $this->repo = $repo;
        $this->auditService = $auditService;
        $this->flowService = $flowService;
        $this->workshopApi = $workshopApi;
    }

    /**
     * Generate nomor PTU format: PTU/YYYY/000001 — reset per year, 6-digit zero-pad.
     */
    protected function generateReplacementNumber(): string
    {
        $year = date('Y');
        $count = UnitReplacement::whereYear('created_at', $year)->count() + 1;

        do {
            $sequence = str_pad($count, 6, '0', STR_PAD_LEFT);
            $number = "PTU/{$year}/{$sequence}";
            $exists = UnitReplacement::where('replacement_number', $number)->exists();
            $count++;
        } while ($exists);

        return $number;
    }

    protected function handleFileUpload(UploadedFile $file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('unit-replacements/attachments', $filename, 'private');
    }

    /**
     * Snapshot original unit-request item + workshop unit ke array untuk insert.
     */
    protected function buildItemPayload(array $rawItem): array
    {
        $original = UnitRequestItem::with('unitRequest')->findOrFail($rawItem['original_unit_request_item_id']);

        $workshopUnit = null;
        $workshopUnitId = $rawItem['replacement_workshop_unit_id'] ?? null;
        if (! empty($workshopUnitId)) {
            $workshopUnit = $this->workshopApi->find((int) $workshopUnitId);
        }

        return [
            'original_unit_request_item_id' => $original->id,
            'original_unit_name' => $original->unit_name,
            'original_equipment_code' => $original->equipment_id ? (string) $original->equipment_id : null,
            'replacement_workshop_unit_id' => $workshopUnit['id'] ?? ($workshopUnitId ? (int) $workshopUnitId : null),
            'replacement_unit_name' => $rawItem['replacement_unit_name']
                ?? $workshopUnit['name']
                ?? '',
            'replacement_equipment_code' => $rawItem['replacement_equipment_code']
                ?? $workshopUnit['equipment_code']
                ?? null,
            'replacement_qty' => $rawItem['replacement_qty'] ?? 1,
            'replacement_duration_days' => $rawItem['replacement_duration_days'] ?? null,
            'reason' => $rawItem['reason'] ?? '',
            'unit_ready' => null,
            'operator_id' => null,
            'operator_name' => null,
            'remarks' => $rawItem['remarks'] ?? null,
        ];
    }

    public function create(array $data, int $userId): UnitReplacement
    {
        return DB::transaction(function () use ($data, $userId) {
            $unitRequest = \App\Models\UnitRequest::with(['items', 'contract'])
                ->where('id', $data['unit_request_id'])
                ->where('project_id', $data['project_id'])
                ->where('status', \App\Enums\UnitRequestStatus::APPROVED_FROM_WORKSHOP)
                ->first();

            if (! $unitRequest) {
                throw new \Exception('Unit Request sumber tidak ditemukan / belum APPROVED_FROM_WORKSHOP / bukan milik proyek.');
            }

            if (empty($data['items']) || ! is_array($data['items'])) {
                throw new \Exception('Minimal pilih 1 unit yang akan diganti.');
            }

            // Validasi: original items harus milik UR ini & belum diganti
            foreach ($data['items'] as $row) {
                $found = $unitRequest->items
                    ->where('id', $row['original_unit_request_item_id'])
                    ->whereNull('replaced_at')
                    ->first();
                if (! $found) {
                    throw new \Exception('Salah satu unit yang dipilih tidak valid atau sudah pernah diganti.');
                }
            }

            $attachmentPath = null;
            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $attachmentPath = $this->handleFileUpload($data['attachment']);
            }

            $unitReplacement = $this->repo->create([
                'uid' => (string) Str::uuid(),
                'project_id' => $data['project_id'],
                'unit_request_id' => $unitRequest->id,
                'contract_id' => $unitRequest->contract_id,
                'replacement_number' => $this->generateReplacementNumber(),
                'replacement_date' => $data['replacement_date'],
                'mobilization_date' => $data['mobilization_date'] ?? null,
                'cause' => $data['cause'],
                'status' => UnitReplacementStatus::DRAFT,
                'notes' => $data['notes'] ?? null,
                'attachment_path' => $attachmentPath,
                'created_by' => $userId,
            ]);

            $itemsPayload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
            $this->repo->createItems($unitReplacement, $itemsPayload);

            $this->auditService->log(
                $unitReplacement,
                'UNIT_REPLACEMENT_CREATED',
                $userId,
                [],
                [
                    'replacement_number' => $unitReplacement->replacement_number,
                    'project_id' => $unitReplacement->project_id,
                    'unit_request_id' => $unitRequest->id,
                    'items_count' => count($itemsPayload),
                ]
            );

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }

    public function update(string $uid, array $data, int $userId): UnitReplacement
    {
        return DB::transaction(function () use ($uid, $data, $userId) {
            $unitReplacement = $this->repo->findByUid($uid);

            if (! $unitReplacement) {
                throw new \Exception('Unit replacement not found.');
            }

            if (! $unitReplacement->isEditable()) {
                throw new \Exception("Cannot edit in {$unitReplacement->status->label()} status.");
            }

            $updateData = [];
            $oldValues = [];
            $newValues = [];

            foreach (['replacement_date', 'mobilization_date', 'cause', 'notes'] as $field) {
                if (array_key_exists($field, $data)) {
                    $oldValues[$field] = $unitReplacement->$field instanceof \DateTimeInterface
                        ? $unitReplacement->$field->format('Y-m-d')
                        : $unitReplacement->$field;
                    $updateData[$field] = $data[$field];
                    $newValues[$field] = $data[$field];
                }
            }

            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $oldValues['attachment_path'] = $unitReplacement->attachment_path;
                $updateData['attachment_path'] = $this->handleFileUpload($data['attachment']);
                $newValues['attachment_path'] = $updateData['attachment_path'];
            }

            if (! empty($updateData)) {
                $this->repo->update($unitReplacement, $updateData);
            }

            if (isset($data['items']) && is_array($data['items'])) {
                $itemsPayload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
                $this->repo->syncItems($unitReplacement, $itemsPayload);
                $newValues['items_count'] = count($itemsPayload);
            }

            $this->auditService->log(
                $unitReplacement,
                'UNIT_REPLACEMENT_UPDATED',
                $userId,
                $oldValues,
                $newValues
            );

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }

    public function submit(string $uid, int $userId): UnitReplacement
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitReplacement = $this->repo->findByUid($uid);

            if (! $unitReplacement) {
                throw new \Exception('Unit replacement not found.');
            }

            if (! $unitReplacement->canSubmit()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot submit in {$unitReplacement->status->label()} status.",
                ]);
            }

            if (! $unitReplacement->replacement_date) {
                throw ValidationException::withMessages(['replacement_date' => 'Tanggal penggantian wajib diisi.']);
            }
            if (! $unitReplacement->cause) {
                throw ValidationException::withMessages(['cause' => 'Penyebab penggantian wajib diisi.']);
            }
            if ($unitReplacement->items->isEmpty()) {
                throw ValidationException::withMessages(['items' => 'Minimal 1 unit pengganti.']);
            }

            $levels = $this->flowService->getLevels('UnitReplacement');
            if ($levels->isEmpty()) {
                throw ValidationException::withMessages([
                    'approval' => 'Matriks approval untuk Unit Replacement belum diatur. Hubungi admin.',
                ]);
            }

            $first = $levels->first();
            UnitReplacementApproval::create([
                'unit_replacement_id' => $unitReplacement->id,
                'level' => $first->level_number,
                'approver_id' => null,
                'status' => 'pending',
            ]);

            $this->repo->update($unitReplacement, ['status' => UnitReplacementStatus::SUBMITTED]);

            $this->auditService->log(
                $unitReplacement,
                'UNIT_REPLACEMENT_SUBMITTED',
                $userId,
                ['status' => UnitReplacementStatus::DRAFT->value],
                ['status' => UnitReplacementStatus::SUBMITTED->value, 'approval_level' => $first->level_number]
            );

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }

    public function processApproval(string $uid, int $approverId, string $decision, ?string $remarks = null): UnitReplacement
    {
        return DB::transaction(function () use ($uid, $approverId, $decision, $remarks) {
            $unitReplacement = $this->repo->findByUid($uid);

            if (! $unitReplacement) {
                throw new \Exception('Unit replacement not found.');
            }

            if (! $unitReplacement->canApprove()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot approve in {$unitReplacement->status->label()} status.",
                ]);
            }

            $decision = strtolower($decision);
            if (! in_array($decision, ['approved', 'rejected'])) {
                throw ValidationException::withMessages(['decision' => 'Decision must be approved or rejected.']);
            }

            $pending = $unitReplacement->approvals()->where('status', 'pending')->orderBy('level')->first();
            if (! $pending) {
                throw ValidationException::withMessages(['approval' => 'Tidak ada approval pending.']);
            }
            $currentLevel = $pending->level;

            $pending->update([
                'approver_id' => $approverId,
                'status' => $decision,
                'remarks' => $remarks,
                'approved_at' => now(),
            ]);

            if ($decision === 'rejected') {
                $this->repo->update($unitReplacement, ['status' => UnitReplacementStatus::REJECTED]);
                $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_REJECTED', $approverId,
                    ['status' => UnitReplacementStatus::SUBMITTED->value],
                    ['status' => UnitReplacementStatus::REJECTED->value, 'level' => $currentLevel, 'remarks' => $remarks]
                );
                return $this->repo->findByUid($unitReplacement->uid);
            }

            $levels = $this->flowService->getLevels('UnitReplacement');
            $next = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($next) {
                UnitReplacementApproval::create([
                    'unit_replacement_id' => $unitReplacement->id,
                    'level' => $next->level_number,
                    'approver_id' => null,
                    'status' => 'pending',
                ]);
                $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_APPROVED_LEVEL', $approverId,
                    ['level' => $currentLevel],
                    ['next_level' => $next->level_number, 'remarks' => $remarks]
                );
            } else {
                $this->repo->update($unitReplacement, [
                    'status' => UnitReplacementStatus::APPROVED,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_APPROVED', $approverId,
                    ['status' => UnitReplacementStatus::SUBMITTED->value],
                    ['status' => UnitReplacementStatus::APPROVED->value, 'final_level' => $currentLevel, 'remarks' => $remarks]
                );
            }

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }

    public function forwardToWorkshop(string $uid, int $userId): UnitReplacement
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitReplacement = $this->repo->findByUid($uid);

            if (! $unitReplacement) {
                throw new \Exception('Unit replacement not found.');
            }

            if (! $unitReplacement->canForward()) {
                throw ValidationException::withMessages([
                    'status' => 'Unit replacement must be APPROVED before forwarding to workshop.',
                ]);
            }

            $this->repo->update($unitReplacement, ['status' => UnitReplacementStatus::FORWARDED_TO_WORKSHOP]);

            $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_FORWARDED', $userId,
                ['status' => UnitReplacementStatus::APPROVED->value],
                ['status' => UnitReplacementStatus::FORWARDED_TO_WORKSHOP->value]
            );

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }

    /**
     * Workshop decision: APPROVED_FROM_WORKSHOP atau REJECTED_FROM_WORKSHOP.
     * Untuk APPROVED: tandai original UR items sebagai replaced, set unit_ready/operator pada PTU items.
     *
     * @param array $itemsDecision  array of [id, unit_ready, operator_id, operator_name, remarks]
     */
    public function processWorkshopDecision(string $uid, int $userId, string $decision, array $itemsDecision = [], ?string $notes = null): UnitReplacement
    {
        return DB::transaction(function () use ($uid, $userId, $decision, $itemsDecision, $notes) {
            $unitReplacement = $this->repo->findByUid($uid);

            if (! $unitReplacement) {
                throw new \Exception('Unit replacement not found.');
            }

            if ($unitReplacement->status !== UnitReplacementStatus::FORWARDED_TO_WORKSHOP) {
                throw ValidationException::withMessages([
                    'status' => 'Status harus FORWARDED_TO_WORKSHOP untuk diputuskan workshop.',
                ]);
            }

            $decision = strtolower($decision);
            if (! in_array($decision, ['approved', 'rejected'])) {
                throw ValidationException::withMessages(['decision' => 'Decision must be approved or rejected.']);
            }

            if ($decision === 'rejected') {
                $this->repo->update($unitReplacement, [
                    'status' => UnitReplacementStatus::REJECTED_FROM_WORKSHOP,
                    'notes' => $notes ?? $unitReplacement->notes,
                ]);
                $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_WORKSHOP_REJECTED', $userId,
                    ['status' => UnitReplacementStatus::FORWARDED_TO_WORKSHOP->value],
                    ['status' => UnitReplacementStatus::REJECTED_FROM_WORKSHOP->value, 'notes' => $notes]
                );
                return $this->repo->findByUid($unitReplacement->uid);
            }

            // APPROVED — update tiap PTU item dengan unit_ready/operator dari workshop
            foreach ($itemsDecision as $row) {
                $item = $unitReplacement->items()->find($row['id'] ?? null);
                if (! $item) continue;

                $item->update([
                    'unit_ready' => $row['unit_ready'] ?? false,
                    'operator_id' => $row['operator_id'] ?? null,
                    'operator_name' => $row['operator_name'] ?? null,
                    'remarks' => $row['remarks'] ?? $item->remarks,
                ]);

                // Tandai original UR item sebagai replaced
                if ($item->originalUnitRequestItem) {
                    $item->originalUnitRequestItem->update([
                        'replaced_at' => now(),
                        'replaced_by_item_id' => $item->id,
                    ]);
                }
            }

            $this->repo->update($unitReplacement, [
                'status' => UnitReplacementStatus::APPROVED_FROM_WORKSHOP,
                'notes' => $notes ?? $unitReplacement->notes,
            ]);

            $this->auditService->log($unitReplacement, 'UNIT_REPLACEMENT_WORKSHOP_APPROVED', $userId,
                ['status' => UnitReplacementStatus::FORWARDED_TO_WORKSHOP->value],
                ['status' => UnitReplacementStatus::APPROVED_FROM_WORKSHOP->value, 'items_count' => count($itemsDecision)]
            );

            return $this->repo->findByUid($unitReplacement->uid);
        });
    }
}
