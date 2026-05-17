<?php

namespace App\Http\Controllers;

use App\Enums\TimesheetJournalStatus;
use App\Enums\UnitFormationStatus;
use App\Models\Project;
use App\Models\TimesheetJournal;
use App\Models\UnitFormation;
use App\Services\ApprovalFlowService;
use App\Services\TimesheetService;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function __construct(
        protected TimesheetService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = TimesheetJournal::with(['project', 'submitter'])
            ->withCount('entries')
            ->latest('journal_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('journal_number', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($date = $request->string('date')->toString()) {
            $query->whereDate('journal_date', $date);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $journals = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => TimesheetJournal::count(),
            'draft'     => TimesheetJournal::where('status', TimesheetJournalStatus::DRAFT)->count(),
            'submitted' => TimesheetJournal::where('status', TimesheetJournalStatus::SUBMITTED)->count(),
            'approved_today' => TimesheetJournal::where('status', TimesheetJournalStatus::APPROVED)
                ->whereDate('journal_date', now()->toDateString())->count(),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('timesheets.index', compact('journals', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;
        $preselectedDate = $request->string('date')->toString() ?: now()->toDateString();

        return view('timesheets.create', compact('projects', 'preselectedProjectId', 'preselectedDate'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $journal = $this->service->create($data, auth()->id());
            return redirect()
                ->route('timesheets.show', $journal->uid)
                ->with('success', "Timesheet {$journal->journal_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(TimesheetJournal $timesheet)
    {
        $timesheet->load([
            'project', 'contract', 'submitter', 'approver',
            'entries.unitFormationItem',
        ]);

        // Cari SK Penugasan Tim (Workforce Formation) AKTIF di project & tanggal jurnal ini
        // — untuk ditampilkan sebagai info "Formasi Tenaga Kerja" di header
        $activeWorkforce = \App\Models\WorkforceFormation::with(['members' => fn ($q) => $q->where('is_active', true)])
            ->where('project_id', $timesheet->project_id)
            ->where('status', \App\Enums\WorkforceFormationStatus::ACTIVE)
            ->where('effective_date', '<=', $timesheet->journal_date)
            ->where(function ($q) use ($timesheet) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $timesheet->journal_date);
            })
            ->get();

        // SK Penetapan Unit aktif (untuk display jumlah unit di header)
        $activeUnitFormation = \App\Models\UnitFormation::with(['items' => fn ($q) => $q->whereIn('status', ['READY', 'ACTIVE'])])
            ->where('project_id', $timesheet->project_id)
            ->where('status', \App\Enums\UnitFormationStatus::ACTIVE)
            ->where('effective_date', '<=', $timesheet->journal_date)
            ->where(function ($q) use ($timesheet) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $timesheet->journal_date);
            })
            ->get();

        $flowLevels = $this->flowService
            ->getLevels(TimesheetService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($timesheet->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($timesheet->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($timesheet->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        // Aggregate totals untuk tampilan summary di show
        $totals = [
            'entries' => $timesheet->entries->count(),
            'hm_total' => $timesheet->entries->sum('hm_total'),
            'working_hours' => $timesheet->entries->sum('working_hours'),
            'idle_hours' => $timesheet->entries->sum('idle_hours'),
            'breakdown_hours' => $timesheet->entries->sum('breakdown_hours'),
            'fuel' => $timesheet->entries->sum('fuel_consumed_liter'),
            'trips' => $timesheet->entries->sum('trip_count'),
            'tonnage' => $timesheet->entries->sum('tonnage'),
        ];

        return view('timesheets.show', [
            'journal' => $timesheet,
            'flowLevels' => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
            'totals' => $totals,
            'activeWorkforce' => $activeWorkforce,
            'activeUnitFormation' => $activeUnitFormation,
        ]);
    }

    public function edit(TimesheetJournal $timesheet)
    {
        if (! $timesheet->canEdit()) {
            return redirect()
                ->route('timesheets.show', $timesheet->uid)
                ->with('error', "Timesheet dengan status {$timesheet->status->label()} tidak bisa diedit.");
        }

        $timesheet->load('entries.unitFormationItem', 'project', 'contract');
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('timesheets.edit', [
            'journal' => $timesheet,
            'projects' => $projects,
        ]);
    }

    public function update(Request $request, TimesheetJournal $timesheet)
    {
        $data = $this->validateInput($request, isUpdate: true);

        try {
            $this->service->update($timesheet, $data, auth()->id());
            return redirect()
                ->route('timesheets.show', $timesheet->uid)
                ->with('success', 'Timesheet berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(TimesheetJournal $timesheet)
    {
        if ($timesheet->status !== TimesheetJournalStatus::DRAFT) {
            return back()->with('error', 'Hanya Timesheet Draft yang bisa dihapus.');
        }
        $timesheet->delete();
        return redirect()->route('timesheets.index')->with('success', 'Timesheet dihapus.');
    }

    public function submit(TimesheetJournal $timesheet)
    {
        try {
            $this->service->submit($timesheet, auth()->id());
            return back()->with('success', "Timesheet {$timesheet->journal_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, TimesheetJournal $timesheet)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if (! $timesheet->canApprove()) {
            return back()->with('error', "Timesheet dengan status {$timesheet->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(TimesheetService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($timesheet->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan. Hubungi admin.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $timesheet,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Timesheet berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    /**
     * AJAX: list active UnitFormationItems untuk project + date tertentu.
     * Dipakai di form Timesheet untuk pilih unit yang bisa di-log.
     */
    public function availableUnits(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'date' => 'nullable|date',
        ]);

        $date = $request->string('date')->toString() ?: now()->toDateString();

        // Cari UnitFormation aktif untuk project ini pada tanggal tsb
        $formations = UnitFormation::with(['items' => fn ($q) => $q->whereIn('status', ['READY', 'ACTIVE'])])
            ->where('project_id', $request->integer('project_id'))
            ->where('status', UnitFormationStatus::ACTIVE)
            ->where('effective_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $date);
            })
            ->get();

        $items = $formations->flatMap(fn ($f) => $f->items)
            ->unique('id')
            ->map(fn ($it) => [
                'id' => $it->id,
                'unit_name' => $it->unit_name,
                'equipment_code' => $it->equipment_code,
                'operator_name' => $it->operator_name,
                'text' => $it->unit_name . ($it->equipment_code ? " ({$it->equipment_code})" : '')
                        . ($it->operator_name ? " — Operator: {$it->operator_name}" : ''),
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
            'contract_id' => 'nullable|exists:contracts,id',
            'journal_date' => ($isUpdate ? 'sometimes|' : '') . 'required|date',
            'shift' => ($isUpdate ? 'sometimes|' : '') . 'required|in:DAY,NIGHT',
            'notes' => 'nullable|string|max:2000',
            'entries' => 'nullable|array',
            'entries.*.unit_formation_item_id' => 'required_with:entries|integer|exists:unit_formation_items,id|distinct',
            'entries.*.activity_code' => 'required_with:entries|in:HAULING,LOADING,IDLE,MAINTENANCE,STANDBY,BREAKDOWN',
            'entries.*.hm_start' => 'nullable|numeric|min:0',
            'entries.*.hm_end' => 'nullable|numeric|gte:entries.*.hm_start',
            // Operating window (Jam Mulai/Selesai Beroperasi)
            'entries.*.operating_start_time' => 'nullable|date_format:H:i',
            'entries.*.operating_end_time' => 'nullable|date_format:H:i',
            'entries.*.working_hours' => 'nullable|numeric|min:0|max:24',
            // Idle/Standby window
            'entries.*.idle_start_time' => 'nullable|date_format:H:i',
            'entries.*.idle_end_time' => 'nullable|date_format:H:i',
            'entries.*.idle_reason' => 'nullable|string|max:500',
            'entries.*.idle_hours' => 'nullable|numeric|min:0|max:24',
            // Breakdown window
            'entries.*.breakdown_start_time' => 'nullable|date_format:H:i',
            'entries.*.breakdown_end_time' => 'nullable|date_format:H:i',
            'entries.*.breakdown_reason' => 'nullable|string|max:500',
            'entries.*.breakdown_hours' => 'nullable|numeric|min:0|max:24',
            'entries.*.fuel_consumed_liter' => 'nullable|numeric|min:0',
            'entries.*.trip_count' => 'nullable|integer|min:0',
            'entries.*.tonnage' => 'nullable|numeric|min:0',
            'entries.*.remarks' => 'nullable|string|max:500',
        ];

        $messages = [
            'entries.*.unit_formation_item_id.distinct' => 'Unit tidak boleh dipilih lebih dari sekali di timesheet yang sama.',
            'entries.*.hm_end.gte' => 'HM Akhir harus lebih besar atau sama dengan HM Awal.',
        ];

        return $request->validate($rules, $messages);
    }

    private function errorMessage(\Throwable $e): string
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return collect($e->errors())->flatten()->first() ?: $e->getMessage();
        }
        return $e->getMessage();
    }
}
