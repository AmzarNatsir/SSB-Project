<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Budget\ApproveBudgetRequest;
use App\Http\Requests\Budget\StoreBudgetRequest;
use App\Http\Requests\Budget\SubmitBudgetRequest;
use App\Http\Requests\Budget\UpdateBudgetRequest;
use App\Models\ProjectBudget;
use App\Services\ApprovalFlowService;
use App\Services\ProjectBudgetService;
use App\Repositories\Interfaces\IProjectBudgetRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

class ProjectBudgetController extends Controller
{
    protected $budgetService;
    protected $budgetRepo;
    protected $flowService;

    public function __construct(ProjectBudgetService $budgetService, IProjectBudgetRepository $budgetRepo, ApprovalFlowService $flowService)
    {
        $this->budgetService = $budgetService;
        $this->budgetRepo = $budgetRepo;
        $this->flowService = $flowService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filters = $request->only(['status', 'project_id']);
            $query = $this->budgetRepo->getQuery($filters);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('total_hpp', function ($row) {
                    return 'Rp ' . number_format($row->total_hpp, 0, ',', '.');
                })
                ->editColumn('selling_price', function ($row) {
                    return 'Rp ' . number_format($row->selling_price, 0, ',', '.');
                })
                ->editColumn('profit_margin_percent', function ($row) {
                    return $row->profit_margin_percent . '%';
                })
                ->addColumn('project_name', function ($row) {
                    return $row->project->project_name ?? '-';
                })
                ->addColumn('created_by_name', function ($row) {
                    return $row->creator->name ?? '-';
                })
                ->editColumn('status', function ($row) {
                    $status = $row->status;
                    // Ensure status is an Enum
                    if (is_string($status)) {
                        $status = \App\Enums\BudgetStatus::tryFrom($status) ?? \App\Enums\BudgetStatus::DRAFT;
                    }

                    return '<span class="badge bg-' . $status->color() . '">' . $status->label() . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-1">';
                    $btn .= '<a href="' . route('budgets.show', $row->uid) . '" class="btn btn-sm btn-info text-white"><i class="ti ti-eye"></i></a>';

                    if (!$row->isLocked()) {
                        $btn .= '<a href="' . route('budgets.edit', $row->uid) . '" class="btn btn-sm btn-warning text-white"><i class="ti ti-edit"></i></a>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('projects.budgets.index');
    }

    public function create(Request $request)
    {
        // Ideally pass project_id to create budget for specific project
        $projectId = $request->get('project_id');
        $project = null;
        if ($projectId) {
            $project = \App\Models\Project::find($projectId);
        }

        return view('projects.budgets.create', compact('project'));
    }

    public function edit($uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            abort(404);

        if ($budget->isLocked()) {
            return redirect()->route('budgets.show', $uid)->with('error', 'Budget is locked and cannot be edited.');
        }

        return view('projects.budgets.edit', compact('budget'));
    }

    public function show($uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            abort(404);

        return view('projects.budgets.show', compact('budget'));
    }

    public function store(StoreBudgetRequest $request)
    {
        // Check project survey status BEFORE creating
        // Assuming project repository exists or check logic here
        // For now, delegate to service or assume request validation handled "exists:projects"

        $budget = $this->budgetService->createBudget(
            $request->except('items'),
            $request->input('items', [])
        );

        return response()->json(['data' => $budget, 'message' => 'Budget created successfully'], 201);
    }

    public function update(UpdateBudgetRequest $request, $uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            return response()->json(['message' => 'Not found'], 404);

        $budget = $this->budgetService->updateBudget(
            $budget->id,
            $request->except('items', 'version'),
            $request->input('items', [])
        );

        return response()->json(['data' => $budget, 'message' => 'Budget updated successfully']);
    }

    public function destroy($uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            return response()->json(['message' => 'Not found'], 404);

        $budget->delete();
        return response()->json(['message' => 'Budget deleted successfully']);
    }

    public function deleteItem($uid, $itemId)
    {
        try {
            // Include trashed in case we are trying to re-delete or something went wrong
            $item = \App\Models\ProjectBudgetItem::find($itemId);

            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            if ($item->budget->isLocked()) {
                return response()->json(['message' => 'Cannot delete item from locked budget'], 403);
            }

            $budgetId = $item->project_budget_id;
            $item->delete();

            // Recalculate budget totals after item deletion
            // This ensures the selling price and COGS are updated in DB
            $budget = \App\Models\ProjectBudget::find($budgetId);
            if ($budget) {
                $budget->calculateTotals();
            }

            return response()->json(['message' => 'Item deleted and totals recalculated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function submit(SubmitBudgetRequest $request, $uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            return response()->json(['message' => 'Not found'], 404);

        $budget = $this->budgetService->submitBudget($budget->id);
        return response()->json(['data' => $budget, 'message' => 'Budget submitted for approval']);
    }

    public function approve(ApproveBudgetRequest $request, $uid)
    {
        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            return response()->json(['message' => 'Not found'], 404);

        // Backend guard: pastikan user yang login adalah approver yang dikonfigurasi
        // di matriks (ApprovalFlow code 'PROJECT_BUDGET') untuk level saat ini.
        if ($budget->current_approval_level <= 0) {
            return response()->json(['message' => 'Budget is not in an approvable state.'], 422);
        }

        $levels = $this->flowService->getLevels('PROJECT_BUDGET');
        $currentLevel = $levels->where('level_number', $budget->current_approval_level)->first();

        if (! $currentLevel) {
            return response()->json(['message' => 'Konfigurasi approval level tidak ditemukan.'], 422);
        }

        if (! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return response()->json([
                'message' => 'Anda tidak memiliki kewenangan untuk approval di level ini.',
            ], 403);
        }

        $budget = $this->budgetService->processApproval(
            $budget->id,
            auth()->id(),
            $request->input('decision'),
            $request->input('notes')
        );

        return response()->json(['data' => $budget, 'message' => 'Approval decision recorded']);
    }

    public function revise(Request $request, $uid)
    {
        $request->validate([
            'reasons' => 'required|string|min:10'
        ]);

        $budget = $this->budgetRepo->getByUid($uid);
        if (!$budget)
            return response()->json(['message' => 'Not found'], 404);

        $newBudget = $this->budgetService->createRevision(
            $budget->id,
            $request->input('reasons'),
            auth()->id()
        );

        return response()->json(['data' => $newBudget, 'message' => 'New revision created']);
    }

    public function history($projectId)
    {
        $history = $this->budgetRepo->getHistory($projectId);
        return response()->json(['data' => $history]);
    }
}
