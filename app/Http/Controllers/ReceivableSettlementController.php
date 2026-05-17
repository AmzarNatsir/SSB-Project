<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\ReceivableSettlementStatus;
use App\Enums\ReceivableStatus;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Receivable;
use App\Models\ReceivableSettlement;
use App\Services\ApprovalFlowService;
use App\Services\ReceivableSettlementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceivableSettlementController extends Controller
{
    public function __construct(
        protected ReceivableSettlementService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = ReceivableSettlement::with(['project', 'invoice', 'depositReceivable', 'creator'])
            ->latest('payment_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('settlement_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('invoice', fn ($i) => $i->where('invoice_number', 'like', "%{$search}%"))
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $settlements = $query->paginate(15)->withQueryString();

        $stats = [
            'total'          => ReceivableSettlement::count(),
            'draft'          => ReceivableSettlement::where('status', ReceivableSettlementStatus::DRAFT)->count(),
            'submitted'      => ReceivableSettlement::where('status', ReceivableSettlementStatus::SUBMITTED)->count(),
            'approved'       => ReceivableSettlement::where('status', ReceivableSettlementStatus::APPROVED)->count(),
            'approved_total' => ReceivableSettlement::where('status', ReceivableSettlementStatus::APPROVED)->sum('total_settled'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('receivable-settlements.index', compact('settlements', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name', 'user_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;
        $preselectedInvoiceId = $request->integer('invoice_id') ?: null;

        return view('receivable-settlements.create', compact('projects', 'preselectedProjectId', 'preselectedInvoiceId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $settlement = $this->service->create($data, auth()->id());
            return redirect()
                ->route('receivable-settlements.show', $settlement->uid)
                ->with('success', "Settlement {$settlement->settlement_number} berhasil dicatat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(ReceivableSettlement $receivableSettlement)
    {
        $receivableSettlement->load([
            'project', 'invoice', 'depositReceivable',
            'creator', 'approver', 'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(ReceivableSettlementService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($receivableSettlement->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($receivableSettlement->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($receivableSettlement->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('receivable-settlements.show', [
            'settlement'        => $receivableSettlement,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(ReceivableSettlement $receivableSettlement)
    {
        if (! $receivableSettlement->canEdit()) {
            return redirect()
                ->route('receivable-settlements.show', $receivableSettlement->uid)
                ->with('error', "Settlement dengan status {$receivableSettlement->status->label()} tidak bisa diedit.");
        }

        $receivableSettlement->load(['project', 'invoice', 'depositReceivable']);
        return view('receivable-settlements.edit', ['settlement' => $receivableSettlement]);
    }

    public function update(Request $request, ReceivableSettlement $receivableSettlement)
    {
        $data = $this->validateUpdateInput($request);

        try {
            $this->service->update($receivableSettlement, $data, auth()->id());
            return redirect()
                ->route('receivable-settlements.show', $receivableSettlement->uid)
                ->with('success', 'Settlement berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(ReceivableSettlement $receivableSettlement)
    {
        if ($receivableSettlement->status !== ReceivableSettlementStatus::DRAFT) {
            return back()->with('error', 'Hanya Settlement Draft yang bisa dihapus.');
        }
        $receivableSettlement->delete();
        return redirect()->route('receivable-settlements.index')->with('success', 'Settlement dihapus.');
    }

    public function submit(ReceivableSettlement $receivableSettlement)
    {
        try {
            $this->service->submit($receivableSettlement, auth()->id());
            return back()->with('success', "Settlement {$receivableSettlement->settlement_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, ReceivableSettlement $receivableSettlement)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $receivableSettlement->canApprove()) {
            return back()->with('error', "Settlement dengan status {$receivableSettlement->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(ReceivableSettlementService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($receivableSettlement->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $receivableSettlement,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Settlement berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(ReceivableSettlement $receivableSettlement)
    {
        $path = $receivableSettlement->attachment_path;
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File bukti settlement tidak ditemukan.');
        }
        return Storage::disk('private')->download($path);
    }

    /**
     * AJAX: list Invoice yang APPROVED & belum PAID untuk dropdown.
     * Hitung sisa tagihan = total - sum(approved settlements).
     */
    public function projectInvoices(Project $project)
    {
        $invoices = Invoice::where('project_id', $project->id)
            ->where('status', InvoiceStatus::APPROVED)
            ->orderByDesc('invoice_date')
            ->get(['id', 'invoice_number', 'invoice_date', 'total_amount']);

        $data = $invoices->map(function ($inv) {
            $settled = (float) ReceivableSettlement::where('invoice_id', $inv->id)
                ->where('status', ReceivableSettlementStatus::APPROVED)
                ->sum('total_settled');
            $remaining = (float) $inv->total_amount - $settled;

            return [
                'id'             => $inv->id,
                'invoice_number' => $inv->invoice_number,
                'invoice_date'   => $inv->invoice_date?->format('d M Y'),
                'total_amount'   => (float) $inv->total_amount,
                'settled'        => $settled,
                'remaining'      => $remaining,
            ];
        })->filter(fn ($i) => $i['remaining'] > 0)->values();

        return response()->json(['data' => $data]);
    }

    /**
     * AJAX: list Uang Muka (Receivable DP) yang APPROVED dan belum dipakai di settlement lain.
     * Filter: invoice_id NULL (artinya DP murni).
     */
    public function projectDeposits(Project $project)
    {
        $usedDepositIds = ReceivableSettlement::whereNotIn('status', [ReceivableSettlementStatus::REJECTED])
            ->whereNotNull('deposit_receivable_id')
            ->pluck('deposit_receivable_id')
            ->all();

        $deposits = Receivable::where('project_id', $project->id)
            ->where('status', ReceivableStatus::APPROVED)
            ->whereNull('invoice_id')
            ->whereNotIn('id', $usedDepositIds)
            ->orderByDesc('received_date')
            ->get(['id', 'receivable_number', 'received_date', 'amount', 'payment_type']);

        return response()->json([
            'data' => $deposits->map(fn ($d) => [
                'id'                => $d->id,
                'receivable_number' => $d->receivable_number,
                'received_date'     => $d->received_date?->format('d M Y'),
                'amount'            => (float) $d->amount,
                'payment_type'      => is_object($d->payment_type) ? $d->payment_type->value : $d->payment_type,
            ]),
        ]);
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
            'invoice_id'            => 'required|exists:invoices,id',
            'deposit_receivable_id' => 'nullable|exists:receivables,id',
            'payment_date'          => 'required|date',
            'payment_amount'        => 'required|numeric|min:0',
            'payment_type'          => 'required|in:TUNAI,TRANSFER',
            'payment_reference'     => 'nullable|string|max:100',
            'description'           => 'nullable|string|max:2000',
            'attachment'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
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
            'deposit_receivable_id' => 'nullable|exists:receivables,id',
            'payment_date'          => 'nullable|date',
            'payment_amount'        => 'nullable|numeric|min:0',
            'payment_type'          => 'nullable|in:TUNAI,TRANSFER',
            'payment_reference'     => 'nullable|string|max:100',
            'description'           => 'nullable|string|max:2000',
            'attachment'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
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
