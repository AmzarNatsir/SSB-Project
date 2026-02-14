<?php

namespace App\Http\Controllers;

use App\Services\ProjectSurveyService;
use App\Application\Survey\Services\SurveyApplicationService;
use App\Application\Survey\DTOs\CreateSurveyDTO;
use App\Application\Survey\DTOs\SubmitScoreDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class ProjectSurveyController extends Controller
{
    protected $service;
    protected $applicationService;

    public function __construct(
        ProjectSurveyService $service,
        SurveyApplicationService $applicationService
    ) {
        $this->service = $service;
        $this->applicationService = $applicationService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $surveys = $this->service->getSurveyQuery();
            return DataTables::of($surveys)
                ->addIndexColumn()
                ->addColumn('project_name', function($row){
                    return $row->project->project_name ?? '-';
                })
                ->addColumn('status_label', function($row){
                    $badges = [
                        'DRAFT' => 'bg-secondary',
                        'SURVEY_PLANNED' => 'bg-info',
                        'SURVEY_APPROVED' => 'bg-primary',
                        'SURVEY_IN_PROGRESS' => 'bg-warning',
                        'SURVEY_SUBMITTED' => 'bg-info',
                        'PROJECT_FEASIBLE' => 'bg-success',
                        'REVISION_REQUIRED' => 'bg-warning',
                        'PROJECT_CANCELLED' => 'bg-danger',
                        'SURVEY_SKIPPED' => 'bg-dark'
                    ];
                    $color = $badges[$row->status] ?? 'bg-secondary';
                    return '<span class="badge '.$color.'">'.str_replace('_', ' ', $row->status).'</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('project-survey.show', $row->uid).'" class="btn btn-sm btn-info me-1"><i class="ti ti-eye"></i></a>';
                    // Add edit/delete based on status/role
                    return $btn;
                })
                ->rawColumns(['status_label', 'action'])
                ->make(true);
        }
        return view('projects.survey.index');
    }

    public function create()
    {
        // Load only projects that don't have surveys yet
        $projects = \App\Models\Project::whereDoesntHave('surveys')
            ->orderBy('project_name')
            ->get(); 
        
        return view('projects.survey.create', compact('projects'));
    }

    public function store(Request $request)
    {
        \Log::info('ProjectSurveyController::store called', [
            'user_id' => auth()->id(),
            'is_auth' => auth()->check(),
            'session_id' => session()->getId(),
            'request_data' => $request->all(),
        ]);
        
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'is_skipped' => 'boolean',
            'skip_reason' => 'required_if:is_skipped,true'
        ]);

        try {
            // Use new Application Service with DTO pattern
            $dto = CreateSurveyDTO::fromRequest($request);
            $survey = $this->applicationService->createSurvey($dto);
            
            return redirect()->route('project-survey.show', $survey->uid)
                ->with('success', 'Survey initiated successfully.');
        } catch (\Exception $e) {
            \Log::error('Survey creation failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'project_id' => $request->project_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to create survey: ' . $e->getMessage());
        }
    }

    public function show($uid)
    {
        $survey = $this->service->getSurveyByUid($uid);
        if (!$survey) abort(404);
        
        $users = \App\Models\User::orderBy('name')->get();
        
        return view('projects.survey.show', compact('survey', 'users'));
    }

    public function updateSchedule(Request $request, $uid)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:users,id',
            'notes' => 'nullable|string'
        ]);

        try {
            // Combine date and time into scheduled_at
            $scheduledAt = $request->scheduled_date . ' ' . $request->scheduled_time;
            
            $data = [
                'scheduled_at' => $scheduledAt,
                'teams' => $request->teams,
                'notes' => $request->notes
            ];
            
            $survey = $this->service->getSurveyByUid($uid);
            $this->service->scheduleSurvey($uid, $data);
            
            // Create pre-survey approval record
            $survey->approvals()->create([
                'step' => 'PRE_SURVEY_APPROVAL',
                'status' => 'PENDING',
                'approver_id' => null
            ]);
            
            \Log::info('Pre-survey approval created', ['survey_uid' => $uid]);
            
            return back()->with('success', 'Schedule set. Waiting for manager approval to start survey.');
        } catch (Exception $e) {
            \Log::error('Schedule update failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function startSurvey(Request $request, $uid)
    {
        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            if (!$survey) {
                return back()->with('error', 'Survey not found.');
            }
            
            if ($survey->status !== 'APPROVED_TO_START') {
                return back()->with('error', 'Survey must be approved before it can be started.');
            }
            
            // Update status to IN_PROGRESS
            $survey->update(['status' => 'IN_PROGRESS']);
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'survey_started',
                'new_values' => ['status' => 'IN_PROGRESS'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            return back()->with('success', 'Survey started successfully. You can now submit scores.');
        } catch (Exception $e) {
            \Log::error('Start survey failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function storeScore(Request $request, $uid)
    {
        \Log::info('storeScore controller called', [
            'uid' => $uid,
            'request_data' => $request->all(),
            'user_id' => auth()->id()
        ]);
        
        $request->validate([
            'department' => 'required|in:PROJECT,WORKSHOP,HSE',
            'score' => 'required|numeric|min:0|max:100',
            'criteria_scores' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        try {
            // Use new Application Service with DTO pattern
            $dto = SubmitScoreDTO::fromRequest($request);
            
            \Log::info('DTO created', [
                'department' => $dto->department,
                'score' => $dto->score,
                'userId' => $dto->userId
            ]);
            
            $this->applicationService->submitScore($uid, $dto);
            
            \Log::info('Score submitted successfully');
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => \App\Models\ProjectSurvey::where('uid', $uid)->first()->id,
                'user_id' => auth()->id(),
                'event_type' => 'score_submitted',
                'new_values' => [
                    'department' => $dto->department,
                    'score' => $dto->score
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            return back()->with('success', 'Score submitted successfully.');
        } catch (Exception $e) {
            \Log::error('Score submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $uid)
    {
        // Handling approvals
        $request->validate([
            'step' => 'required',
            'status' => 'required|in:APPROVED,REJECTED,REVISION',
            'notes' => 'nullable|string'
        ]);

        try {
            $this->service->processApproval($uid, $request->step, $request->status, $request->notes);
            return back()->with('success', 'Action processed.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Upload survey document
     */
    public function uploadDocument(Request $request, $uid)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:10240', // 10MB
            'document_type' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            // Store file
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs("survey-documents/{$uid}", $filename, 'public');
            
            // Save to database
            $survey->documents()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $request->document_type,
                'uploaded_by' => auth()->id(),
            ]);
            
            return back()->with('success', 'Document uploaded successfully.');
        } catch (Exception $e) {
            \Log::error('Document upload failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload document.');
        }
    }

    /**
     * Delete survey document
     */
    public function deleteDocument($uid, $documentId)
    {
        try {
            $survey = $this->service->getSurveyByUid($uid);
            $document = $survey->documents()->findOrFail($documentId);
            
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Delete record
            $document->delete();
            
            return back()->with('success', 'Document deleted successfully.');
        } catch (Exception $e) {
            \Log::error('Document deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete document.');
        }
    }

    /**
     * Download survey document
     */
    public function downloadDocument($uid, $documentId)
    {
        try {
            $survey = $this->service->getSurveyByUid($uid);
            $document = $survey->documents()->findOrFail($documentId);
            
            if (!Storage::disk('public')->exists($document->file_path)) {
                return back()->with('error', 'File not found.');
            }
            
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        } catch (Exception $e) {
            \Log::error('Document download failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to download document.');
        }
    }

    /**
     * Proceed to execution (create approval workflow)
     */
    public function proceedToExecution($uid)
    {
        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            // Validate survey is feasible
            if (!$survey->is_feasible) {
                return back()->with('error', 'Only feasible projects can proceed to execution.');
            }
            
            // Validate all scores submitted
            if ($survey->scores()->count() < 3) {
                return back()->with('error', 'All department scores must be submitted first.');
            }
            
            \Log::info('Proceed to execution started', ['survey_uid' => $uid]);
            
            // Update survey status to PENDING_APPROVAL
            $survey->update(['status' => 'PENDING_APPROVAL']);
            \Log::info('Survey status updated to PENDING_APPROVAL');
            
            // Create approval records
            $survey->approvals()->createMany([
                [
                    'step' => 'MANAGER_OPS',
                    'status' => 'PENDING',
                    'approver_id' => null, // Will be assigned when approved
                ],
                [
                    'step' => 'MANAGER_PROJECT',
                    'status' => 'PENDING',
                    'approver_id' => null,
                ]
            ]);
            \Log::info('Approval records created');
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'proceed_to_execution',
                'new_values' => ['status' => 'PENDING_APPROVAL'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            return back()->with('success', 'Survey submitted for management approval.');
            
        } catch (Exception $e) {
            \Log::error('Proceed to execution failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to proceed to execution: ' . $e->getMessage());
        }
    }

    /**
     * Approve survey
     */
    public function approveSurvey(Request $request, $uid)
    {
        $request->validate([
            'step' => 'required|in:MANAGER_OPS,MANAGER_PROJECT',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            // Find the approval record
            $approval = $survey->approvals()
                ->where('step', $request->step)
                ->where('status', 'PENDING')
                ->firstOrFail();
            
            // Update approval
            $approval->update([
                'status' => 'APPROVED',
                'approver_id' => auth()->id(),
                'notes' => $request->notes,
                'approved_at' => now()
            ]);
            
            \Log::info('Approval granted', [
                'step' => $request->step,
                'approver' => auth()->id()
            ]);
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'approval_granted',
                'new_values' => [
                    'step' => $request->step,
                    'notes' => $request->notes
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            // Check if all approvals are done
            $pendingApprovals = $survey->approvals()->where('status', 'PENDING')->count();
            
            if ($pendingApprovals === 0) {
                // All approved, complete the survey
                $survey->update(['status' => 'APPROVED']);
                \Log::info('All approvals completed, survey approved');
                
                // Update survey to COMPLETED
                $survey->update(['status' => 'COMPLETED']);
                
                // Update project status
                if ($survey->project) {
                    $survey->project->update(['project_status' => 'COMPLETED']);
                    \Log::info('Project status updated to COMPLETED');
                }
                
                return back()->with('success', 'Survey approved and completed! Project is now ready for execution.');
            }
            
            return back()->with('success', 'Approval granted. Waiting for other approvals.');
            
        } catch (Exception $e) {
            \Log::error('Approval failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to approve: ' . $e->getMessage());
        }
    }

    /**
     * Reject survey
     */
    public function rejectSurvey(Request $request, $uid)
    {
        $request->validate([
            'step' => 'required|in:MANAGER_OPS,MANAGER_PROJECT',
            'notes' => 'required|string|max:500'
        ]);

        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            // Find the approval record
            $approval = $survey->approvals()
                ->where('step', $request->step)
                ->where('status', 'PENDING')
                ->firstOrFail();
            
            // Update approval
            $approval->update([
                'status' => 'REJECTED',
                'approver_id' => auth()->id(),
                'notes' => $request->notes,
                'approved_at' => now()
            ]);
            
            // Update survey status
            $survey->update(['status' => 'REJECTED']);
            
            \Log::info('Survey rejected', [
                'step' => $request->step,
                'approver' => auth()->id()
            ]);
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'survey_rejected',
                'new_values' => [
                    'step' => $request->step,
                    'notes' => $request->notes
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            return back()->with('error', 'Survey rejected. Reason: ' . $request->notes);
            
        } catch (Exception $e) {
            \Log::error('Rejection failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to reject: ' . $e->getMessage());
        }
    }

    /**
     * Approve survey execution (pre-survey approval)
     */
    public function approveSurveyExecution(Request $request, $uid)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            // Find pre-survey approval
            $approval = $survey->approvals()
                ->where('step', 'PRE_SURVEY_APPROVAL')
                ->where('status', 'PENDING')
                ->firstOrFail();
            
            // Approve
            $approval->update([
                'status' => 'APPROVED',
                'approver_id' => auth()->id(),
                'notes' => $request->notes,
                'approved_at' => now()
            ]);
            
            // Update survey status
            $survey->update(['status' => 'APPROVED_TO_START']);
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'survey_execution_approved',
                'new_values' => ['status' => 'APPROVED_TO_START'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            \Log::info('Survey execution approved', ['survey_uid' => $uid]);
            
            return back()->with('success', 'Survey approved. Team can now start the survey.');
        } catch (Exception $e) {
            \Log::error('Approval failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to approve: ' . $e->getMessage());
        }
    }

    /**
     * Reject survey execution (pre-survey approval)
     */
    public function rejectSurveyExecution(Request $request, $uid)
    {
        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        try {
            $survey = $this->service->getSurveyByUid($uid);
            
            $approval = $survey->approvals()
                ->where('step', 'PRE_SURVEY_APPROVAL')
                ->where('status', 'PENDING')
                ->firstOrFail();
            
            $approval->update([
                'status' => 'REJECTED',
                'approver_id' => auth()->id(),
                'notes' => $request->notes,
                'approved_at' => now()
            ]);
            
            $survey->update(['status' => 'REJECTED']);
            
            // Log activity
            \App\Models\SurveyHistory::create([
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
                'event_type' => 'survey_execution_rejected',
                'new_values' => [
                    'status' => 'REJECTED',
                    'notes' => $request->notes
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            
            \Log::info('Survey execution rejected', ['survey_uid' => $uid]);
            
            return back()->with('error', 'Survey rejected: ' . $request->notes);
        } catch (Exception $e) {
            \Log::error('Rejection failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to reject: ' . $e->getMessage());
        }
    }
}

