<?php

namespace App\Http\Controllers;

use App\Enums\UnitRequestStatus;
use App\Http\Requests\UnitRequest\ApproveUnitRequestRequest;
use App\Http\Requests\UnitRequest\StoreUnitRequestRequest;
use App\Http\Requests\UnitRequest\UpdateUnitRequestRequest;
use App\Models\UnitRequest;
use App\Repositories\Interfaces\IUnitRequestRepository;
use App\Services\UnitRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitRequestController extends Controller
{
    protected UnitRequestService $service;
    protected IUnitRequestRepository $repo;

    public function __construct(UnitRequestService $service, IUnitRequestRepository $repo)
    {
        $this->service = $service;
        $this->repo    = $repo;
    }

    /**
     * Display listing of unit requests with KPI metrics.
     */
    public function index()
    {
        $unitRequests = UnitRequest::with(['project', 'creator'])
            ->latest()
            ->paginate(15);

        $totalCount     = UnitRequest::count();
        $submittedCount = UnitRequest::where('status', UnitRequestStatus::SUBMITTED)->count();
        $approvedCount  = UnitRequest::where('status', UnitRequestStatus::APPROVED)->count();
        $forwardedCount = UnitRequest::where('status', UnitRequestStatus::FORWARDED_TO_WORKSHOP)->count();

        return view('unit-requests.index', compact(
            'unitRequests',
            'totalCount',
            'submittedCount',
            'approvedCount',
            'forwardedCount'
        ));
    }

    /**
     * Show the create form with eligible projects (yang punya Kontrak ACTIVE belum dipakai).
     */
    public function create()
    {
        $eligibleProjects = $this->repo->getEligibleProjects();
        return view('unit-requests.create', compact('eligibleProjects'));
    }

    /**
     * AJAX: list kontrak ACTIVE milik project yang belum punya Permintaan Unit aktif.
     * Cascade dropdown di form create.
     */
    public function eligibleContracts(Request $request)
    {
        $projectId = $request->integer('project_id');
        if (! $projectId) {
            return response()->json(['data' => []]);
        }

        $contracts = $this->repo->getEligibleContracts($projectId)
            ->map(fn ($c) => [
                'id' => $c->id,
                'contract_number' => $c->contract_number,
                'start_date' => optional($c->start_date)->format('d M Y'),
                'end_date' => optional($c->end_date)->format('d M Y'),
                'items' => $c->items->map(fn ($it) => [
                    'id' => $it->id,
                    'unit_name' => $it->unit_name,
                    'equipment_code' => $it->equipment_code,
                    'qty' => (float) $it->qty,
                    'unit_price' => (float) $it->unit_price,
                    'total_price' => (float) $it->total_price,
                    'duration' => (float) $it->duration,
                    'duration_unit' => $it->duration_unit ?? 'MONTH',
                ])->values(),
            ])->values();

        return response()->json(['data' => $contracts]);
    }

    /**
     * Store a newly created unit request.
     */
    public function store(StoreUnitRequestRequest $request)
    {
        try {
            $unitRequest = $this->service->create(
                $request->validated(),
                auth()->id()
            );

            return redirect()
                ->route('unit-requests.show', $unitRequest->uid)
                ->with('success', 'Unit request #' . $unitRequest->request_number . ' created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display a unit request detail.
     */
    public function show(UnitRequest $unitRequest)
    {
        $unitRequest->load([
            'project',
            'quotation',
            'negotiation',
            'items.quotationItem',
            'creator',
            'approver',
            'approvals.approver',
        ]);

        // Pre-fetch operator profiles (jabatan + photo URL) untuk card Daftar Unit.
        // Cached di EmployeeApiService → cuma hit HRD API saat cache miss.
        $operatorIds = $unitRequest->items
            ->pluck('operator_id')
            ->filter()
            ->unique()
            ->values();
        $operators = [];
        if ($operatorIds->isNotEmpty()) {
            $employeeApi = app(\App\Services\EmployeeApiService::class);
            foreach ($operatorIds as $opId) {
                $profile = $employeeApi->getProfile((int) $opId);
                if ($profile) {
                    $operators[(int) $opId] = $profile;
                }
            }
        }

        // Determine if current user can approve using policy
        $isApprover = auth()->user()->can('approve', $unitRequest);
        $canForward = auth()->user()->can('forward', $unitRequest);

        // Get flow levels for displaying target approvers (User/Role) in history
        $flowService = app(\App\Services\ApprovalFlowService::class);
        $flowLevels = $flowService->getLevels('UnitRequest')->keyBy('level_number');
        $hasApprovalMatrix = $flowLevels->isNotEmpty();

        // Resolve next approver label utk informasi "Menunggu Approval dari X"
        $nextApproverLabel = null;
        $currentLevel = null;

        // Cari level pending sekarang
        $pending = $unitRequest->approvals->firstWhere('status', 'pending');
        if ($pending) {
            $currentLevel = $flowLevels->get($pending->level);
        } elseif ($hasApprovalMatrix && $unitRequest->canSubmit()) {
            // Belum di-submit — tampilkan target level 1
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        return view('unit-requests.show', compact(
            'unitRequest', 'isApprover', 'canForward',
            'flowLevels', 'hasApprovalMatrix', 'nextApproverLabel',
            'operators'
        ));
    }

    private function resolveApproverLabel(\App\Models\ApprovalFlowLevel $level): string
    {
        return match ($level->approver_type) {
            \App\Enums\ApproverType::USER => 'User: ' . (
                \App\Models\User::find($level->approver_user_id)?->name ?? 'Unknown'
            ),
            \App\Enums\ApproverType::ROLE => 'Role: ' . (
                \Spatie\Permission\Models\Role::find($level->approver_role_id)?->name ?? 'Unknown'
            ),
            \App\Enums\ApproverType::DEPARTMENT => 'Department Head',
            default => $level->approver_type->label(),
        };
    }

    /**
     * Show the edit form (only for DRAFT or REJECTED status).
     */
    public function edit(UnitRequest $unitRequest)
    {
        if (!$unitRequest->isEditable()) {
            return redirect()
                ->route('unit-requests.show', $unitRequest->uid)
                ->with('error', 'This unit request cannot be edited in ' . $unitRequest->status->label() . ' status.');
        }

        return view('unit-requests.edit', compact('unitRequest'));
    }

    /**
     * Update an existing unit request.
     */
    public function update(UpdateUnitRequestRequest $request, UnitRequest $unitRequest)
    {
        try {
            $data = $request->validated();

            // Pass the uploaded file directly
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }

            $updated = $this->service->update($unitRequest->uid, $data, auth()->id());

            return redirect()
                ->route('unit-requests.show', $updated->uid)
                ->with('success', 'Unit request updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Submit a unit request for approval.
     */
    public function submit(UnitRequest $unitRequest)
    {
        try {
            $this->service->submit($unitRequest->uid, auth()->id());
            return back()->with('success', 'Unit request #' . $unitRequest->request_number . ' submitted for approval.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Approve or reject a unit request.
     */
    public function approve(ApproveUnitRequestRequest $request, UnitRequest $unitRequest)
    {
        try {
            $this->service->processApproval(
                $unitRequest->uid,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );

            $decision = ucfirst($request->input('decision'));
            return back()->with('success', "Unit request {$decision} successfully.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Forward an approved unit request to workshop.
     */
    public function forwardToWorkshop(UnitRequest $unitRequest)
    {
        // 3-layer auth: cek policy sebelum memproses
        if (! auth()->user()->can('forward', $unitRequest)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk meneruskan permintaan ini ke Workshop.');
        }

        try {
            $this->service->forwardToWorkshop($unitRequest->uid, auth()->id());
            return back()->with('success', 'Permintaan Unit berhasil diteruskan ke Workshop.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Download the attachment file.
     */
    public function downloadAttachment(UnitRequest $unitRequest)
    {
        if (!$unitRequest->attachment_path || !Storage::disk('private')->exists($unitRequest->attachment_path)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('private')->download($unitRequest->attachment_path);
    }

    /**
     * Soft-delete a unit request (only if DRAFT).
     */
    public function destroy(UnitRequest $unitRequest)
    {
        if ($unitRequest->status !== UnitRequestStatus::DRAFT) {
            return back()->with('error', 'Only DRAFT unit requests can be deleted.');
        }

        $unitRequest->delete();

        return redirect()
            ->route('unit-requests.index')
            ->with('success', 'Unit request deleted.');
    }
}
