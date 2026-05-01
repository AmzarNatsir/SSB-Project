<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAmendment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectAmendmentController extends Controller
{
    /**
     * Start a new project amendment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_uid' => 'required|exists:projects,uid',
            'reason' => 'required|string',
        ]);

        $project = Project::where('uid', $request->project_uid)->firstOrFail();

        // Check if there is already an active amendment
        $activeAmendment = ProjectAmendment::where('project_id', $project->id)
            ->where('status', 'IN_PROGRESS')
            ->first();

        if ($activeAmendment) {
            return response()->json(['error' => 'An amendment is already in progress for this project.'], 422);
        }

        DB::beginTransaction();
        try {
            // Generate amendment number
            $count = ProjectAmendment::where('project_id', $project->id)->count() + 1;
            $amendmentNumber = $project->project_number . '-AMD-' . str_pad($count, 2, '0', STR_PAD_LEFT);

            $amendment = ProjectAmendment::create([
                'project_id' => $project->id,
                'amendment_number' => $amendmentNumber,
                'reason' => $request->reason,
                'status' => 'IN_PROGRESS',
                'requested_by' => Auth::id(),
            ]);

            // Update project status to AMENDMENT
            $project->update(['project_status' => 'AMENDMENT']);

            DB::commit();
            return response()->json([
                'success' => 'Amendment initiated successfully.',
                'amendment' => $amendment
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to initiate amendment: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Finalize the project amendment.
     */
    public function finalize(Request $request, $id)
    {
        $amendment = ProjectAmendment::findOrFail($id);
        $project = $amendment->project;

        DB::beginTransaction();
        try {
            $amendment->update(['status' => 'FINALIZED']);

            // Update project status back to COMPLETED
            // Note: We might want to check the previous status, but COMPLETED is the common one for finalized projects
            $project->update(['project_status' => 'COMPLETED']);

            DB::commit();
            return response()->json(['success' => 'Amendment finalized successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to finalize amendment: ' . $e->getMessage()], 500);
        }
    }
}
