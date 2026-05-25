<?php

namespace App\Services;

use App\Enums\UnitTransferStatus;
use App\Enums\UnitRequestStatus;
use App\Models\UnitRequest;
use App\Models\UnitRequestItem;
use App\Models\UnitTransfer;
use App\Repositories\Interfaces\IUnitTransferRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UnitTransferService
{
    public function __construct(
        protected IUnitTransferRepository $repo,
        protected AuditService $auditService,
    ) {}

    protected function handleFileUpload(UploadedFile $file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('unit-transfers/attachments', $filename, 'private');
    }

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

    public function create(array $data, int $userId): UnitTransfer
    {
        return DB::transaction(function () use ($data, $userId) {
            if ($data['source_project_id'] == $data['destination_project_id']) {
                throw new \Exception('Project tujuan harus berbeda dengan project asal.');
            }

            $unitRequest = \App\Models\UnitRequest::with('items')
                ->where('id', $data['source_unit_request_id'])
                ->where('project_id', $data['source_project_id'])
                ->where('status', \App\Enums\UnitRequestStatus::APPROVED_FROM_WORKSHOP)
                ->first();

            if (! $unitRequest) {
                throw new \Exception('Unit Request sumber tidak valid atau bukan milik project asal.');
            }

            if (empty($data['items']) || ! is_array($data['items'])) {
                throw new \Exception('Minimal pilih 1 unit yang akan ditransfer.');
            }

            foreach ($data['items'] as $row) {
                $found = $unitRequest->items->firstWhere('id', $row['original_unit_request_item_id']);
                if (! $found) {
                    throw new \Exception('Salah satu unit yang dipilih tidak valid.');
                }
                $remaining = $found->remainingQty();
                if ($remaining <= 0) {
                    throw new \Exception("Unit '{$found->unit_name}' sudah habis (returned/transferred penuh).");
                }
                $reqQty = (float) ($row['qty'] ?? 0);
                if ($reqQty <= 0) {
                    throw new \Exception("Qty transfer untuk '{$found->unit_name}' wajib > 0.");
                }
                if ($reqQty > $remaining) {
                    throw new \Exception("Qty transfer '{$found->unit_name}' melebihi sisa (".rtrim(rtrim(number_format($remaining, 2, '.', ''), '0'), '.').").");
                }
            }

            $attachmentPath = null;
            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $attachmentPath = $this->handleFileUpload($data['attachment']);
            }

            $unitTransfer = $this->repo->create([
                'source_project_id'      => $data['source_project_id'],
                'source_unit_request_id' => $unitRequest->id,
                'destination_project_id' => $data['destination_project_id'],
                'transfer_date'          => $data['transfer_date'],
                'notes'                  => $data['notes'] ?? null,
                'attachment_path'        => $attachmentPath,
                'status'                 => UnitTransferStatus::DRAFT,
                'created_by'             => $userId,
            ]);

            $payload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
            $this->repo->createItems($unitTransfer, $payload);

            $this->auditService->log(
                $unitTransfer,
                'UNIT_TRANSFER_CREATED',
                $userId,
                [],
                [
                    'transfer_number'        => $unitTransfer->transfer_number,
                    'source_project_id'      => $unitTransfer->source_project_id,
                    'destination_project_id' => $unitTransfer->destination_project_id,
                    'items_count'            => count($payload),
                ]
            );

            return $this->repo->findByUid($unitTransfer->uid);
        });
    }

    public function update(string $uid, array $data, int $userId): UnitTransfer
    {
        return DB::transaction(function () use ($uid, $data, $userId) {
            $unitTransfer = $this->repo->findByUid($uid);

            if (! $unitTransfer) {
                throw new \Exception('Unit transfer not found.');
            }

            if (! $unitTransfer->isEditable()) {
                throw new \Exception("Tidak bisa edit di status {$unitTransfer->status->label()}.");
            }

            $updateData = [];
            $oldValues = [];
            $newValues = [];

            foreach (['transfer_date', 'notes', 'destination_project_id'] as $field) {
                if (array_key_exists($field, $data)) {
                    $oldValues[$field] = $unitTransfer->$field instanceof \DateTimeInterface
                        ? $unitTransfer->$field->format('Y-m-d')
                        : $unitTransfer->$field;
                    $updateData[$field] = $data[$field];
                    $newValues[$field] = $data[$field];
                }
            }

            if (isset($updateData['destination_project_id'])
                && $updateData['destination_project_id'] == $unitTransfer->source_project_id) {
                throw new \Exception('Project tujuan harus berbeda dengan project asal.');
            }

            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $oldValues['attachment_path'] = $unitTransfer->attachment_path;
                $updateData['attachment_path'] = $this->handleFileUpload($data['attachment']);
                $newValues['attachment_path'] = $updateData['attachment_path'];
            }

            if (! empty($updateData)) {
                $this->repo->update($unitTransfer, $updateData);
            }

            if (isset($data['items']) && is_array($data['items'])) {
                $payload = array_map(fn ($r) => $this->buildItemPayload($r), $data['items']);
                $this->repo->syncItems($unitTransfer, $payload);
                $newValues['items_count'] = count($payload);
            }

            $this->auditService->log(
                $unitTransfer,
                'UNIT_TRANSFER_UPDATED',
                $userId,
                $oldValues,
                $newValues
            );

            return $this->repo->findByUid($unitTransfer->uid);
        });
    }

    /**
     * Tandai UT sebagai COMPLETED dan flag UR items sebagai transferred.
     */
    public function complete(string $uid, int $userId): UnitTransfer
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitTransfer = $this->repo->findByUid($uid);

            if (! $unitTransfer) {
                throw new \Exception('Unit transfer not found.');
            }

            if (! $unitTransfer->canComplete()) {
                throw ValidationException::withMessages([
                    'status' => 'UT di status ini tidak bisa di-complete.',
                ]);
            }

            if ($unitTransfer->items->isEmpty()) {
                throw ValidationException::withMessages(['items' => 'UT tidak memiliki item.']);
            }

            foreach ($unitTransfer->items as $item) {
                $ur = $item->originalUnitRequestItem;
                if (! $ur) continue;

                $newTransferred = (float) $ur->transferred_qty + (float) $item->qty;
                $payload = ['transferred_qty' => $newTransferred];
                if (($newTransferred + (float) $ur->returned_qty) >= (float) $ur->qty) {
                    $payload['transferred_at'] = now();
                    $payload['transferred_by_item_id'] = $item->id;
                }
                $ur->update($payload);
            }

            $destinationUnitRequest = $this->spawnDestinationUnitRequest($unitTransfer, $userId);

            $previousStatus = $unitTransfer->status->value;
            $this->repo->update($unitTransfer, ['status' => UnitTransferStatus::COMPLETED]);

            $this->auditService->log($unitTransfer, 'UNIT_TRANSFER_COMPLETED', $userId,
                ['status' => $previousStatus],
                [
                    'status' => UnitTransferStatus::COMPLETED->value,
                    'items_count' => $unitTransfer->items->count(),
                    'destination_unit_request_id' => $destinationUnitRequest->id,
                    'destination_unit_request_number' => $destinationUnitRequest->request_number,
                ]
            );

            return $this->repo->findByUid($unitTransfer->uid);
        });
    }

    /**
     * Buat UnitRequest sintetis di project tujuan agar unit hasil transfer
     * langsung tampil sebagai deployed unit & dapat di-trace (PPU/PTU/UT lanjutan).
     */
    protected function spawnDestinationUnitRequest(UnitTransfer $unitTransfer, int $userId): UnitRequest
    {
        $requestNumber = $this->generateTransferRequestNumber();

        $destinationUr = UnitRequest::create([
            'project_id'              => $unitTransfer->destination_project_id,
            'quotation_id'            => null,
            'negotiation_id'          => null,
            'contract_id'             => null,
            'request_number'          => $requestNumber,
            'request_date'            => $unitTransfer->transfer_date,
            'mobilization_date'       => $unitTransfer->transfer_date,
            'status'                  => UnitRequestStatus::APPROVED_FROM_WORKSHOP,
            'origin'                  => 'TRANSFER',
            'source_unit_transfer_id' => $unitTransfer->id,
            'notes'                   => 'Otomatis dari mutasi ' . $unitTransfer->transfer_number
                                         . ($unitTransfer->notes ? ' — ' . $unitTransfer->notes : ''),
            'created_by'              => $userId,
            'approved_by'             => $userId,
            'approved_at'             => now(),
        ]);

        foreach ($unitTransfer->items as $utItem) {
            $sourceItem = $utItem->originalUnitRequestItem;
            UnitRequestItem::create([
                'unit_request_id'              => $destinationUr->id,
                'quotation_item_id'            => null,
                'contract_item_id'             => null,
                'equipment_id'                 => $sourceItem?->equipment_id,
                'unit_name'                    => $utItem->unit_name,
                'qty'                          => $utItem->qty,
                'duration_days'                => $sourceItem?->duration_days,
                'remarks'                      => 'Asal: ' . ($unitTransfer->sourceProject->project_number ?? '-')
                                                  . ' / ' . ($unitTransfer->sourceUnitRequest->request_number ?? '-'),
                'unit_ready'                   => true,
                'operator_id'                  => $utItem->operator_id,
                'operator_name'                => $utItem->operator_name,
                'source_unit_transfer_item_id' => $utItem->id,
            ]);
        }

        return $destinationUr;
    }

    protected function generateTransferRequestNumber(): string
    {
        $year = date('Y');
        $count = UnitRequest::whereYear('created_at', $year)
            ->where('origin', 'TRANSFER')
            ->count() + 1;

        do {
            $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);
            $number = "UR-MUT/{$year}/{$sequence}";
            $count++;
        } while (UnitRequest::where('request_number', $number)->exists());

        return $number;
    }
}
