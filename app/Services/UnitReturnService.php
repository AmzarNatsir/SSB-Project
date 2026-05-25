<?php

namespace App\Services;

use App\Enums\ProjectUnitReturnStatus;
use App\Models\ProjectUnitReturn;
use App\Models\ProjectUnitReturnApproval;
use App\Models\UnitRequestItem;
use App\Repositories\Interfaces\IUnitReturnRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UnitReturnService
{
    public function __construct(
        protected IUnitReturnRepository $repo,
        protected AuditService $auditService,
        protected ApprovalFlowService $flowService,
    ) {}

    protected function handleFileUpload(UploadedFile $file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('unit-returns/attachments', $filename, 'private');
    }

    /**
     * Snapshot UR item ke array untuk insert PPU item.
     */
    protected function buildItemPayload(array $rawItem): array
    {
        $original = UnitRequestItem::findOrFail($rawItem['original_unit_request_item_id']);

        return [
            'original_unit_request_item_id' => $original->id,
            'unit_name'      => $original->unit_name,
            'equipment_code' => $original->equipment_id ? (string) $original->equipment_id : null,
            'qty'            => $rawItem['qty'] ?? $original->qty,
            'operator_id'    => $original->operator_id,
            'operator_name'  => $original->operator_name,
            'notes'          => $rawItem['notes'] ?? null,
        ];
    }

    public function create(array $data, int $userId): ProjectUnitReturn
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
                throw new \Exception('Minimal pilih 1 unit yang akan dikembalikan.');
            }

            foreach ($data['items'] as $row) {
                $found = $unitRequest->items
                    ->where('id', $row['original_unit_request_item_id'])
                    ->first();
                if (! $found) {
                    throw new \Exception('Salah satu unit yang dipilih tidak valid.');
                }
                $remaining = $found->remainingQty();
                if ($remaining <= 0) {
                    throw new \Exception("Unit '{$found->unit_name}' sudah dikembalikan penuh.");
                }
                $reqQty = (float) ($row['qty'] ?? 0);
                if ($reqQty <= 0) {
                    throw new \Exception("Qty pengembalian untuk '{$found->unit_name}' wajib > 0.");
                }
                if ($reqQty > $remaining) {
                    throw new \Exception("Qty pengembalian '{$found->unit_name}' melebihi sisa (".rtrim(rtrim(number_format($remaining, 2, '.', ''), '0'), '.').").");
                }
            }

            $attachmentPath = null;
            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $attachmentPath = $this->handleFileUpload($data['attachment']);
            }

            $unitReturn = $this->repo->create([
                'project_id'          => $data['project_id'],
                'unit_request_id'     => $unitRequest->id,
                'contract_id'         => $unitRequest->contract_id,
                'return_date'         => $data['return_date'],
                'demobilization_date' => $data['demobilization_date'] ?? null,
                'notes'               => $data['notes'] ?? null,
                'attachment_path'     => $attachmentPath,
                'status'              => ProjectUnitReturnStatus::DRAFT,
                'created_by'          => $userId,
            ]);

            $payload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
            $this->repo->createItems($unitReturn, $payload);

            $this->auditService->log(
                $unitReturn,
                'UNIT_RETURN_CREATED',
                $userId,
                [],
                [
                    'ppu_number'      => $unitReturn->ppu_number,
                    'project_id'      => $unitReturn->project_id,
                    'unit_request_id' => $unitRequest->id,
                    'items_count'     => count($payload),
                ]
            );

            return $this->repo->findByUid($unitReturn->uid);
        });
    }

    public function update(string $uid, array $data, int $userId): ProjectUnitReturn
    {
        return DB::transaction(function () use ($uid, $data, $userId) {
            $unitReturn = $this->repo->findByUid($uid);

            if (! $unitReturn) {
                throw new \Exception('Unit return not found.');
            }

            if (! $unitReturn->isEditable()) {
                throw new \Exception("Cannot edit in {$unitReturn->status->label()} status.");
            }

            $updateData = [];
            $oldValues = [];
            $newValues = [];

            foreach (['return_date', 'demobilization_date', 'notes'] as $field) {
                if (array_key_exists($field, $data)) {
                    $oldValues[$field] = $unitReturn->$field instanceof \DateTimeInterface
                        ? $unitReturn->$field->format('Y-m-d')
                        : $unitReturn->$field;
                    $updateData[$field] = $data[$field];
                    $newValues[$field] = $data[$field];
                }
            }

            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $oldValues['attachment_path'] = $unitReturn->attachment_path;
                $updateData['attachment_path'] = $this->handleFileUpload($data['attachment']);
                $newValues['attachment_path'] = $updateData['attachment_path'];
            }

            if (! empty($updateData)) {
                $this->repo->update($unitReturn, $updateData);
            }

            if (isset($data['items']) && is_array($data['items'])) {
                $payload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
                $this->repo->syncItems($unitReturn, $payload);
                $newValues['items_count'] = count($payload);
            }

            $this->auditService->log(
                $unitReturn,
                'UNIT_RETURN_UPDATED',
                $userId,
                $oldValues,
                $newValues
            );

            return $this->repo->findByUid($unitReturn->uid);
        });
    }

    public function submit(string $uid, int $userId): ProjectUnitReturn
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitReturn = $this->repo->findByUid($uid);

            if (! $unitReturn) {
                throw new \Exception('Unit return not found.');
            }

            if (! $unitReturn->canSubmit()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot submit in {$unitReturn->status->label()} status.",
                ]);
            }

            if (! $unitReturn->return_date) {
                throw ValidationException::withMessages(['return_date' => 'Tanggal pengembalian wajib diisi.']);
            }
            if ($unitReturn->items->isEmpty()) {
                throw ValidationException::withMessages(['items' => 'Minimal 1 unit pengembalian.']);
            }

            $levels = $this->flowService->getLevels('UnitReturn');
            if ($levels->isEmpty()) {
                throw ValidationException::withMessages([
                    'approval' => 'Matriks approval untuk PPU belum diatur. Hubungi admin.',
                ]);
            }

            $first = $levels->first();
            ProjectUnitReturnApproval::create([
                'unit_return_id' => $unitReturn->id,
                'level'          => $first->level_number,
                'approver_id'    => null,
                'status'         => 'pending',
            ]);

            $this->repo->update($unitReturn, ['status' => ProjectUnitReturnStatus::SUBMITTED]);

            $this->auditService->log(
                $unitReturn,
                'UNIT_RETURN_SUBMITTED',
                $userId,
                ['status' => ProjectUnitReturnStatus::DRAFT->value],
                ['status' => ProjectUnitReturnStatus::SUBMITTED->value, 'approval_level' => $first->level_number]
            );

            return $this->repo->findByUid($unitReturn->uid);
        });
    }

    public function processApproval(string $uid, int $approverId, string $decision, ?string $remarks = null): ProjectUnitReturn
    {
        return DB::transaction(function () use ($uid, $approverId, $decision, $remarks) {
            $unitReturn = $this->repo->findByUid($uid);

            if (! $unitReturn) {
                throw new \Exception('Unit return not found.');
            }

            if (! $unitReturn->canApprove()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot approve in {$unitReturn->status->label()} status.",
                ]);
            }

            $decision = strtolower($decision);
            if (! in_array($decision, ['approved', 'rejected'])) {
                throw ValidationException::withMessages(['decision' => 'Decision must be approved or rejected.']);
            }

            $pending = $unitReturn->approvals()->where('status', 'pending')->orderBy('level')->first();
            if (! $pending) {
                throw ValidationException::withMessages(['approval' => 'Tidak ada approval pending.']);
            }
            $currentLevel = $pending->level;

            $pending->update([
                'approver_id' => $approverId,
                'status'      => $decision,
                'remarks'     => $remarks,
                'approved_at' => now(),
            ]);

            if ($decision === 'rejected') {
                $this->repo->update($unitReturn, ['status' => ProjectUnitReturnStatus::REJECTED]);
                $this->auditService->log($unitReturn, 'UNIT_RETURN_REJECTED', $approverId,
                    ['status' => ProjectUnitReturnStatus::SUBMITTED->value],
                    ['status' => ProjectUnitReturnStatus::REJECTED->value, 'level' => $currentLevel, 'remarks' => $remarks]
                );
                return $this->repo->findByUid($unitReturn->uid);
            }

            $levels = $this->flowService->getLevels('UnitReturn');
            $next = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($next) {
                ProjectUnitReturnApproval::create([
                    'unit_return_id' => $unitReturn->id,
                    'level'          => $next->level_number,
                    'approver_id'    => null,
                    'status'         => 'pending',
                ]);
                $this->auditService->log($unitReturn, 'UNIT_RETURN_APPROVED_LEVEL', $approverId,
                    ['level' => $currentLevel],
                    ['next_level' => $next->level_number, 'remarks' => $remarks]
                );
            } else {
                $this->repo->update($unitReturn, [
                    'status'      => ProjectUnitReturnStatus::APPROVED,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->auditService->log($unitReturn, 'UNIT_RETURN_APPROVED', $approverId,
                    ['status' => ProjectUnitReturnStatus::SUBMITTED->value],
                    ['status' => ProjectUnitReturnStatus::APPROVED->value, 'final_level' => $currentLevel, 'remarks' => $remarks]
                );
            }

            return $this->repo->findByUid($unitReturn->uid);
        });
    }

    /**
     * Tandai PPU sebagai COMPLETED dan flag UR items sebagai returned.
     */
    public function complete(string $uid, int $userId): ProjectUnitReturn
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitReturn = $this->repo->findByUid($uid);

            if (! $unitReturn) {
                throw new \Exception('Unit return not found.');
            }

            if (! $unitReturn->canComplete()) {
                throw ValidationException::withMessages([
                    'status' => 'PPU di status ini tidak bisa di-complete.',
                ]);
            }

            if ($unitReturn->items->isEmpty()) {
                throw ValidationException::withMessages(['items' => 'PPU tidak memiliki item.']);
            }

            foreach ($unitReturn->items as $item) {
                $ur = $item->originalUnitRequestItem;
                if (! $ur) continue;

                $newReturned = (float) $ur->returned_qty + (float) $item->qty;
                $payload = ['returned_qty' => $newReturned];
                if ($newReturned >= (float) $ur->qty) {
                    $payload['returned_at'] = now();
                    $payload['returned_by_item_id'] = $item->id;
                }
                $ur->update($payload);
            }

            $previousStatus = $unitReturn->status->value;
            $this->repo->update($unitReturn, ['status' => ProjectUnitReturnStatus::COMPLETED]);

            $this->auditService->log($unitReturn, 'UNIT_RETURN_COMPLETED', $userId,
                ['status' => $previousStatus],
                ['status' => ProjectUnitReturnStatus::COMPLETED->value, 'items_count' => $unitReturn->items->count()]
            );

            return $this->repo->findByUid($unitReturn->uid);
        });
    }
}
