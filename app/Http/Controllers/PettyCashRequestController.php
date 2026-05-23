<?php

namespace App\Http\Controllers;

use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashRequest;
use App\Models\Project;
use App\Services\ApprovalFlowService;
use App\Services\PettyCashRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PettyCashRequestController extends Controller
{
    public function __construct(
        protected PettyCashRequestService $service,
        protected ApprovalFlowService $flowService,
    ) {}

    public function index(Request $request)
    {
        $query = PettyCashRequest::with(['project', 'creator'])->latest('request_date');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($projectId = $request->integer('project_id')) {
            $query->where('project_id', $projectId);
        }

        $requests = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => PettyCashRequest::count(),
            'draft'     => PettyCashRequest::where('status', PettyCashRequestStatus::DRAFT)->count(),
            'submitted' => PettyCashRequest::where('status', PettyCashRequestStatus::SUBMITTED)->count(),
            'approved'  => PettyCashRequest::where('status', PettyCashRequestStatus::APPROVED)->count(),
            'approved_amount' => PettyCashRequest::where('status', PettyCashRequestStatus::APPROVED)->sum('requested_amount'),
        ];

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('petty-cash-requests.index', compact('requests', 'stats', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);
        $preselectedProjectId = $request->integer('project_id') ?: null;

        return view('petty-cash-requests.create', compact('projects', 'preselectedProjectId'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        try {
            $req = $this->service->create($data, auth()->id());
            return redirect()
                ->route('petty-cash-requests.show', $req->uid)
                ->with('success', "Permintaan {$req->request_number} berhasil dibuat.");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function show(PettyCashRequest $pettyCashRequest)
    {
        $pettyCashRequest->load([
            'project', 'creator', 'approver', 'approvals.approver',
            'payments.expenseCategory', 'purchases.expenseCategory',
        ]);

        $flowLevels = $this->flowService
            ->getLevels(PettyCashRequestService::FLOW_CODE)
            ->keyBy('level_number');

        $hasApprovalMatrix = $flowLevels->isNotEmpty();
        $nextApproverLabel = null;
        $currentLevel = null;

        if ($pettyCashRequest->current_approval_level > 0) {
            $currentLevel = $flowLevels->get($pettyCashRequest->current_approval_level);
        } elseif ($hasApprovalMatrix) {
            $currentLevel = $flowLevels->get(1);
        }

        if ($currentLevel) {
            $nextApproverLabel = $this->resolveApproverLabel($currentLevel);
        }

        $isCurrentApprover = false;
        if ($pettyCashRequest->canApprove() && $currentLevel) {
            $isCurrentApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
        }

        return view('petty-cash-requests.show', [
            'request'           => $pettyCashRequest,
            'flowLevels'        => $flowLevels,
            'hasApprovalMatrix' => $hasApprovalMatrix,
            'nextApproverLabel' => $nextApproverLabel,
            'isCurrentApprover' => $isCurrentApprover,
        ]);
    }

    public function edit(PettyCashRequest $pettyCashRequest)
    {
        if (! $pettyCashRequest->canEdit()) {
            return redirect()
                ->route('petty-cash-requests.show', $pettyCashRequest->uid)
                ->with('error', "Permintaan dengan status {$pettyCashRequest->status->label()} tidak bisa diedit.");
        }

        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        return view('petty-cash-requests.edit', compact('pettyCashRequest', 'projects'));
    }

    public function update(Request $request, PettyCashRequest $pettyCashRequest)
    {
        $data = $this->validateInput($request);

        try {
            $this->service->update($pettyCashRequest, $data, auth()->id());
            return redirect()
                ->route('petty-cash-requests.show', $pettyCashRequest->uid)
                ->with('success', 'Permintaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $this->errorMessage($e));
        }
    }

    public function destroy(PettyCashRequest $pettyCashRequest)
    {
        if ($pettyCashRequest->status !== PettyCashRequestStatus::DRAFT) {
            return back()->with('error', 'Hanya Permintaan Draft yang bisa dihapus.');
        }
        $pettyCashRequest->delete();
        return redirect()->route('petty-cash-requests.index')->with('success', 'Permintaan dihapus.');
    }

    public function submit(PettyCashRequest $pettyCashRequest)
    {
        try {
            $this->service->submit($pettyCashRequest, auth()->id());
            return back()->with('success', "Permintaan {$pettyCashRequest->request_number} berhasil diajukan.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function approve(Request $request, PettyCashRequest $pettyCashRequest)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        if (! $pettyCashRequest->canApprove()) {
            return back()->with('error', "Permintaan dengan status {$pettyCashRequest->status->label()} tidak bisa di-approve.");
        }

        $flowLevels = $this->flowService->getLevels(PettyCashRequestService::FLOW_CODE)->keyBy('level_number');
        $currentLevel = $flowLevels->get($pettyCashRequest->current_approval_level);

        if (! $currentLevel) {
            return back()->with('error', 'Konfigurasi level approval tidak ditemukan.');
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $pettyCashRequest,
                auth()->id(),
                $request->input('decision'),
                $request->input('remarks')
            );
            $label = $request->input('decision') === 'approved' ? 'disetujui' : 'ditolak';
            return back()->with('success', "Permintaan berhasil {$label}.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function close(PettyCashRequest $pettyCashRequest)
    {
        try {
            $this->service->close($pettyCashRequest, auth()->id());
            return back()->with('success', "Permintaan {$pettyCashRequest->request_number} ditandai Selesai.");
        } catch (\Throwable $e) {
            return back()->with('error', $this->errorMessage($e));
        }
    }

    public function downloadAttachment(PettyCashRequest $pettyCashRequest)
    {
        $path = $pettyCashRequest->attachment_path;
        if (! $path || ! Storage::disk('private')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
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
            'project_id'       => 'required|exists:projects,id',
            'contract_id'      => 'nullable|exists:contracts,id',
            'request_date'     => 'required|date',
            'description'      => 'required|string|max:2000',
            'requested_amount' => 'required|numeric|min:1',
            'attachment'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ];

        $data = $request->validate($rules);

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
