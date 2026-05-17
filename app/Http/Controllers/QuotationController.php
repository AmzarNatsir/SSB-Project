<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Project;
use App\Services\QuotationService;
use App\Services\WorkshopApiService;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    protected $service;
    protected $flowService;

    public function __construct(QuotationService $service, \App\Services\ApprovalFlowService $flowService)
    {
        $this->service = $service;
        $this->flowService = $flowService;
    }

    public function index()
    {
        $quotations = Quotation::with(['project', 'budget'])
            ->latest()
            ->paginate(10);

        // Resolve current approvers for the current page
        $levels = $this->flowService->getLevels('QUOTATION');

        $quotations->getCollection()->transform(function ($quote) use ($levels) {
            $currentApprover = '-';
            if ($quote->status === 'SUBMITTED' && $quote->current_approval_level > 0) {
                $level = $levels->where('level_number', $quote->current_approval_level)->first();
                if ($level) {
                    if ($level->approver_type->value === 'ROLE') {
                        $role = \Spatie\Permission\Models\Role::find($level->approver_role_id);
                        $currentApprover = $role ? $role->name : 'Unknown Role';
                    } elseif ($level->approver_type->value === 'USER') {
                        $user = \App\Models\User::find($level->approver_user_id);
                        $currentApprover = $user ? $user->name : 'Unknown User';
                    } else {
                        $currentApprover = $level->approver_type->label();
                    }
                }
            }
            $quote->current_approver_label = $currentApprover;
            return $quote;
        });

        $kpi = [
            'draft' => Quotation::where('status', 'DRAFT')->count(),
            'pending' => Quotation::where('status', 'SUBMITTED')->count(),
            'approved' => Quotation::where('status', 'APPROVED')->count(),
            'sent' => Quotation::where('status', 'SENT')->count(),
            'value' => Quotation::sum('selling_price'),
        ];

        return view('quotations.index', compact('quotations', 'kpi'));
    }

    public function create()
    {
        // Projects that have an approved budget baseline (conceptually)
        // For now, listing all active projects 
        $projects = Project::with('latest_budget')->get(); // Should scope to those with budgets
        return view('quotations.create', compact('projects'));
    }

    public function edit(Quotation $quotation)
    {
        if ($quotation->isLocked()) {
            return redirect()->route('quotations.show', $quotation->uid)->with('error', 'Quotation is locked and cannot be edited.');
        }

        $projects = Project::whereHas('latest_budget', function ($q) {
            $q->where('status', \App\Enums\BudgetStatus::BASELINE_APPROVED);
        })->get();

        return view('quotations.create', compact('projects', 'quotation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'project_budget_id' => 'nullable|exists:project_budgets,id',
            'items' => 'required|array',
            'items.*.unit_name' => 'required|string',
            'items.*.unit_id' => 'nullable',
            'items.*.uid_unit' => 'nullable|string',
            'items.*.rate' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.duration' => 'required|numeric',
            'profit_margin_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $quotation = $this->service->create($validated);

        return response()->json([
            'message' => 'Quotation created successfully',
            'redirect' => route('quotations.show', $quotation->uid)
        ]);
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['items', 'project', 'budget', 'approvals.approver', 'creator']);

        $currentApprover = null;
        $canApprove = false;

        if ($quotation->status === 'SUBMITTED' && $quotation->current_approval_level > 0) {
            $levels = $this->flowService->getLevels('QUOTATION');
            $level = $levels->where('level_number', $quotation->current_approval_level)->first();

            if ($level) {
                // Determine display label
                if ($level->approver_type->value === 'ROLE') {
                    $role = \Spatie\Permission\Models\Role::find($level->approver_role_id);
                    $currentApprover = $role ? $role->name : 'Unknown Role';
                } elseif ($level->approver_type->value === 'USER') {
                    $user = \App\Models\User::find($level->approver_user_id);
                    $currentApprover = $user ? $user->name : 'Unknown User';
                } else {
                    $currentApprover = $level->approver_type->label();
                }

                // Check authorization
                $canApprove = $this->flowService->isUserApprover(auth()->id(), $level, $quotation);
            }
        }

        return view('quotations.show', compact('quotation', 'currentApprover', 'canApprove'));
    }

    public function approve(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'decision' => 'required|string', // APPROVED, REJECTED, REVISION
            'notes' => 'nullable|string',
        ]);

        try {
            // Re-verify authorization on server side
            $levels = $this->flowService->getLevels('QUOTATION');
            $level = $levels->where('level_number', $quotation->current_approval_level)->first();

            if (!$level || !$this->flowService->isUserApprover(auth()->id(), $level, $quotation)) {
                return back()->with('error', 'Unauthorized. You are not the approver for the current level.');
            }

            $this->service->processApproval(
                $quotation,
                auth()->id(),
                $validated['decision'],
                $validated['notes']
            );
            return back()->with('success', 'Decision recorded successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'profit_margin_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        // Flexible update for Wizard steps
        $data = $request->all();
        $this->service->update($quotation, $data);

        return response()->json(['message' => 'Saved', 'quotation' => $quotation]);
    }

    public function submit(Quotation $quotation)
    {
        try {
            $this->service->submit($quotation);
            return back()->with('success', 'Quotation submitted for approval.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf(Quotation $quotation)
    {
        $pdf = $this->service->generatePdf($quotation);
        return $pdf->stream("Quote-{$quotation->uid}.pdf");
    }

    // Proxy for Units API to avoid CORS if frontend calls direct.
    // Frontend di create.blade.php sudah handle baik flat array maupun { data: [...] }.
    public function getUnits(WorkshopApiService $workshop)
    {
        return response()->json(['data' => $workshop->all()]);
    }
}
