<?php

namespace App\Http\Controllers;

use App\Models\ApprovalFlow;
use App\Models\User;
use App\Services\ApprovalFlowService;
use Illuminate\Http\Request;

class ApprovalFlowController extends Controller
{
    protected $flowService;

    public function __construct(ApprovalFlowService $flowService)
    {
        $this->flowService = $flowService;
    }

    public function index()
    {
        $flows = $this->flowService->getFlows();
        return view('settings.approval-flows.index', compact('flows'));
    }

    public function show($id)
    {
        $flow = $this->flowService->getFlowByCode($id) ?: ApprovalFlow::with('levels.user')->findOrFail($id);
        $users = User::all();
        // Assuming roles and departments are integrated, fetch them here
        return view('settings.approval-flows.show', compact('flow', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'levels' => 'required|array',
            'levels.*.approver_type' => 'required|string',
            'levels.*.approver_user_id' => 'nullable|exists:users,id',
            // Add roles/departments validation
        ]);

        $this->flowService->updateFlowLevels($id, $request->levels);

        return response()->json(['message' => 'Approval matrix updated successfully!']);
    }
}
