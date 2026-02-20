<?php

namespace App\Services;

use App\Enums\UnitRequestStatus;
use App\Models\UnitRequest;
use App\Repositories\Interfaces\IUnitRequestRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UnitRequestService
{
    protected IUnitRequestRepository $repo;
    protected AuditService $auditService;
    protected ApprovalFlowService $flowService;

    public function __construct(
        IUnitRequestRepository $repo,
        AuditService $auditService,
        ApprovalFlowService $flowService
    ) {
        $this->repo = $repo;
        $this->auditService = $auditService;
        $this->flowService = $flowService;
    }

    /**
     * Generate a unique request number in format UR/YYYY/NNN
     * where YYYY is the current year and NNN is a zero-padded sequential number.
     * Handles collision by retrying with incremented sequence number.
     */
    protected function generateRequestNumber(): string
    {
        $year = date('Y');
        $count = UnitRequest::whereYear('created_at', $year)->count() + 1;
        $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);
        $number = "UR/{$year}/{$sequence}";

        // Handle collision (race condition)
        while (UnitRequest::where('request_number', $number)->exists()) {
            $count++;
            $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);
            $number = "UR/{$year}/{$sequence}";
        }

        return $number;
    }

    /**
     * Handle file upload for attachment.
     * Stores file in private disk at unit-requests/attachments/ directory.
     *
     * @param UploadedFile $file
     * @return string The storage path
     */
    protected function handleFileUpload(UploadedFile $file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('unit-requests/attachments', $filename, 'private');

        return $path;
    }

    /**
     * Validate status transition using enum's canTransitionTo() method.
     * Throws ValidationException if transition is invalid.
     *
     * @param UnitRequest $unitRequest
     * @param UnitRequestStatus $newStatus
     * @throws ValidationException
     */
    protected function validateStatusTransition(UnitRequest $unitRequest, UnitRequestStatus $newStatus): void
    {
        if (!$unitRequest->status->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => "Cannot transition from {$unitRequest->status->label()} to {$newStatus->label()}."
            ]);
        }
    }

    /**
     * Create a new unit request.
     *
     * Validates project has APPROVED negotiation, generates unique request_number,
     * creates unit_request with status DRAFT, retrieves quotation through negotiation,
     * populates unit_request_items from quotation_items, handles attachment upload,
     * and logs creation action.
     *
     * @param array $data Request data including project_id, request_date, mobilization_date, notes, attachment
     * @param int $userId The ID of the user creating the request
     * @return UnitRequest The created unit request
     * @throws \Exception If project doesn't have APPROVED negotiation or quotation has no items
     */
    public function create(array $data, int $userId): UnitRequest
    {
        return DB::transaction(function () use ($data, $userId) {
            // Validate project has APPROVED negotiation
            $project = \App\Models\Project::with(['negotiations' => function ($query) {
                $query->where('status', \App\Enums\NegotiationStatus::APPROVED)
                      ->with('quotation.items');
            }])->findOrFail($data['project_id']);

            $approvedNegotiation = $project->negotiations->first();

            if (!$approvedNegotiation) {
                throw new \Exception("Project does not have an APPROVED negotiation.");
            }

            // Retrieve quotation through negotiation relationship
            $quotation = $approvedNegotiation->quotation;

            if (!$quotation) {
                throw new \Exception("Negotiation does not have an associated quotation.");
            }

            // Validate quotation has items
            if ($quotation->items->isEmpty()) {
                throw new \Exception("Cannot create unit request: quotation has no items.");
            }

            // Generate unique request_number
            $requestNumber = $this->generateRequestNumber();

            // Handle attachment upload if provided
            $attachmentPath = null;
            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $attachmentPath = $this->handleFileUpload($data['attachment']);
            }

            // Create unit_request with status DRAFT
            $unitRequest = $this->repo->create([
                'uid' => (string) Str::uuid(),
                'project_id' => $data['project_id'],
                'quotation_id' => $quotation->id,
                'negotiation_id' => $approvedNegotiation->id,
                'request_number' => $requestNumber,
                'request_date' => $data['request_date'],
                'mobilization_date' => $data['mobilization_date'],
                'status' => UnitRequestStatus::DRAFT,
                'notes' => $data['notes'] ?? null,
                'attachment_path' => $attachmentPath,
                'created_by' => $userId,
            ]);

            // Populate unit_request_items from quotation_items
            $items = [];
            foreach ($quotation->items as $quotationItem) {
                $items[] = [
                    'quotation_item_id' => $quotationItem->id,
                    'equipment_id' => $quotationItem->unit_id ?? null, // Map unit_id to equipment_id
                    'unit_name' => $quotationItem->unit_name,
                    'qty' => (int) $quotationItem->quantity,
                    'duration_days' => $quotationItem->duration ? (int) $quotationItem->duration : null,
                    'remarks' => null, // User can add remarks later
                ];
            }

            $this->repo->createItems($unitRequest, $items);

            // Log creation action using AuditService
            $this->auditService->log(
                $unitRequest,
                'UNIT_REQUEST_CREATED',
                $userId,
                [],
                [
                    'request_number' => $requestNumber,
                    'project_id' => $data['project_id'],
                    'items_count' => count($items)
                ]
            );

            // Reload with relationships
            return $this->repo->findByUid($unitRequest->uid);
        });
    }

    /**
     * Update an existing unit request.
     *
     * Validates unit request is editable (status: draft or rejected),
     * updates request_date, mobilization_date, notes if provided,
     * handles attachment upload if provided, updates unit_request_items if provided,
     * and logs update action.
     *
     * @param string $uid The UID of the unit request to update
     * @param array $data Update data including request_date, mobilization_date, notes, attachment, items
     * @param int $userId The ID of the user updating the request
     * @return UnitRequest The updated unit request
     * @throws \Exception If unit request is not editable
     */
    public function update(string $uid, array $data, int $userId): UnitRequest
    {
        return DB::transaction(function () use ($uid, $data, $userId) {
            // Find unit request
            $unitRequest = $this->repo->findByUid($uid);

            if (!$unitRequest) {
                throw new \Exception("Unit request not found.");
            }

            // Validate unit request is editable (status: draft or rejected)
            if (!$unitRequest->isEditable()) {
                throw new \Exception("Unit request cannot be edited in {$unitRequest->status->label()} status.");
            }

            $updateData = [];
            $oldValues = [];
            $newValues = [];

            // Update request_date if provided
            if (isset($data['request_date'])) {
                $oldValues['request_date'] = $unitRequest->request_date?->format('Y-m-d');
                $updateData['request_date'] = $data['request_date'];
                $newValues['request_date'] = $data['request_date'];
            }

            // Update mobilization_date if provided
            if (isset($data['mobilization_date'])) {
                $oldValues['mobilization_date'] = $unitRequest->mobilization_date?->format('Y-m-d');
                $updateData['mobilization_date'] = $data['mobilization_date'];
                $newValues['mobilization_date'] = $data['mobilization_date'];
            }

            // Update notes if provided
            if (isset($data['notes'])) {
                $oldValues['notes'] = $unitRequest->notes;
                $updateData['notes'] = $data['notes'];
                $newValues['notes'] = $data['notes'];
            }

            // Handle attachment upload if provided
            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $oldValues['attachment_path'] = $unitRequest->attachment_path;
                $attachmentPath = $this->handleFileUpload($data['attachment']);
                $updateData['attachment_path'] = $attachmentPath;
                $newValues['attachment_path'] = $attachmentPath;
            }

            // Update unit request
            if (!empty($updateData)) {
                $this->repo->update($unitRequest, $updateData);
            }

            // Update unit_request_items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                $oldValues['items_count'] = $unitRequest->items->count();
                $this->repo->updateItems($unitRequest, $data['items']);
                $newValues['items_count'] = count($data['items']);
            }

            // Log update action using AuditService
            $this->auditService->log(
                $unitRequest,
                'UNIT_REQUEST_UPDATED',
                $userId,
                $oldValues,
                $newValues
            );

            // Reload with relationships
            return $this->repo->findByUid($unitRequest->uid);
        });
    }

    /**
     * Submit a unit request for approval.
     *
     * Validates unit request is in DRAFT or REJECTED status, validates required fields,
     * retrieves approval flow for code 'UnitRequest', creates approval records or auto-approves,
     * updates status to SUBMITTED, fires UnitRequestSubmitted event, and logs submission action.
     *
     * @param string $uid The UID of the unit request to submit
     * @param int $userId The ID of the user submitting the request
     * @return UnitRequest The submitted unit request
     * @throws \Exception If validation fails or unit request cannot be submitted
     */
    public function submit(string $uid, int $userId): UnitRequest
    {
        return DB::transaction(function () use ($uid, $userId) {
            // Find unit request
            $unitRequest = $this->repo->findByUid($uid);

            if (!$unitRequest) {
                throw new \Exception("Unit request not found.");
            }

            // Validate unit request is in DRAFT or REJECTED status
            if (!$unitRequest->canSubmit()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot submit unit request in {$unitRequest->status->label()} status."
                ]);
            }

            // Validate required fields: request_date, mobilization_date, at least one item
            if (!$unitRequest->request_date) {
                throw ValidationException::withMessages([
                    'request_date' => 'Request date is required.'
                ]);
            }

            if (!$unitRequest->mobilization_date) {
                throw ValidationException::withMessages([
                    'mobilization_date' => 'Mobilization date is required.'
                ]);
            }

            if ($unitRequest->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'items' => 'At least one unit request item is required.'
                ]);
            }

            // Retrieve approval flow for code 'UnitRequest' using ApprovalFlowService
            $approvalFlow = $this->flowService->getFlowByCode('UnitRequest');
            $approvalLevels = $approvalFlow ? $approvalFlow->levels()->orderBy('level_number')->get() : collect();

            // If no approval levels: auto-approve
            if ($approvalLevels->isEmpty()) {
                $this->repo->update($unitRequest, [
                    'status' => UnitRequestStatus::APPROVED,
                    'approved_by' => $userId,
                    'approved_at' => now(),
                ]);

                // Log auto-approval action
                $this->auditService->log(
                    $unitRequest,
                    'UNIT_REQUEST_AUTO_APPROVED',
                    $userId,
                    ['status' => UnitRequestStatus::DRAFT->value],
                    ['status' => UnitRequestStatus::APPROVED->value]
                );
            } else {
                // If approval levels exist: create first level approval record with status pending
                $firstLevel = $approvalLevels->first();

                \App\Models\UnitRequestApproval::create([
                    'unit_request_id' => $unitRequest->id,
                    'level' => $firstLevel->level_number,
                    'approver_id' => null, // Will be determined by approver_type
                    'status' => 'pending',
                    'remarks' => null,
                    'approved_at' => null,
                ]);

                // Update status to SUBMITTED
                $this->repo->update($unitRequest, [
                    'status' => UnitRequestStatus::SUBMITTED,
                ]);

                // Log submission action
                $this->auditService->log(
                    $unitRequest,
                    'UNIT_REQUEST_SUBMITTED',
                    $userId,
                    ['status' => $unitRequest->status === UnitRequestStatus::REJECTED ? UnitRequestStatus::REJECTED->value : UnitRequestStatus::DRAFT->value],
                    ['status' => UnitRequestStatus::SUBMITTED->value, 'approval_level' => $firstLevel->level_number]
                );
            }

            // Fire UnitRequestSubmitted event
            event(new \App\Events\UnitRequestSubmitted($unitRequest));

            // Reload with relationships
            return $this->repo->findByUid($unitRequest->uid);
        });
    }


    /**
     * Process approval decision for a unit request.
     *
     * @param string $uid
     * @param int $approverId
     * @param string $decision  'approved' or 'rejected'
     * @param string|null $remarks
     * @return UnitRequest
     * @throws \Exception|\Illuminate\Validation\ValidationException
     */
    public function processApproval(string $uid, int $approverId, string $decision, ?string $remarks = null): UnitRequest
    {
        return DB::transaction(function () use ($uid, $approverId, $decision, $remarks) {
            $unitRequest = $this->repo->findByUid($uid);

            if (!$unitRequest) {
                throw new \Exception("Unit request not found.");
            }

            if (!$unitRequest->canApprove()) {
                throw ValidationException::withMessages([
                    'status' => "Cannot approve/reject a unit request in {$unitRequest->status->label()} status."
                ]);
            }

            $decision = strtolower($decision);

            if (!in_array($decision, ['approved', 'rejected'])) {
                throw ValidationException::withMessages([
                    'decision' => 'Decision must be either approved or rejected.'
                ]);
            }

            // Update pending approval record
            $pendingApproval = $unitRequest->approvals()->where('status', 'pending')->first();
            if ($pendingApproval) {
                $pendingApproval->update([
                    'approver_id'  => $approverId,
                    'status'       => $decision,
                    'remarks'      => $remarks,
                    'approved_at'  => now(),
                ]);
            }

            if ($decision === 'approved') {
                $this->repo->update($unitRequest, [
                    'status'      => UnitRequestStatus::APPROVED,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);

                $this->auditService->log(
                    $unitRequest,
                    'UNIT_REQUEST_APPROVED',
                    $approverId,
                    ['status' => UnitRequestStatus::SUBMITTED->value],
                    ['status' => UnitRequestStatus::APPROVED->value, 'remarks' => $remarks]
                );

                // Fire UnitRequestApproved event
                event(new \App\Events\UnitRequestApproved($unitRequest));
            } else {
                $this->repo->update($unitRequest, [
                    'status' => UnitRequestStatus::REJECTED,
                ]);

                $this->auditService->log(
                    $unitRequest,
                    'UNIT_REQUEST_REJECTED',
                    $approverId,
                    ['status' => UnitRequestStatus::SUBMITTED->value],
                    ['status' => UnitRequestStatus::REJECTED->value, 'remarks' => $remarks]
                );
            }

            return $this->repo->findByUid($unitRequest->uid);
        });
    }

    /**
     * Forward an approved unit request to the workshop.
     *
     * @param string $uid
     * @param int $userId
     * @return UnitRequest
     * @throws \Exception|\Illuminate\Validation\ValidationException
     */
    public function forwardToWorkshop(string $uid, int $userId): UnitRequest
    {
        return DB::transaction(function () use ($uid, $userId) {
            $unitRequest = $this->repo->findByUid($uid);

            if (!$unitRequest) {
                throw new \Exception("Unit request not found.");
            }

            if (!$unitRequest->canForward()) {
                throw ValidationException::withMessages([
                    'status' => "Unit request must be APPROVED before forwarding to workshop."
                ]);
            }

            $this->repo->update($unitRequest, [
                'status' => UnitRequestStatus::FORWARDED_TO_WORKSHOP,
            ]);

            $this->auditService->log(
                $unitRequest,
                'UNIT_REQUEST_FORWARDED',
                $userId,
                ['status' => UnitRequestStatus::APPROVED->value],
                ['status' => UnitRequestStatus::FORWARDED_TO_WORKSHOP->value]
            );

            return $this->repo->findByUid($unitRequest->uid);
        });
    }
}

