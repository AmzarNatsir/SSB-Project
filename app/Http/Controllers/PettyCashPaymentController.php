<?php

namespace App\Http\Controllers;

use App\Enums\PettyCashPaymentStatus;
use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashExpenseCategory;
use App\Models\PettyCashPayment;
use App\Models\PettyCashRequest;
use App\Models\Project;
use App\Services\ApprovalFlowService;
use App\Services\PettyCashPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PettyCashPaymentController extends Controller
{
    public function __construct(
        protected PettyCashPaymentService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = PettyCashPayment::with(['project', 'request', 'expenseCategory', 'creator'])
            ->latest('payment_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('payment_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $payments = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => PettyCashPayment::count(),
            'draft'     => PettyCashPayment::where('status', PettyCashPaymentStatus::DRAFT)->count(),
            'submitted' => PettyCashPayment::where('status', PettyCashPaymentStatus::SUBMITTED)->count(),
            'approved'  => PettyCashPayment::where('status', PettyCashPaymentStatus::APPROVED)->count(),
            'approved_amount' => PettyCashPayment::where('status', PettyCashPaymentStatus::APPROVED)->sum('amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('petty-cash-payments.index', compact('payments', 'stats', 'projects'));
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

        return view('petty-cash-payments.create', compact('availableRequests', 'categories', 'preselectedRequestId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $payment = $this->service->create($data, auth()->id());
            return redirect()
                ->route('petty-cash-payments.show', $payment->uid)
                ->with('success', "Pembayaran {$payment->payment_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(PettyCashPayment $pettyCashPayment)
    {
        $pettyCashPayment->load([
            'request', 'project', 'expenseCategory',
            'creator', 'approver', 'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(PettyCashPaymentService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($pettyCashPayment->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($pettyCashPayment->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($pettyCashPayment->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('petty-cash-payments.show', [
            'payment'           => $pettyCashPayment,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(PettyCashPayment $pettyCashPayment)
    {
        if (! $pettyCashPayment->canEdit()) {
            return redirect()
                ->route('petty-cash-payments.show', $pettyCashPayment->uid)
                ->with('error', "Pembayaran dengan status {$pettyCashPayment->status->label()} tidak bisa diedit.");
        }

        $pettyCashPayment->load('request.project');
        $categories = PettyCashExpenseCategory::where('is_active', true)->orderBy('name')->get();

        return view('petty-cash-payments.edit', compact('pettyCashPayment', 'categories'));
    }

    public function update(Request $request, PettyCashPayment $pettyCashPayment)
    {
        $data = $this->validateUpdateInput($request);

        try {
            $this->service->update($pettyCashPayment, $data, auth()->id());
            return redirect()
                ->route('petty-cash-payments.show', $pettyCashPayment->uid)
                ->with('success', 'Pembayaran berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(PettyCashPayment $pettyCashPayment)
    {
        if ($pettyCashPayment->status !== PettyCashPaymentStatus::DRAFT) {
            return back()->with('error', 'Hanya Pembayaran Draft yang bisa dihapus.');
        }
        $pettyCashPayment->delete();
        return redirect()->route('petty-cash-payments.index')->with('success', 'Pembayaran dihapus.');
    }

    public function submit(PettyCashPayment $pettyCashPayment)
    {
        try {
            $this->service->submit($pettyCashPayment, auth()->id());
            return back()->with('success', "Pembayaran {$pettyCashPayment->payment_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, PettyCashPayment $pettyCashPayment)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $pettyCashPayment->canApprove()) {
            return back()->with('error', "Pembayaran dengan status {$pettyCashPayment->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(PettyCashPaymentService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($pettyCashPayment->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $pettyCashPayment,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Pembayaran berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(PettyCashPayment $pettyCashPayment)
    {
        $path = $pettyCashPayment->attachment_path;
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
            'expense_category_id'   => 'required|exists:petty_cash_expense_categories,id',
            'payment_date'          => 'required|date',
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
            'expense_category_id' => 'required|exists:petty_cash_expense_categories,id',
            'payment_date'        => 'required|date',
            'description'         => 'required|string|max:2000',
            'amount'              => 'required|numeric|min:1',
            'attachment'          => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
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
