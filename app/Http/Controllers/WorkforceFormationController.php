<?php

namespace App\Http\Controllers;

use App\Enums\ContractStatus;
use App\Enums\WorkforceFormationStatus;
use App\Models\Contract;
use App\Models\Project;
use App\Models\WorkforceFormation;
use App\Services\ApprovalFlowService;
use App\Services\WorkforceFormationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkforceFormationController extends Controller
{
    public function __construct(
        protected WorkforceFormationService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = WorkforceFormation::with(['project', 'contract', 'creator'])
            ->withCount('members')
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
            'total'     => WorkforceFormation::count(),
            'draft'     => WorkforceFormation::where('status', WorkforceFormationStatus::DRAFT)->count(),
            'submitted' => WorkforceFormation::where('status', WorkforceFormationStatus::SUBMITTED)->count(),
            'active'    => WorkforceFormation::where('status', WorkforceFormationStatus::ACTIVE)->count(),
        ];

        return view('workforce-formations.index', compact('formations', 'stats'));
    }

    public function create()
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('workforce-formations.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $formation = $this->service->create($data, auth()->id());

            return redirect()
                ->route('workforce-formations.show', $formation->uid)
                ->with('success', "SK Penugasan {$formation->formation_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(WorkforceFormation $workforceFormation)
    {
        $workforceFormation->load([
            'project',
            'contract',
            'creator',
            'approver',
            'members',
            'approvals.approver',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(WorkforceFormationService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();

        // Resolve approver untuk level berikutnya (kalau ada) supaya bisa ditampilkan ke user
        $nextApproverLabel = null;
        $currentLevel = null;
        if ($workforceFormation->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($workforceFormation->current_approval_level);
            if ($currentLevel) {
                $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
            }
        } elseif ($hasApprovalMatrix) {
            // Belum disubmit — preview level 1
            $currentLevel = $flowLevels->get(1);
            if ($currentLevel) {
                $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
            }
        }

        // Cek apakah user yang login berhak approve di level saat ini (ROLE/USER match dari matriks)
        $isCurrentApprover = false;
        if ($workforceFormation->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('workforce-formations.show', [
            'formation' => $workforceFormation,
            'flowLevels' => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    /**
     * Format approver level jadi label readable: "Role: Manager" / "User: Budi" / dst.
     */
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

    public function edit(WorkforceFormation $workforceFormation)
    {
        if (! $workforceFormation->canEdit()) {
            return redirect()
                ->route('workforce-formations.show', $workforceFormation->uid)
                ->with('error', "SK dengan status {$workforceFormation->status->label()} tidak bisa diedit.");
        }

        $workforceFormation->load('members', 'project', 'contract');
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('workforce-formations.edit', [
            'formation' => $workforceFormation,
            'projects' => $projects,
        ]);
    }

    public function update(Request $request, WorkforceFormation $workforceFormation)
    {
        $data = $this->validateInput($request, isUpdate: true);

        try {
            $this->service->update($workforceFormation, $data, auth()->id());

            return redirect()
                ->route('workforce-formations.show', $workforceFormation->uid)
                ->with('success', 'SK Penugasan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(WorkforceFormation $workforceFormation)
    {
        if ($workforceFormation->status !== WorkforceFormationStatus::DRAFT) {
            return back()->with('error', 'Hanya SK berstatus Draft yang bisa dihapus.');
        }

        $workforceFormation->delete();

        return redirect()
            ->route('workforce-formations.index')
            ->with('success', 'SK Penugasan dihapus.');
    }

    public function submit(WorkforceFormation $workforceFormation)
    {
        try {
            $this->service->submit($workforceFormation, auth()->id());
            return back()->with('success', "SK {$workforceFormation->formation_number} berhasil diajukan untuk approval.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, WorkforceFormation $workforceFormation)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Backend guard — pastikan user yang submit POST adalah approver yang dikonfigurasi
        // di matriks untuk level saat ini. Defense in depth meskipun UI sudah disembunyikan.
        if (! $workforceFormation->canApprove()) {
            return back()->with('error', "SK dengan status {$workforceFormation->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService
            ->getLevels(WorkforceFormationService::FLOW_CODE)
            ->keyBy('level_number');
        $currentLevel = $flowLevels->get($workforceFormation->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan. Hubungi admin.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $workforceFormation,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );

            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "SK Penugasan berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function activate(WorkforceFormation $workforceFormation)
    {
        try {
            $this->service->activate($workforceFormation, auth()->id());
            return back()->with('success', 'SK Penugasan berhasil diaktifkan.');
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function revise(WorkforceFormation $workforceFormation)
    {
        try {
            $revision = $this->service->revise($workforceFormation, auth()->id());
            return redirect()
                ->route('workforce-formations.edit', $revision->uid)
                ->with('success', "Revisi {$revision->formation_number} dibuat. Silakan edit & ajukan ulang.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function end(WorkforceFormation $workforceFormation)
    {
        try {
            $this->service->end($workforceFormation, auth()->id());
            return back()->with('success', 'SK Penugasan diakhiri.');
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(WorkforceFormation $workforceFormation)
    {
        if (! $workforceFormation->attachment_path || ! Storage::disk('private')->exists($workforceFormation->attachment_path)) {
            abort(404, 'Dokumen SK tidak ditemukan.');
        }

        return Storage::disk('private')->download($workforceFormation->attachment_path);
    }

    /**
     * AJAX: list contracts ACTIVE untuk project tertentu (dropdown create form).
     */
    public function projectContracts(Project $project)
    {
        $contracts = $project->load(['contracts' => fn ($q) => $q->where('status', ContractStatus::ACTIVE->value)
            ->orderByDesc('start_date')])
            ->contracts
            ->map(fn (Contract $c) => [
                'id' => $c->id,
                'contract_number' => $c->contract_number,
                'start_date' => optional($c->start_date)->format('Y-m-d'),
                'end_date' => optional($c->end_date)->format('Y-m-d'),
            ])
            ->values();

        return response()->json(['data' => $contracts]);
    }

    private function validateInput(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'project_id' => ($isUpdate ? 'sometimes|' : '') . 'required|exists:projects,id',
            'contract_id' => ($isUpdate ? 'sometimes|' : '') . 'required|exists:contracts,id',
            'effective_date' => ($isUpdate ? 'sometimes|' : '') . 'required|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'notes' => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'members' => 'nullable|array',
            'members.*.employee_id' => 'required_with:members|integer|min:1|distinct',
            'members.*.employee_name' => 'nullable|string|max:150',
            'members.*.position_name' => 'nullable|string|max:150',
            'members.*.daily_rate' => 'nullable|numeric|min:0',
            'members.*.allowance' => 'nullable|numeric|min:0',
            'members.*.shift' => 'nullable|in:DAY,NIGHT,ROTATING',
            'members.*.start_date' => 'nullable|date',
            'members.*.end_date' => 'nullable|date|after_or_equal:members.*.start_date',
            'members.*.is_active' => 'nullable|boolean',
            'members.*.remarks' => 'nullable|string|max:500',
        ];

        $messages = [
            'members.*.employee_id.distinct' => 'Karyawan tidak boleh dipilih lebih dari sekali di formation yang sama.',
            'members.*.daily_rate.numeric' => 'Daily rate harus berupa angka.',
            'members.*.allowance.numeric' => 'Allowance harus berupa angka.',
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
