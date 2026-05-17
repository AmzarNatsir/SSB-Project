<?php

namespace App\Http\Controllers;

use App\Enums\ProjectUnitReturnStatus;
use App\Models\Project;
use App\Models\ProjectUnitReturn;
use App\Services\ApprovalFlowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectUnitReturnController extends Controller
{
    public function __construct(protected ApprovalFlowService $flowService) {}

    /**
     * Display a listing of all PPU records.
     */
    public function index()
    {
        $records = ProjectUnitReturn::with(['project', 'creator'])
            ->latest()
            ->paginate(15);

        $totalCount     = ProjectUnitReturn::count();
        $submittedCount = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::SUBMITTED)->count();
        $approvedCount  = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::APPROVED)->count();
        $completedCount = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::COMPLETED)->count();

        return view('unit-returns.index', compact(
            'records',
            'totalCount',
            'submittedCount',
            'approvedCount',
            'completedCount'
        ));
    }

    /**
     * Show form to create a new PPU.
     */
    public function create()
    {
        $projects = Project::all();
        return view('unit-returns.create', compact('projects'));
    }

    /**
     * Store a newly created PPU.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'          => 'required|exists:projects,id',
            'return_date'         => 'required|date',
            'demobilization_date' => 'nullable|date',
            'attachment'          => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'items'               => 'required|array|min:1',
            'items.*.project_unit_id' => 'required|string',
            'items.*.equipment_id'    => 'required|string',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('unit-returns', 'private');
        }

        $ppu = ProjectUnitReturn::create([
            'project_id'          => $request->project_id,
            'return_date'         => $request->return_date,
            'demobilization_date' => $request->demobilization_date,
            'attachment_path'     => $attachmentPath,
            'status'              => ProjectUnitReturnStatus::DRAFT,
            'created_by'          => Auth::id(),
        ]);

        foreach ($request->items as $item) {
            $ppu->items()->create([
                'project_unit_id' => $item['project_unit_id'],
                'equipment_id'    => $item['equipment_id'],
                'notes'           => $item['notes'] ?? null,
            ]);
        }

        return redirect()
            ->route('unit-returns.show', $ppu->uid)
            ->with('success', 'PPU ' . $ppu->ppu_number . ' created successfully.');
    }

    /**
     * Display PPU detail.
     */
    public function show(ProjectUnitReturn $unitReturn)
    {
        $unitReturn->load(['project', 'items', 'creator', 'approver']);
        return view('unit-returns.show', compact('unitReturn'));
    }

    /**
     * Show edit form.
     */
    public function edit(ProjectUnitReturn $unitReturn)
    {
        if (!$unitReturn->canEdit()) {
            return redirect()
                ->route('unit-returns.show', $unitReturn->uid)
                ->with('error', 'This PPU cannot be edited in ' . $unitReturn->status->label() . ' status.');
        }

        $projects = Project::all();
        return view('unit-returns.edit', compact('unitReturn', 'projects'));
    }

    /**
     * Update PPU.
     */
    public function update(Request $request, ProjectUnitReturn $unitReturn)
    {
        if (!$unitReturn->canEdit()) {
            return back()->with('error', 'Cannot update in current status.');
        }

        $request->validate([
            'project_id'          => 'required|exists:projects,id',
            'return_date'         => 'required|date',
            'demobilization_date' => 'nullable|date',
            'attachment'          => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'items'               => 'required|array|min:1',
            'items.*.project_unit_id' => 'required|string',
            'items.*.equipment_id'    => 'required|string',
        ]);

        $data = $request->only(['project_id', 'return_date', 'demobilization_date']);

        if ($request->hasFile('attachment')) {
            if ($unitReturn->attachment_path) {
                Storage::disk('private')->delete($unitReturn->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('unit-returns', 'private');
        }

        $unitReturn->update($data);

        // Sync items
        $unitReturn->items()->delete();
        foreach ($request->items as $item) {
            $unitReturn->items()->create([
                'project_unit_id' => $item['project_unit_id'],
                'equipment_id'    => $item['equipment_id'],
                'notes'           => $item['notes'] ?? null,
            ]);
        }

        return redirect()
            ->route('unit-returns.show', $unitReturn->uid)
            ->with('success', 'PPU ' . $unitReturn->ppu_number . ' updated successfully.');
    }

    /**
     * Submit PPU for approval.
     */
    public function submit(ProjectUnitReturn $unitReturn)
    {
        if (!$unitReturn->canSubmit()) {
            return back()->with('error', 'Cannot submit in current status.');
        }

        $unitReturn->update(['status' => ProjectUnitReturnStatus::SUBMITTED]);

        return back()->with('success', 'PPU ' . $unitReturn->ppu_number . ' submitted for approval.');
    }

    /**
     * Approve or reject PPU.
     *
     * Authorization: only users configured at level 1 of ApprovalFlow code 'UnitReturn'.
     * Currently PPU pakai single-step approval — level 1 dianggap final.
     */
    public function approve(Request $request, ProjectUnitReturn $unitReturn)
    {
        $request->validate([
            'decision' => 'required|in:approve,reject',
            'remarks'  => 'nullable|string|max:500',
        ]);

        if (!$unitReturn->canApprove()) {
            return back()->with('error', 'Cannot approve/reject in current status.');
        }

        // Backend guard: pastikan user adalah approver yang dikonfigurasi di matriks
        $levels = $this->flowService->getLevels('UnitReturn');
        if ($levels->isEmpty()) {
            return back()->with('error', 'Matriks approval untuk PPU belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.');
        }

        $firstLevel = $levels->first();
        if (! $this->flowService->isUserApprover(Auth::id(), $firstLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval PPU.');
        }

        $newStatus = $request->decision === 'approve'
            ? ProjectUnitReturnStatus::APPROVED
            : ProjectUnitReturnStatus::REJECTED;

        $unitReturn->update([
            'status'      => $newStatus,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'PPU ' . $unitReturn->ppu_number . ' ' . strtolower($newStatus->label()) . ' successfully.');
    }

    /**
     * Mark PPU as completed.
     */
    public function complete(ProjectUnitReturn $unitReturn)
    {
        if (!$unitReturn->canComplete()) {
            return back()->with('error', 'Can only complete an approved PPU.');
        }

        $unitReturn->update(['status' => ProjectUnitReturnStatus::COMPLETED]);

        return back()->with('success', 'PPU ' . $unitReturn->ppu_number . ' marked as completed.');
    }

    /**
     * Download attachment.
     */
    public function downloadAttachment(ProjectUnitReturn $unitReturn)
    {
        if (!$unitReturn->attachment_path || !Storage::disk('private')->exists($unitReturn->attachment_path)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('private')->download($unitReturn->attachment_path);
    }

    /**
     * Soft-delete.
     */
    public function destroy(ProjectUnitReturn $unitReturn)
    {
        if ($unitReturn->status !== ProjectUnitReturnStatus::DRAFT) {
            return back()->with('error', 'Only DRAFT PPU records can be deleted.');
        }

        $unitReturn->delete();

        return redirect()
            ->route('unit-returns.index')
            ->with('success', 'PPU deleted.');
    }
}
