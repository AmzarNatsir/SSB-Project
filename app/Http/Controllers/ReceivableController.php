<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Enums\ReceivableStatus;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Receivable;
use App\Services\ApprovalFlowService;
use App\Services\ReceivableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceivableController extends Controller
{
    public function __construct(
        protected ReceivableService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = Receivable::with(['project', 'invoice', 'creator'])
            ->latest('received_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('receivable_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('payment_reference', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        if ($type = $request->string('payment_type')->toString()) {
            $query->where('payment_type', $type);
        }

        $receivables = $query->paginate(15)->withQueryString();

        $stats = [
            'total'           => Receivable::count(),
            'draft'           => Receivable::where('status', ReceivableStatus::DRAFT)->count(),
            'submitted'       => Receivable::where('status', ReceivableStatus::SUBMITTED)->count(),
            'approved'        => Receivable::where('status', ReceivableStatus::APPROVED)->count(),
            'approved_total'  => Receivable::where('status', ReceivableStatus::APPROVED)->sum('amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('receivables.index', compact('receivables', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name', 'user_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;
        $preselectedInvoiceId = $request->integer('invoice_id') ?: null;

        return view('receivables.create', compact('projects', 'preselectedProjectId', 'preselectedInvoiceId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $receivable = $this->service->create($data, auth()->id());
            return redirect()
                ->route('receivables.show', $receivable->uid)
                ->with('success', "Penerimaan {$receivable->receivable_number} berhasil dicatat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(Receivable $receivable)
    {
        $receivable->load([
            'project', 'invoice', 'creator', 'approver',
            'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(ReceivableService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($receivable->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($receivable->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($receivable->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('receivables.show', [
            'receivable'        => $receivable,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(Receivable $receivable)
    {
        if (! $receivable->canEdit()) {
            return redirect()
                ->route('receivables.show', $receivable->uid)
                ->with('error', "Penerimaan dengan status {$receivable->status->label()} tidak bisa diedit.");
        }

        $receivable->load(['project', 'invoice']);
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name', 'user_name']);

        return view('receivables.edit', compact('receivable', 'projects'));
    }

    public function update(Request $request, Receivable $receivable)
    {
        $data = $this->validateInput($request, $receivable->project_id);

        try {
            $this->service->update($receivable, $data, auth()->id());
            return redirect()
                ->route('receivables.show', $receivable->uid)
                ->with('success', 'Penerimaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(Receivable $receivable)
    {
        if ($receivable->status !== ReceivableStatus::DRAFT) {
            return back()->with('error', 'Hanya Penerimaan Draft yang bisa dihapus.');
        }
        $receivable->delete();
        return redirect()->route('receivables.index')->with('success', 'Penerimaan dihapus.');
    }

    public function submit(Receivable $receivable)
    {
        try {
            $this->service->submit($receivable, auth()->id());
            return back()->with('success', "Penerimaan {$receivable->receivable_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, Receivable $receivable)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $receivable->canApprove()) {
            return back()->with('error', "Penerimaan dengan status {$receivable->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(ReceivableService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($receivable->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $receivable,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Penerimaan berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(Receivable $receivable)
    {
        $path = $receivable->attachment_path;
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File bukti penerimaan tidak ditemukan.');
        }
        return Storage::disk('private')->download($path);
    }

    /**
     * AJAX: list invoices untuk project tertentu, untuk pre-fill dropdown invoice.
     * Hanya ambil Invoice yang APPROVED tapi belum PAID.
     */
    public function projectInvoices(Project $project)
    {
        $invoices = Invoice::where('project_id', $project->id)
            ->whereIn('status', [\App\Enums\InvoiceStatus::APPROVED, \App\Enums\InvoiceStatus::PAID])
            ->orderByDesc('invoice_date')
            ->get(['id', 'invoice_number', 'invoice_date', 'total_amount', 'status']);

        return response()->json([
            'data' => $invoices->map(fn ($inv) => [
                'id'             => $inv->id,
                'invoice_number' => $inv->invoice_number,
                'invoice_date'   => $inv->invoice_date?->format('d M Y'),
                'total_amount'   => $inv->total_amount,
                'status'         => is_object($inv->status) ? $inv->status->value : $inv->status,
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

    private function validateInput(Request $request, ?int $lockedProjectId = null): array
    {
        $rules = [
            'project_id'        => 'required|exists:projects,id',
            'invoice_id'        => 'nullable|exists:invoices,id',
            'received_date'     => 'required|date',
            'amount'            => 'required|numeric|min:0.01',
            'payment_type'      => 'required|in:TUNAI,TRANSFER',
            'payment_reference' => 'nullable|string|max:100',
            'description'       => 'nullable|string|max:2000',
            'attachment'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];

        $data = $request->validate($rules);

        if ($lockedProjectId) {
            $data['project_id'] = $lockedProjectId;
        }

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
