<?php

namespace App\Http\Controllers;

use App\Enums\NegotiationStatus;
use App\Http\Requests\ContractRequest;
use App\Models\Project;
use App\Services\ContractService;
use App\Repositories\ContractRepository;
use Illuminate\Http\Request;
use Exception;

class ContractController extends Controller
{
    public function __construct(
        protected ContractService $contractService,
        protected ContractRepository $contractRepository
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['contract_number', 'start_date', 'end_date']);
        $contracts = $this->contractRepository->getAll($filters);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $projects = Project::whereHas('negotiations', function ($q) {
            $q->where('status', NegotiationStatus::APPROVED);
        })->whereDoesntHave('contracts')->get();

        return view('contracts.create', compact('projects'));
    }

    public function store(ContractRequest $request)
    {
        try {
            $this->contractService->createContract($request->validated() + ['attachment' => $request->file('attachment')]);
            return redirect()->route('final-contracts.index')->with('success', 'Contract successfully created.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(string $uid)
    {
        $contract = $this->contractRepository->findByUid($uid);
        if (!$contract) {
            abort(404);
        }

        if ($contract->isLocked()) {
            return redirect()->route('final-contracts.show', $contract->uid)->with('error', 'Contract is locked and cannot be edited.');
        }

        $projects = Project::whereHas('negotiations', function ($q) {
            $q->where('status', NegotiationStatus::APPROVED);
        })->get();

        return view('contracts.edit', compact('contract', 'projects'));
    }

    public function update(ContractRequest $request, string $uid)
    {
        try {
            $contract = $this->contractRepository->findByUid($uid);
            if (!$contract) abort(404);

            if ($contract->isLocked()) {
                throw new Exception('Contract is locked and cannot be edited.');
            }

            // Logic to update contract...
            // Assuming the service has an update method or we do it here.
            $data = $request->validated();
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment');
            }
            
            $this->contractService->updateContract($contract, $data);

            return redirect()->route('final-contracts.show', $contract->uid)->with('success', 'Contract successfully updated.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(string $uid)
    {
        $contract = $this->contractRepository->findByUid($uid);
        if (!$contract) {
            abort(404);
        }

        return view('contracts.show', compact('contract'));
    }

    public function loadData(Request $request)
    {
        $projectId = $request->get('project_id');
        if (!$projectId) {
            return response()->json(['error' => 'Project ID is required'], 400);
        }

        try {
            $project = Project::findOrFail($projectId);
            $data = $this->contractService->getContractPreviewData($project);
            
            // Return view partial or json? Json for AJAX.
            return response()->json([
                'user_name' => $project->user_name,
                'user_address' => $project->user_address,
                'project_location' => $project->project_location,
                'bank_account' => $project->bank_account,
                'scope_of_work' => $project->scope_of_work,
                'items' => $data['items'],
                'agreed_value' => $data['agreed_value'],
                'user_code' => $project->user_code,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
