<?php

namespace App\Http\Controllers;

use App\Enums\ProjectUnitReplacementStatus;
use App\Models\Project;
use App\Models\ProjectUnitReplacement;
use App\Services\ApprovalFlowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectUnitReplacementController extends Controller
{
    public function __construct(protected ApprovalFlowService $flowService) {}

    /**
     * Display a listing of all PTU records with KPI counts.
     */
    public function index()
    {
        $records = ProjectUnitReplacement::with(['project', 'creator'])
            ->latest()
            ->paginate(15);

        $totalCount     = ProjectUnitReplacement::count();
        $submittedCount = ProjectUnitReplacement::where('status', ProjectUnitReplacementStatus::SUBMITTED)->count();
        $approvedCount  = ProjectUnitReplacement::where('status', ProjectUnitReplacementStatus::APPROVED)->count();
        $completedCount = ProjectUnitReplacement::where('status', ProjectUnitReplacementStatus::COMPLETED)->count();

        return view('unit-replacements.index', compact(
            'records',
            'totalCount',
            'submittedCount',
            'approvedCount',
            'completedCount'
        ));
    }

    /**
     * Show form to create a new PTU.
     */
    public function create()
    {
        $projects = Project::whereHas('unitRequests', function ($q) {
            $q->where('status', \App\Enums\UnitRequestStatus::FORWARDED_TO_WORKSHOP);
        })->get();

        return view('unit-replacements.create', compact('projects'));
    }

    /**
     * Store a newly created PTU.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'        => 'required|exists:projects,id',
            'replacement_date'  => 'required|date',
            'mobilization_date' => 'nullable|date',
            'replacement_reason'=> 'required|string',
            'attachment'        => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'items'             => 'required|array|min:1',
            'items.*.old_unit_name'         => 'required|string',
            'items.*.replacement_unit_name' => 'required|string',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('unit-replacements', 'private');
        }

        $ptu = ProjectUnitReplacement::create([
            'project_id'         => $request->project_id,
            'replacement_date'   => $request->replacement_date,
            'mobilization_date'  => $request->mobilization_date,
            'replacement_reason' => $request->replacement_reason,
            'attachment_path'    => $attachmentPath,
            'status'             => ProjectUnitReplacementStatus::DRAFT,
            'created_by'         => Auth::id(),
        ]);

        foreach ($request->items as $item) {
            $ptu->items()->create([
                'old_unit_id'            => $item['old_unit_id'] ?? null,
                'old_unit_name'          => $item['old_unit_name'],
                'replacement_unit_id'    => $item['replacement_unit_id'] ?? null,
                'replacement_unit_name'  => $item['replacement_unit_name'],
                'notes'                  => $item['notes'] ?? null,
            ]);
        }

        return redirect()
            ->route('unit-replacements.show', $ptu->uid)
            ->with('success', 'PTU ' . $ptu->ptu_number . ' created successfully.');
    }

    /**
     * Display PTU detail.
     */
    public function show(ProjectUnitReplacement $unitReplacement)
    {
        $unitReplacement->load(['project', 'items', 'creator', 'approver']);
        return view('unit-replacements.show', compact('unitReplacement'));
    }

    /**
     * Show edit form (only DRAFT/REJECTED).
     */
    public function edit(ProjectUnitReplacement $unitReplacement)
    {
        if (!$unitReplacement->canEdit()) {
            return redirect()
                ->route('unit-replacements.show', $unitReplacement->uid)
                ->with('error', 'This PTU cannot be edited in ' . $unitReplacement->status->label() . ' status.');
        }

        $projects = Project::all();
        return view('unit-replacements.edit', compact('unitReplacement', 'projects'));
    }

    /**
     * Update PTU (only DRAFT/REJECTED).
     */
    public function update(Request $request, ProjectUnitReplacement $unitReplacement)
    {
        if (!$unitReplacement->canEdit()) {
            return back()->with('error', 'Cannot update in current status.');
        }

        $request->validate([
            'project_id'         => 'required|exists:projects,id',
            'replacement_date'   => 'required|date',
            'mobilization_date'  => 'nullable|date',
            'replacement_reason' => 'required|string',
            'attachment'         => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'items'              => 'required|array|min:1',
            'items.*.old_unit_name'         => 'required|string',
            'items.*.replacement_unit_name' => 'required|string',
        ]);

        $data = $request->only(['project_id', 'replacement_date', 'mobilization_date', 'replacement_reason']);

        if ($request->hasFile('attachment')) {
            if ($unitReplacement->attachment_path) {
                Storage::disk('private')->delete($unitReplacement->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('unit-replacements', 'private');
        }

        $unitReplacement->update($data);

        // Sync items
        $unitReplacement->items()->delete();
        foreach ($request->items as $item) {
            $unitReplacement->items()->create([
                'old_unit_id'           => $item['old_unit_id'] ?? null,
                'old_unit_name'         => $item['old_unit_name'],
                'replacement_unit_id'   => $item['replacement_unit_id'] ?? null,
                'replacement_unit_name' => $item['replacement_unit_name'],
                'notes'                 => $item['notes'] ?? null,
            ]);
        }

        return redirect()
            ->route('unit-replacements.show', $unitReplacement->uid)
            ->with('success', 'PTU updated successfully.');
    }

    /**
     * Submit PTU for approval.
     */
    public function submit(ProjectUnitReplacement $unitReplacement)
    {
        if (!$unitReplacement->canSubmit()) {
            return back()->with('error', 'Cannot submit in current status.');
        }

        $unitReplacement->update(['status' => ProjectUnitReplacementStatus::SUBMITTED]);

        return back()->with('success', 'PTU ' . $unitReplacement->ptu_number . ' submitted for approval.');
    }

    /**
     * Approve or reject PTU.
     *
     * Authorization: only users configured at level 1 of ApprovalFlow code 'UnitReplacement'.
     * Currently PTU pakai single-step approval — level 1 dianggap final.
     */
    public function approve(Request $request, ProjectUnitReplacement $unitReplacement)
    {
        $request->validate([
            'decision' => 'required|in:approve,reject',
            'remarks'  => 'nullable|string|max:500',
        ]);

        if (!$unitReplacement->canApprove()) {
            return back()->with('error', 'Cannot approve/reject in current status.');
        }

        // Backend guard: pastikan user adalah approver yang dikonfigurasi di matriks
        $levels = $this->flowService->getLevels('UnitReplacement');
        if ($levels->isEmpty()) {
            return back()->with('error', 'Matriks approval untuk PTU belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.');
        }

        $firstLevel = $levels->first();
        if (! $this->flowService->isUserApprover(Auth::id(), $firstLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval PTU.');
        }

        $newStatus = $request->decision === 'approve'
            ? ProjectUnitReplacementStatus::APPROVED
            : ProjectUnitReplacementStatus::REJECTED;

        $unitReplacement->update([
            'status'      => $newStatus,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $label = $newStatus->label();
        return back()->with('success', 'PTU ' . $unitReplacement->ptu_number . ' ' . strtolower($label) . ' successfully.');
    }

    /**
     * Mark PTU as completed.
     */
    public function complete(ProjectUnitReplacement $unitReplacement)
    {
        if (!$unitReplacement->canComplete()) {
            return back()->with('error', 'Can only complete an approved PTU.');
        }

        $unitReplacement->update(['status' => ProjectUnitReplacementStatus::COMPLETED]);

        return back()->with('success', 'PTU ' . $unitReplacement->ptu_number . ' marked as completed.');
    }

    /**
     * Download attachment.
     */
    public function downloadAttachment(ProjectUnitReplacement $unitReplacement)
    {
        if (!$unitReplacement->attachment_path || !Storage::disk('private')->exists($unitReplacement->attachment_path)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('private')->download($unitReplacement->attachment_path);
    }

    /**
     * Soft-delete (DRAFT only).
     */
    public function destroy(ProjectUnitReplacement $unitReplacement)
    {
        if ($unitReplacement->status !== ProjectUnitReplacementStatus::DRAFT) {
            return back()->with('error', 'Only DRAFT PTU records can be deleted.');
        }

        $unitReplacement->delete();

        return redirect()
            ->route('unit-replacements.index')
            ->with('success', 'PTU deleted.');
    }
}
