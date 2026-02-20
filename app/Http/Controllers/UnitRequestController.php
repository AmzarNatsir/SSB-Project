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
     * Show the create form with eligible projects (APPROVED negotiation).
     */
    public function create()
    {
        $eligibleProjects = $this->repo->getEligibleProjects();
        return view('unit-requests.create', compact('eligibleProjects'));
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

        // Determine if current user can approve using policy
        $isApprover = auth()->user()->can('approve', $unitRequest);

        // Get flow levels for displaying target approvers (User/Role) in history
        $flowService = app(\App\Services\ApprovalFlowService::class);
        $flowLevels = $flowService->getLevels('UnitRequest')->keyBy('level_number');

        return view('unit-requests.show', compact('unitRequest', 'isApprover', 'flowLevels'));
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
        try {
            $this->service->forwardToWorkshop($unitRequest->uid, auth()->id());
            return back()->with('success', 'Unit request forwarded to Workshop successfully.');
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
