<?php

namespace App\Http\Controllers;

use App\Enums\ContractStatus;
use App\Enums\UnitFormationStatus;
use App\Models\Contract;
use App\Models\Project;
use App\Models\UnitFormation;
use App\Services\ApprovalFlowService;
use App\Services\UnitFormationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitFormationController extends Controller
{
    public function __construct(
        protected UnitFormationService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = UnitFormation::with(['project', 'contract', 'creator'])
            ->withCount('items')
            ->latest();

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('formation_number', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        $formations = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => UnitFormation::count(),
            'draft'     => UnitFormation::where('status', UnitFormationStatus::DRAFT)->count(),
            'submitted' => UnitFormation::where('status', UnitFormationStatus::SUBMITTED)->count(),
            'active'    => UnitFormation::where('status', UnitFormationStatus::ACTIVE)->count(),
        ];

        return view('unit-formations.index', compact('formations', 'stats'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;

        return view('unit-formations.create', compact('projects', 'preselectedProjectId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $formation = $this->service->create($data, auth()->id());

            return redirect()
                ->route('unit-formations.show', $formation->uid)
                ->with('success', "SK Penetapan Unit {$formation->formation_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(UnitFormation $unitFormation)
    {
        $unitFormation->load([
            'project',
            'contract.items',
            'unitRequest',
            'creator',
            'approver',
            'items.contractItem',
            'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(UnitFormationService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();

        $nextApproverLabel = null;
        $currentLevel = null;
        if ($unitFormation->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($unitFormation->current_approval_level);
            if ($currentLevel) {
                $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
            }
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
            if ($currentLevel) {
                $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
            }
        }

        $isCurrentApprover = false;
        if ($unitFormation->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('unit-formations.show', [
            'formation' => $unitFormation,
            'flowLevels' => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(UnitFormation $unitFormation)
    {
        if (! $unitFormation->canEdit()) {
            return redirect()
                ->route('unit-formations.show', $unitFormation->uid)
                ->with('error', "SK dengan status {$unitFormation->status->label()} tidak bisa diedit.");
        }

        $unitFormation->load('items', 'project', 'contract.items');
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('unit-formations.edit', [
            'formation' => $unitFormation,
            'projects' => $projects,
        ]);
    }

    public function update(Request $request, UnitFormation $unitFormation)
    {
        $data = $this->validateInput($request, isUpdate: true);

        try {
            $this->service->update($unitFormation, $data, auth()->id());

            return redirect()
                ->route('unit-formations.show', $unitFormation->uid)
                ->with('success', 'SK Penetapan Unit berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(UnitFormation $unitFormation)
    {
        if ($unitFormation->status !== UnitFormationStatus::DRAFT) {
            return back()->with('error', 'Hanya SK berstatus Draft yang bisa dihapus.');
        }

        $unitFormation->delete();
        return redirect()->route('unit-formations.index')->with('success', 'SK Penetapan Unit dihapus.');
    }

    public function submit(UnitFormation $unitFormation)
    {
        try {
            $this->service->submit($unitFormation, auth()->id());
            return back()->with('success', "SK {$unitFormation->formation_number} berhasil diajukan untuk approval.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, UnitFormation $unitFormation)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if (! $unitFormation->canApprove()) {
            return back()->with('error', "SK dengan status {$unitFormation->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService
            ->getLevels(UnitFormationService::FLOW_CODE)
            ->keyBy('level_number');
        $currentLevel = $flowLevels->get($unitFormation->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan. Hubungi admin.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $unitFormation,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );

            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "SK Penetapan Unit berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function activate(UnitFormation $unitFormation)
    {
        try {
            $this->service->activate($unitFormation, auth()->id());
            return back()->with('success', 'SK Penetapan Unit berhasil diaktifkan.');
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function revise(UnitFormation $unitFormation)
    {
        try {
            $revision = $this->service->revise($unitFormation, auth()->id());
            return redirect()
                ->route('unit-formations.edit', $revision->uid)
                ->with('success', "Revisi {$revision->formation_number} dibuat. Silakan edit & ajukan ulang.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function end(UnitFormation $unitFormation)
    {
        try {
            $this->service->end($unitFormation, auth()->id());
            return back()->with('success', 'SK Penetapan Unit diakhiri.');
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(UnitFormation $unitFormation)
    {
        if (! $unitFormation->attachment_path || ! Storage::disk('private')->exists($unitFormation->attachment_path)) {
            abort(404, 'Dokumen SK tidak ditemukan.');
        }

        return Storage::disk('private')->download($unitFormation->attachment_path);
    }

    /**
     * AJAX: list contract_items (baseline kontrak) untuk dropdown unit per row.
     */
    public function contractItems(Contract $contract)
    {
        $items = $contract->items()
            ->get()
            ->map(fn ($ci) => [
                'id' => $ci->id,
                'unit_name' => $ci->unit_name,
                'unit_id' => $ci->unit_id,
                'qty' => $ci->qty,
            ])
            ->values();

        return response()->json(['data' => $items]);
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

    private function validateInput(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'project_id' => ($isUpdate ? 'sometimes|' : '') . 'required|exists:projects,id',
            'contract_id' => ($isUpdate ? 'sometimes|' : '') . 'required|exists:contracts,id',
            'unit_request_id' => 'nullable|exists:unit_requests,id',
            'effective_date' => ($isUpdate ? 'sometimes|' : '') . 'required|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'notes' => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'items' => 'nullable|array',
            'items.*.equipment_unit_id' => 'required_with:items|integer|min:1|distinct',
            'items.*.assigned_operator_id' => 'nullable|integer|min:1',
            'items.*.contract_item_id' => 'nullable|integer|exists:contract_items,id',
            'items.*.unit_name' => 'nullable|string|max:150',
            'items.*.equipment_code' => 'nullable|string|max:50',
            'items.*.operator_name' => 'nullable|string|max:150',
            'items.*.hm_start' => 'nullable|numeric|min:0',
            'items.*.hm_target_monthly' => 'nullable|numeric|min:0',
            'items.*.status' => 'nullable|in:READY,ACTIVE,DOWN,RETURNED,REPLACED',
            'items.*.remarks' => 'nullable|string|max:500',
        ];

        $messages = [
            'items.*.equipment_unit_id.distinct' => 'Unit tidak boleh dipilih lebih dari sekali di SK yang sama.',
        ];

        $data = $request->validate($rules, $messages);

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
