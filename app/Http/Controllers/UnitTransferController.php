<?php

namespace App\Http\Controllers;

use App\Enums\UnitTransferStatus;
use App\Http\Requests\UnitTransfer\StoreUnitTransferRequest;
use App\Http\Requests\UnitTransfer\UpdateUnitTransferRequest;
use App\Models\UnitTransfer;
use App\Repositories\Interfaces\IUnitTransferRepository;
use App\Services\UnitTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitTransferController extends Controller
{
    public function __construct(
        protected UnitTransferService $service,
        protected IUnitTransferRepository $repo,
    ) {}

    public function index()
    {
        $records = UnitTransfer::with([
                'sourceProject:id,project_name,project_number',
                'destinationProject:id,project_name,project_number',
                'creator:id,name',
            ])
            ->latest()
            ->paginate(15);

        $totalCount     = UnitTransfer::count();
        $draftCount     = UnitTransfer::where('status', UnitTransferStatus::DRAFT)->count();
        $completedCount = UnitTransfer::where('status', UnitTransferStatus::COMPLETED)->count();

        return view('unit-transfers.index', compact(
            'records', 'totalCount', 'draftCount', 'completedCount'
        ));
    }

    public function create()
    {
        $sourceProjects      = $this->repo->getEligibleSourceProjects();
        $destinationProjects = \App\Models\Project::orderBy('project_name')
            ->get(['id', 'project_code', 'project_number', 'project_name', 'project_location']);

        return view('unit-transfers.create', compact('sourceProjects', 'destinationProjects'));
    }

    public function eligibleUnitRequests(Request $request)
    {
        $projectId = $request->integer('project_id');
        if (! $projectId) {
            return response()->json(['data' => []]);
        }

        $unitRequests = $this->repo->getEligibleUnitRequests($projectId)
            ->map(fn ($ur) => [
                'id'             => $ur->id,
                'request_number' => $ur->request_number,
                'items' => $ur->items->map(fn ($it) => [
                    'id'             => $it->id,
                    'unit_name'      => $it->unit_name,
                    'equipment_code' => $it->equipment_id ? (string) $it->equipment_id : null,
                    'qty'            => (float) $it->qty,
                    'remaining_qty'  => (float) $it->remainingQty(),
                    'operator_name'  => $it->operator_name,
                ])->values(),
            ])->values();

        return response()->json(['data' => $unitRequests]);
    }

    public function destinationProject(Request $request)
    {
        $projectId = $request->integer('project_id');
        $project = \App\Models\Project::select('id', 'project_code', 'project_number', 'project_name', 'project_location')
            ->find($projectId);

        return response()->json(['data' => $project]);
    }

    public function store(StoreUnitTransferRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            $unitTransfer = $this->service->create($data, auth()->id());

            return redirect()
                ->route('unit-transfers.show', $unitTransfer->uid)
                ->with('success', 'Unit Transfer ' . $unitTransfer->transfer_number . ' berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(UnitTransfer $unitTransfer)
    {
        $unitTransfer->load([
            'sourceProject', 'destinationProject',
            'sourceUnitRequest',
            'items.originalUnitRequestItem',
            'creator',
        ]);

        return view('unit-transfers.show', compact('unitTransfer'));
    }

    public function edit(UnitTransfer $unitTransfer)
    {
        if (! $unitTransfer->isEditable()) {
            return redirect()
                ->route('unit-transfers.show', $unitTransfer->uid)
                ->with('error', 'Tidak bisa edit di status ' . $unitTransfer->status->label() . '.');
        }

        $unitTransfer->load(['sourceProject', 'destinationProject', 'sourceUnitRequest', 'items.originalUnitRequestItem']);

        $destinationProjects = \App\Models\Project::where('id', '!=', $unitTransfer->source_project_id)
            ->orderBy('project_name')
            ->get(['id', 'project_code', 'project_number', 'project_name', 'project_location']);

        return view('unit-transfers.edit', compact('unitTransfer', 'destinationProjects'));
    }

    public function update(UpdateUnitTransferRequest $request, UnitTransfer $unitTransfer)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            $updated = $this->service->update($unitTransfer->uid, $data, auth()->id());

            return redirect()
                ->route('unit-transfers.show', $updated->uid)
                ->with('success', 'UT ' . $updated->transfer_number . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function complete(UnitTransfer $unitTransfer)
    {
        try {
            $this->service->complete($unitTransfer->uid, auth()->id());
            return back()->with('success', 'UT ' . $unitTransfer->transfer_number . ' berhasil diselesaikan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadAttachment(UnitTransfer $unitTransfer)
    {
        if (! $unitTransfer->attachment_path || ! Storage::disk('private')->exists($unitTransfer->attachment_path)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('private')->download($unitTransfer->attachment_path);
    }

    public function destroy(UnitTransfer $unitTransfer)
    {
        if ($unitTransfer->status !== UnitTransferStatus::DRAFT) {
            return back()->with('error', 'Hanya status DRAFT yang bisa dihapus.');
        }

        $unitTransfer->delete();

        return redirect()
            ->route('unit-transfers.index')
            ->with('success', 'UT dihapus.');
    }
}
