<?php

namespace App\Http\Controllers;

use App\Enums\WorkRealizationStatus;
use App\Models\Contract;
use App\Models\Project;
use App\Models\WorkRealization;
use App\Services\ApprovalFlowService;
use App\Services\WorkRealizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkRealizationController extends Controller
{
    public function __construct(
        protected WorkRealizationService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = WorkRealization::with(['project', 'contract', 'creator'])
            ->withCount('items')
            ->latest('period_start');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('realization_number', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $realizations = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => WorkRealization::count(),
            'draft'     => WorkRealization::where('status', WorkRealizationStatus::DRAFT)->count(),
            'submitted' => WorkRealization::where('status', WorkRealizationStatus::SUBMITTED)->count(),
            'approved'  => WorkRealization::where('status', WorkRealizationStatus::APPROVED)->count(),
            'approved_amount' => WorkRealization::where('status', WorkRealizationStatus::APPROVED)->sum('total_realized_amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('work-realizations.index', compact('realizations', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;

        // Default periode: bulan ini
        $defaultStart = now()->startOfMonth()->toDateString();
        $defaultEnd = now()->endOfMonth()->toDateString();

        return view('work-realizations.create', compact('projects', 'preselectedProjectId', 'defaultStart', 'defaultEnd'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $realization = $this->service->create($data, auth()->id());

            return redirect()
                ->route('work-realizations.edit', $realization->uid)
                ->with('success', "Work Realization {$realization->realization_number} berhasil di-generate. Silakan review penyesuaian tarif & upload lampiran.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(WorkRealization $workRealization)
    {
        $workRealization->load([
            'project', 'contract', 'creator', 'approver',
            'items.unitFormationItem', 'items.contractItem',
            'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(WorkRealizationService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($workRealization->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($workRealization->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($workRealization->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('work-realizations.show', [
            'realization' => $workRealization,
            'flowLevels' => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(WorkRealization $workRealization)
    {
        if (! $workRealization->canEdit()) {
            return redirect()
                ->route('work-realizations.show', $workRealization->uid)
                ->with('error', "Work Realization dengan status {$workRealization->status->label()} tidak bisa diedit.");
        }

        $workRealization->load(['items.unitFormationItem', 'project', 'contract']);

        return view('work-realizations.edit', ['realization' => $workRealization]);
    }

    public function update(Request $request, WorkRealization $workRealization)
    {
        $data = $this->validateUpdateInput($request);

        try {
            $this->service->update($workRealization, $data, auth()->id());
            return redirect()
                ->route('work-realizations.show', $workRealization->uid)
                ->with('success', 'Work Realization berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(WorkRealization $workRealization)
    {
        if ($workRealization->status !== WorkRealizationStatus::DRAFT) {
            return back()->with('error', 'Hanya Work Realization Draft yang bisa dihapus.');
        }
        $workRealization->delete();
        return redirect()->route('work-realizations.index')->with('success', 'Work Realization dihapus.');
    }

    public function regenerate(WorkRealization $workRealization)
    {
        try {
            $this->service->regenerate($workRealization, auth()->id());
            return back()->with('success', 'Data realisasi berhasil di-regenerate dari timesheet terbaru.');
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function submit(WorkRealization $workRealization)
    {
        try {
            $this->service->submit($workRealization, auth()->id());
            return back()->with('success', "Work Realization {$workRealization->realization_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, WorkRealization $workRealization)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if (! $workRealization->canApprove()) {
            return back()->with('error', "Work Realization dengan status {$workRealization->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(WorkRealizationService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($workRealization->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $workRealization,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Work Realization berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(WorkRealization $workRealization, string $type)
    {
        $map = [
            'pa_ma' => 'pa_ma_attachment_path',
            'safety' => 'safety_attachment_path',
            'berita_acara' => 'berita_acara_attachment_path',
        ];

        if (! isset($map[$type])) {
            abort(404, 'Tipe attachment tidak valid.');
        }

        $path = $workRealization->{$map[$type]};
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('private')->download($path);
    }

    /**
     * AJAX: list active contracts untuk project tertentu.
     * Pre-fill contract_id di form create.
     */
    public function projectContracts(Project $project)
    {
        $contracts = $project->load(['contracts' => fn ($q) => $q->orderByDesc('start_date')])
            ->contracts
            ->map(fn (Contract $c) => [
                'id' => $c->id,
                'contract_number' => $c->contract_number,
                'status' => is_object($c->status) ? $c->status->value : $c->status,
            ])
            ->values();

        return response()->json(['data' => $contracts]);
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
            'project_id' => 'required|exists:projects,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'notes' => 'nullable|string|max:2000',
            'pa_ma_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
            'safety_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
            'berita_acara_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ];

        $data = $request->validate($rules);

        foreach (['pa_ma_attachment', 'safety_attachment', 'berita_acara_attachment'] as $key) {
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key);
            }
        }

        return $data;
    }

    private function validateUpdateInput(Request $request): array
    {
        $rules = [
            'notes' => 'nullable|string|max:2000',
            'pa_ma_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
            'safety_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
            'berita_acara_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'items' => 'nullable|array',
            'items.*.adjusted_rate' => 'nullable|numeric|min:0',
            'items.*.rate_adjustment_reason' => 'nullable|string|max:500',
            'items.*.notes' => 'nullable|string|max:500',
        ];

        $data = $request->validate($rules);

        foreach (['pa_ma_attachment', 'safety_attachment', 'berita_acara_attachment'] as $key) {
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key);
            }
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
