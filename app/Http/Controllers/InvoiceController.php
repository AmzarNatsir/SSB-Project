<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\WorkRealizationStatus;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\WorkRealization;
use App\Services\ApprovalFlowService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = Invoice::with(['project', 'workRealization', 'creator'])
            ->latest('invoice_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $invoices = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Invoice::count(),
            'draft'      => Invoice::where('status', InvoiceStatus::DRAFT)->count(),
            'submitted'  => Invoice::where('status', InvoiceStatus::SUBMITTED)->count(),
            'approved'   => Invoice::where('status', InvoiceStatus::APPROVED)->count(),
            'paid'       => Invoice::where('status', InvoiceStatus::PAID)->count(),
            'paid_total' => Invoice::where('status', InvoiceStatus::PAID)->sum('total_amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('invoices.index', compact('invoices', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        // Ambil hanya Work Realization yang APPROVED dan belum punya invoice
        $availableWRs = WorkRealization::with('project', 'contract')
            ->where('status', WorkRealizationStatus::APPROVED)
            ->whereDoesntHave('invoice', function ($q) {
                // relation tidak ada, kita pakai NOT IN
            })
            ->whereNotIn('id', Invoice::query()->select('work_realization_id'))
            ->orderByDesc('approved_at')
            ->get();

        $preselectedWrId = $request->integer('work_realization_id') ?: null;

        return view('invoices.create', compact('availableWRs', 'preselectedWrId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $invoice = $this->service->create($data, auth()->id());
            return redirect()
                ->route('invoices.show', $invoice->uid)
                ->with('success', "Invoice {$invoice->invoice_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load([
            'project', 'contract', 'creator', 'approver',
            'workRealization.items', 'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(InvoiceService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($invoice->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($invoice->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($invoice->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('invoices.show', [
            'invoice'           => $invoice,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(Invoice $invoice)
    {
        if (! $invoice->canEdit()) {
            return redirect()
                ->route('invoices.show', $invoice->uid)
                ->with('error', "Invoice dengan status {$invoice->status->label()} tidak bisa diedit.");
        }

        $invoice->load(['project', 'workRealization']);

        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validateUpdateInput($request);

        try {
            $this->service->update($invoice, $data, auth()->id());
            return redirect()
                ->route('invoices.show', $invoice->uid)
                ->with('success', 'Invoice berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return back()->with('error', 'Hanya Invoice Draft yang bisa dihapus.');
        }
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice dihapus.');
    }

    public function submit(Invoice $invoice)
    {
        try {
            $this->service->submit($invoice, auth()->id());
            return back()->with('success', "Invoice {$invoice->invoice_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, Invoice $invoice)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $invoice->canApprove()) {
            return back()->with('error', "Invoice dengan status {$invoice->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(InvoiceService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($invoice->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $invoice,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Invoice berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function markPaid(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'paid_date'     => 'nullable|date',
            'payment_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $this->service->markPaid($invoice, $data, auth()->id());
            return back()->with('success', "Invoice {$invoice->invoice_number} ditandai Lunas.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadFakturPajak(Invoice $invoice)
    {
        $path = $invoice->faktur_pajak_path;
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File Faktur Pajak tidak ditemukan.');
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
            'work_realization_id'     => 'required|exists:work_realizations,id',
            'invoice_date'            => 'required|date',
            'due_date'                => 'nullable|date|after_or_equal:invoice_date',
            'ppn_rate'                => 'nullable|numeric|min:0|max:100',
            'pph_rate'                => 'nullable|numeric|min:0|max:100',
            'faktur_pajak_number'     => 'nullable|string|max:100',
            'notes'                   => 'nullable|string|max:2000',
            'faktur_pajak_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('faktur_pajak_attachment')) {
            $data['faktur_pajak_attachment'] = $request->file('faktur_pajak_attachment');
        }

        return $data;
    }

    private function validateUpdateInput(Request $request): array
    {
        $rules = [
            'invoice_date'            => 'nullable|date',
            'due_date'                => 'nullable|date|after_or_equal:invoice_date',
            'ppn_rate'                => 'nullable|numeric|min:0|max:100',
            'pph_rate'                => 'nullable|numeric|min:0|max:100',
            'faktur_pajak_number'     => 'nullable|string|max:100',
            'notes'                   => 'nullable|string|max:2000',
            'faktur_pajak_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('faktur_pajak_attachment')) {
            $data['faktur_pajak_attachment'] = $request->file('faktur_pajak_attachment');
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
