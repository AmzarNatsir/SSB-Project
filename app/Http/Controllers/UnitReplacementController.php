<?php

namespace App\Http\Controllers;

use App\Enums\UnitReplacementStatus;
use App\Http\Requests\UnitReplacement\ApproveUnitReplacementRequest;
use App\Http\Requests\UnitReplacement\StoreUnitReplacementRequest;
use App\Http\Requests\UnitReplacement\UpdateUnitReplacementRequest;
use App\Http\Requests\UnitReplacement\WorkshopDecisionRequest;
use App\Models\UnitReplacement;
use App\Repositories\Interfaces\IUnitReplacementRepository;
use App\Services\UnitReplacementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitReplacementController extends Controller
{
    protected UnitReplacementService $service;
    protected IUnitReplacementRepository $repo;

    public function __construct(UnitReplacementService $service, IUnitReplacementRepository $repo)
    {
        $this->service = $service;
        $this->repo = $repo;
    }

    public function index()
    {
        $unitReplacements = UnitReplacement::with(['project', 'creator', 'unitRequest:id,request_number'])
            ->latest()
            ->paginate(15);

        $totalCount = UnitReplacement::count();
        $submittedCount = UnitReplacement::where('status', UnitReplacementStatus::SUBMITTED)->count();
        $approvedCount = UnitReplacement::where('status', UnitReplacementStatus::APPROVED)->count();
        $forwardedCount = UnitReplacement::where('status', UnitReplacementStatus::FORWARDED_TO_WORKSHOP)->count();
        $completedCount = UnitReplacement::where('status', UnitReplacementStatus::APPROVED_FROM_WORKSHOP)->count();

        return view('unit-replacements.index', compact(
            'unitReplacements', 'totalCount', 'submittedCount',
            'approvedCount', 'forwardedCount', 'completedCount'
        ));
    }

    public function create()
    {
        $eligibleProjects = $this->repo->getEligibleProjects();
        return view('unit-replacements.create', compact('eligibleProjects'));
    }

    /**
     * AJAX: list UR APPROVED_FROM_WORKSHOP milik project, dengan items yang belum diganti.
     */
    public function eligibleUnitRequests(Request $request)
    {
        $projectId = $request->integer('project_id');
        if (! $projectId) {
            return response()->json(['data' => []]);
        }

        $unitRequests = $this->repo->getEligibleUnitRequests($projectId)
            ->map(fn ($ur) => [
                'id' => $ur->id,
                'request_number' => $ur->request_number,
                'contract_number' => $ur->contract?->contract_number,
                'items' => $ur->items->map(fn ($it) => [
                    'id' => $it->id,
                    'unit_name' => $it->unit_name,
                    'qty' => (int) $it->qty,
                    'duration_days' => $it->duration_days,
                    'operator_name' => $it->operator_name,
                ])->values(),
            ])->values();

        return response()->json(['data' => $unitRequests]);
    }

    /**
     * AJAX: master alat berat dari Workshop API sebagai kandidat unit pengganti.
     */
    public function replacementCandidates(Request $request)
    {
        $projectId = $request->integer('project_id');
        if (! $projectId) {
            return response()->json(['data' => []]);
        }

        $items = collect($this->repo->getReplacementCandidates($projectId))
            ->map(fn ($unit) => [
                'id' => (int) $unit['id'],
                'uid' => $unit['uid'] ?? null,
                'name' => $unit['name'] ?? '',
                'equipment_code' => $unit['equipment_code'] ?? null,
                'type' => $unit['type'] ?? null,
                'status' => $unit['status'] ?? null,
                'hm_current' => (float) ($unit['hm_current'] ?? 0),
            ])
            ->values();

        return response()->json(['data' => $items]);
    }

    public function store(StoreUnitReplacementRequest $request)
    {
        try {
            $unitReplacement = $this->service->create($request->validated(), auth()->id());

            return redirect()
                ->route('unit-replacements.show', $unitReplacement->uid)
                ->with('success', 'Unit replacement #' . $unitReplacement->replacement_number . ' created.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(UnitReplacement $unitReplacement)
    {
        $unitReplacement->load([
            'project', 'unitRequest', 'contract',
            'items.originalUnitRequestItem',
            'creator', 'approver', 'approvals.approver',
        ]);

        $isApprover = auth()->user()->can('approve', $unitReplacement);
        $canForward = auth()->user()->can('forward', $unitReplacement);
        $canWorkshopDecide = auth()->user()->can('workshopDecide', $unitReplacement);

        $flowService = app(\App\Services\ApprovalFlowService::class);
        $flowLevels = $flowService->getLevels('UnitReplacement')->keyBy('level_number');
        $hasApprovalMatrix = $flowLevels->isNotEmpty();

        $nextApproverLabel = null;
        $currentLevel = null;
        $pending = $unitReplacement->approvals->firstWhere('status', 'pending');
        if ($pending) {
            $currentLevel = $flowLevels->get($pending->level);
        } elseif ($hasApprovalMatrix && $unitReplacement->canSubmit()) {
            $currentLevel = $flowLevels->get(1);
        }
        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        // Pre-fetch operator profiles untuk PTU items yang sudah disetujui workshop
        $operatorIds = $unitReplacement->items->pluck('operator_id')->filter()->unique()->values();
        $operators = [];
        if ($operatorIds->isNotEmpty()) {
            $employeeApi = app(\App\Services\EmployeeApiService::class);
            foreach ($operatorIds as $opId) {
                $profile = $employeeApi->getProfile((int) $opId);
                if ($profile) {
                    $operators[(int) $opId] = $profile;
                }
            }
        }

        return view('unit-replacements.show', compact(
            'unitReplacement', 'isApprover', 'canForward', 'canWorkshopDecide',
            'flowLevels', 'hasApprovalMatrix', 'nextApproverLabel', 'operators'
        ));
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

    public function edit(UnitReplacement $unitReplacement)
    {
        if (! $unitReplacement->isEditable()) {
            return redirect()
                ->route('unit-replacements.show', $unitReplacement->uid)
                ->with('error', 'Tidak bisa edit di status ' . $unitReplacement->status->label() . '.');
        }

        $unitReplacement->load(['project', 'unitRequest.items', 'items.originalUnitRequestItem']);

        return view('unit-replacements.edit', compact('unitReplacement'));
    }

    public function update(UpdateUnitReplacementRequest $request, UnitReplacement $unitReplacement)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            $updated = $this->service->update($unitReplacement->uid, $data, auth()->id());

            return redirect()
                ->route('unit-replacements.show', $updated->uid)
                ->with('success', 'Unit replacement updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function submit(UnitReplacement $unitReplacement)
    {
        try {
            $this->service->submit($unitReplacement->uid, auth()->id());
            return back()->with('success', 'PTU #' . $unitReplacement->replacement_number . ' diajukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function approve(ApproveUnitReplacementRequest $request, UnitReplacement $unitReplacement)
    {
        try {
            $this->service->processApproval(
                $unitReplacement->uid,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );

            $decision = ucfirst($request->input('decision'));
            return back()->with('success', "PTU {$decision}.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function forwardToWorkshop(UnitReplacement $unitReplacement)
    {
        if (! auth()->user()->can('forward', $unitReplacement)) {
            return back()->with('error', 'Tidak berwenang meneruskan ke Workshop.');
        }

        try {
            $this->service->forwardToWorkshop($unitReplacement->uid, auth()->id());
            return back()->with('success', 'PTU diteruskan ke Workshop.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function workshopDecision(WorkshopDecisionRequest $request, UnitReplacement $unitReplacement)
    {
        if (! auth()->user()->can('workshopDecide', $unitReplacement)) {
            return back()->with('error', 'Tidak berwenang.');
        }

        try {
            $this->service->processWorkshopDecision(
                $unitReplacement->uid,
                auth()->id(),
                $request->input('decision'),
                $request->input('items', []),
                $request->input('notes')
            );
            $decision = ucfirst($request->input('decision'));
            return back()->with('success', "Workshop decision: {$decision}.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadAttachment(UnitReplacement $unitReplacement)
    {
        if (! $unitReplacement->attachment_path || ! Storage::disk('private')->exists($unitReplacement->attachment_path)) {
            abort(404);
        }
        return Storage::disk('private')->download($unitReplacement->attachment_path);
    }

    public function destroy(UnitReplacement $unitReplacement)
    {
        if ($unitReplacement->status !== UnitReplacementStatus::DRAFT) {
            return back()->with('error', 'Hanya status DRAFT yang bisa dihapus.');
        }
        $unitReplacement->delete();
        return redirect()->route('unit-replacements.index')->with('success', 'PTU dihapus.');
    }
}
