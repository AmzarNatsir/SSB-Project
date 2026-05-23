<?php

namespace App\Http\Controllers;

use App\Enums\PettyCashPurchaseStatus;
use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashExpenseCategory;
use App\Models\PettyCashPurchase;
use App\Models\PettyCashRequest;
use App\Models\Project;
use App\Services\ApprovalFlowService;
use App\Services\PettyCashPurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PettyCashPurchaseController extends Controller
{
    public function __construct(
        protected PettyCashPurchaseService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = PettyCashPurchase::with(['project', 'request', 'expenseCategory', 'creator'])
            ->latest('purchase_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('purchase_number', 'like', "%{$search}%")
                  ->orWhere('purchase_order_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $purchases = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => PettyCashPurchase::count(),
            'draft'     => PettyCashPurchase::where('status', PettyCashPurchaseStatus::DRAFT)->count(),
            'submitted' => PettyCashPurchase::where('status', PettyCashPurchaseStatus::SUBMITTED)->count(),
            'approved'  => PettyCashPurchase::where('status', PettyCashPurchaseStatus::APPROVED)->count(),
            'approved_amount' => PettyCashPurchase::where('status', PettyCashPurchaseStatus::APPROVED)->sum('amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('petty-cash-purchases.index', compact('purchases', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $availableRequests = PettyCashRequest::with('project')
            ->where('status', PettyCashRequestStatus::APPROVED)
            ->orderByDesc('approved_at')
            ->get()
            ->filter(fn ($r) => $r->remaining_amount > 0)
            ->values();

        $categories = PettyCashExpenseCategory::where('is_active', true)->orderBy('name')->get();
        $preselectedRequestId = $request->integer('petty_cash_request_id') ?: null;

        return view('petty-cash-purchases.create', compact('availableRequests', 'categories', 'preselectedRequestId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $purchase = $this->service->create($data, auth()->id());
            return redirect()
                ->route('petty-cash-purchases.show', $purchase->uid)
                ->with('success', "Pembelian {$purchase->purchase_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(PettyCashPurchase $pettyCashPurchase)
    {
        $pettyCashPurchase->load([
            'request', 'project', 'expenseCategory',
            'creator', 'approver', 'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(PettyCashPurchaseService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($pettyCashPurchase->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($pettyCashPurchase->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($pettyCashPurchase->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('petty-cash-purchases.show', [
            'purchase'          => $pettyCashPurchase,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(PettyCashPurchase $pettyCashPurchase)
    {
        if (! $pettyCashPurchase->canEdit()) {
            return redirect()
                ->route('petty-cash-purchases.show', $pettyCashPurchase->uid)
                ->with('error', "Pembelian dengan status {$pettyCashPurchase->status->label()} tidak bisa diedit.");
        }

        $pettyCashPurchase->load('request.project');
        $categories = PettyCashExpenseCategory::where('is_active', true)->orderBy('name')->get();

        return view('petty-cash-purchases.edit', compact('pettyCashPurchase', 'categories'));
    }

    public function update(Request $request, PettyCashPurchase $pettyCashPurchase)
    {
        $data = $this->validateUpdateInput($request);

        try {
            $this->service->update($pettyCashPurchase, $data, auth()->id());
            return redirect()
                ->route('petty-cash-purchases.show', $pettyCashPurchase->uid)
                ->with('success', 'Pembelian berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(PettyCashPurchase $pettyCashPurchase)
    {
        if ($pettyCashPurchase->status !== PettyCashPurchaseStatus::DRAFT) {
            return back()->with('error', 'Hanya Pembelian Draft yang bisa dihapus.');
        }
        $pettyCashPurchase->delete();
        return redirect()->route('petty-cash-purchases.index')->with('success', 'Pembelian dihapus.');
    }

    public function submit(PettyCashPurchase $pettyCashPurchase)
    {
        try {
            $this->service->submit($pettyCashPurchase, auth()->id());
            return back()->with('success', "Pembelian {$pettyCashPurchase->purchase_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, PettyCashPurchase $pettyCashPurchase)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $pettyCashPurchase->canApprove()) {
            return back()->with('error', "Pembelian dengan status {$pettyCashPurchase->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(PettyCashPurchaseService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($pettyCashPurchase->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $pettyCashPurchase,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Pembelian berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(PettyCashPurchase $pettyCashPurchase)
    {
        $path = $pettyCashPurchase->attachment_path;
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }
        return Storage::disk('private')->download($path);
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

    private function validateInput(Request $request): array
    {
        $rules = [
            'petty_cash_request_id' => 'required|exists:petty_cash_requests,id',
            'expense_category_id'   => 'nullable|exists:petty_cash_expense_categories,id',
            'purchase_order_number' => 'nullable|string|max:100',
            'purchase_date'         => 'required|date',
            'description'           => 'required|string|max:2000',
            'amount'                => 'required|numeric|min:1',
            'attachment'            => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment');
        }

        return $data;
    }

    private function validateUpdateInput(Request $request): array
    {
        $rules = [
            'expense_category_id'   => 'nullable|exists:petty_cash_expense_categories,id',
            'purchase_order_number' => 'nullable|string|max:100',
            'purchase_date'         => 'required|date',
            'description'           => 'required|string|max:2000',
            'amount'                => 'required|numeric|min:1',
            'attachment'            => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment');
        }

        return $data;
    }

    private function errorMessage(\Throwable $e): string
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return collect($e->errors())->flatten()->first() ?: $e->getMessage();
        }
        return $e->getMessage();
    }
}
