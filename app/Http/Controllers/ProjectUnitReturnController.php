<?php

namespace App\Http\Controllers;

use App\Enums\ProjectUnitReturnStatus;
use App\Http\Requests\UnitReturn\ApproveUnitReturnRequest;
use App\Http\Requests\UnitReturn\StoreUnitReturnRequest;
use App\Http\Requests\UnitReturn\UpdateUnitReturnRequest;
use App\Models\ProjectUnitReturn;
use App\Repositories\Interfaces\IUnitReturnRepository;
use App\Services\UnitReturnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectUnitReturnController extends Controller
{
    public function __construct(
        protected UnitReturnService $service,
        protected IUnitReturnRepository $repo,
    ) {}

    public function index()
    {
        $records = ProjectUnitReturn::with(['project', 'creator', 'unitRequest:id,request_number'])
            ->latest()
            ->paginate(15);

        $totalCount     = ProjectUnitReturn::count();
        $submittedCount = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::SUBMITTED)->count();
        $approvedCount  = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::APPROVED)->count();
        $completedCount = ProjectUnitReturn::where('status', ProjectUnitReturnStatus::COMPLETED)->count();

        return view('unit-returns.index', compact(
            'records', 'totalCount', 'submittedCount', 'approvedCount', 'completedCount'
        ));
    }

    public function create()
    {
        $eligibleProjects = $this->repo->getEligibleProjects();
        return view('unit-returns.create', compact('eligibleProjects'));
    }

    /**
     * AJAX: list UR APPROVED_FROM_WORKSHOP milik project, dengan items yang belum dikembalikan.
     */
    public function eligibleUnitRequests(Request $request)
    {
        $projectId = $request->integer('project_id');
        if (! $projectId) {
            return response()->json(['data' => []]);
        }

        $unitRequests = $this->repo->getEligibleUnitRequests($projectId)
            ->map(fn ($ur) => [
                'id'              => $ur->id,
                'request_number'  => $ur->request_number,
                'contract_number' => $ur->contract?->contract_number,
                'items' => $ur->items->map(fn ($it) => [
                    'id'            => $it->id,
                    'unit_name'     => $it->unit_name,
                    'equipment_id'  => $it->equipment_id,
                    'qty'           => (float) $it->qty,
                    'returned_qty'  => (float) $it->returned_qty,
                    'remaining_qty' => (float) $it->remainingQty(),
                    'operator_name' => $it->operator_name,
                ])->values(),
            ])->values();

        return response()->json(['data' => $unitRequests]);
    }

    public function store(StoreUnitReturnRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            $unitReturn = $this->service->create($data, auth()->id());

            return redirect()
                ->route('unit-returns.show', $unitReturn->uid)
                ->with('success', 'PPU ' . $unitReturn->ppu_number . ' berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(ProjectUnitReturn $unitReturn)
    {
        $unitReturn->load([
            'project', 'unitRequest', 'contract',
            'items.originalUnitRequestItem',
            'creator', 'approver', 'approvals.approver',
        ]);

        return view('unit-returns.show', compact('unitReturn'));
    }

    public function edit(ProjectUnitReturn $unitReturn)
    {
        if (! $unitReturn->isEditable()) {
            return redirect()
                ->route('unit-returns.show', $unitReturn->uid)
                ->with('error', 'Tidak bisa edit di status ' . $unitReturn->status->label() . '.');
        }

        $unitReturn->load(['project', 'unitRequest.items', 'items.originalUnitRequestItem']);

        return view('unit-returns.edit', compact('unitReturn'));
    }

    public function update(UpdateUnitReturnRequest $request, ProjectUnitReturn $unitReturn)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            $updated = $this->service->update($unitReturn->uid, $data, auth()->id());

            return redirect()
                ->route('unit-returns.show', $updated->uid)
                ->with('success', 'PPU ' . $updated->ppu_number . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function submit(ProjectUnitReturn $unitReturn)
    {
        try {
            $this->service->submit($unitReturn->uid, auth()->id());
            return back()->with('success', 'PPU ' . $unitReturn->ppu_number . ' diajukan untuk approval.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function approve(ApproveUnitReturnRequest $request, ProjectUnitReturn $unitReturn)
    {
        try {
            $this->service->processApproval(
                $unitReturn->uid,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );

            $decision = ucfirst($request->input('decision'));
            return back()->with('success', "PPU {$decision}.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function complete(ProjectUnitReturn $unitReturn)
    {
        try {
            $this->service->complete($unitReturn->uid, auth()->id());
            return back()->with('success', 'PPU ' . $unitReturn->ppu_number . ' marked as completed.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadAttachment(ProjectUnitReturn $unitReturn)
    {
        if (! $unitReturn->attachment_path || ! Storage::disk('private')->exists($unitReturn->attachment_path)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('private')->download($unitReturn->attachment_path);
    }

    public function destroy(ProjectUnitReturn $unitReturn)
    {
        if ($unitReturn->status !== ProjectUnitReturnStatus::DRAFT) {
            return back()->with('error', 'Hanya status DRAFT yang bisa dihapus.');
        }

        $unitReturn->delete();

        return redirect()
            ->route('unit-returns.index')
            ->with('success', 'PPU dihapus.');
    }
}
