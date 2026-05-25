<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;
use App\Models\User;
use App\Models\EquimentRentalRatesHM;
use App\Models\ProjectImage;
use App\Models\ProjectHistory;
use App\Models\ProjectAmendment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::with(['category', 'subCategory', 'pic'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('project_value', function($row){
                    return 'Rp ' . number_format($row->project_value, 0, ',', '.');
                })
                ->editColumn('project_status', function($row){
                    $statusConfig = [
                        'NOT STARTED' => ['color' => 'bg-purple', 'text' => 'Plan'],
                        'ON PROGRESS' => ['color' => 'bg-info', 'text' => 'Survey'],
                        'COMPLETED' => ['color' => 'bg-success', 'text' => 'Completed'],
                        'AMENDMENT' => ['color' => 'bg-danger', 'text' => 'Amendment'],
                        'ON HOLD' => ['color' => 'bg-warning', 'text' => 'On Hold'],
                        'CANCELLED' => ['color' => 'bg-danger', 'text' => 'Cancelled'],
                    ];

                    $config = $statusConfig[$row->project_status] ?? ['color' => 'bg-secondary', 'text' => $row->project_status];

                    return '<div class="d-flex align-items-center">
                        <div class="progress me-2" style="width: 80px; height: 6px;">
                            <div class="progress-bar '.$config['color'].'" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span>'.$config['text'].'</span>
                    </div>';
                })
                ->addColumn('action', function($row){
                    $detailBtn = '<a href="/projects/'.$row->uid.'" class="btn btn-sm btn-info me-1">
                        <i class="ti ti-eye"></i>
                    </a>';

                    $editBtn = '';
                    $deleteBtn = '';

                    if ($row->project_status === 'NOT STARTED' || $row->project_status === 'AMENDMENT') {
                        $editBtn = '<a href="javascript:void(0);" class="btn btn-sm btn-warning me-1 edit-project-btn"
                            data-id="'.$row->uid.'">
                            <i class="ti ti-edit"></i>
                        </a>';
                    }

                    if ($row->project_status === 'NOT STARTED') {
                        $deleteBtn = '<a href="javascript:void(0);" class="btn btn-sm btn-danger delete-project-btn"
                            data-id="'.$row->uid.'">
                            <i class="ti ti-trash"></i>
                        </a>';
                    }

                    return $detailBtn . $editBtn . $deleteBtn;
                })
                ->rawColumns(['action', 'project_status'])
                ->make(true);
        }

        $categories = ProjectCategory::all();
        $subCategories = ProjectSubCategory::all();
        $users = User::all();
        $equipmentRates = EquimentRentalRatesHM::all();

        return view('projects.index', compact('categories', 'subCategories', 'users', 'equipmentRates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Clean numeric values BEFORE validation
        if ($request->has('project_value')) {
            $request->merge([
                'project_value' => str_replace('.', '', $request->project_value)
            ]);
        }

        $request->validate([
            'request_date' => 'required|date',
            'project_categories_id' => 'required|exists:project_categories,id',
            'project_name' => 'required|string',
            'user_name' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'email' => 'nullable|email',
            'project_value' => 'nullable|numeric',
        ]);

        Project::create($request->all());

        return response()->json(['success' => 'Project created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with([
                'category', 'subCategory', 'pic', 'equipmentRentalRate', 'images',
                'surveys', 'latest_budget.items', 'latest_quotation.items',
                'latest_negotiation.rounds',
                'contracts' => function ($query) {
                    $query->where('status', \App\Enums\ContractStatus::ACTIVE)->with('items');
                },
                'unitRequests' => function ($query) {
                    $query->where('status', \App\Enums\UnitRequestStatus::APPROVED_FROM_WORKSHOP)
                          ->with([
                              'sourceUnitTransfer.sourceProject:id,uid,project_number,project_name',
                              'sourceUnitTransfer.sourceUnitRequest:id,uid,request_number',
                              'items.replacedByItem.unitReplacement:id,uid,replacement_number',
                              'items.returnItems.unitReturn:id,uid,ppu_number,return_date',
                              'items.transferItems.unitTransfer.destinationProject:id,uid,project_number,project_name',
                              'items.transferItems.unitTransfer:id,uid,transfer_number,transfer_date,destination_project_id,status',
                              'items.sourceUnitTransferItem.unitTransfer.sourceProject:id,uid,project_number,project_name',
                              'items.sourceUnitTransferItem.unitTransfer:id,uid,transfer_number,transfer_date,source_project_id,source_unit_request_id',
                              'items.sourceUnitTransferItem.unitTransfer.sourceUnitRequest:id,uid,request_number',
                              'creator:id,name',
                          ])
                          ->latest();
                },
                'unitReplacements' => function ($query) {
                    $query->with([
                        'unitRequest:id,uid,request_number',
                        'items',
                        'creator:id,name',
                    ])->latest();
                },
                'unitReturns' => function ($query) {
                    $query->with([
                        'unitRequest:id,uid,request_number',
                        'items',
                        'creator:id,name',
                    ])->latest();
                },
                'unitTransfersOut' => function ($query) {
                    $query->with([
                        'destinationProject:id,uid,project_number,project_name',
                        'sourceUnitRequest:id,uid,request_number',
                        'items',
                        'creator:id,name',
                    ])->latest();
                },
                'unitTransfersIn' => function ($query) {
                    $query->where('status', \App\Enums\UnitTransferStatus::COMPLETED)
                          ->with([
                              'sourceProject:id,uid,project_number,project_name',
                              'sourceUnitRequest:id,uid,request_number',
                              'items',
                              'creator:id,name',
                          ])->latest();
                }
            ])
            ->where('uid', $id)
            ->firstOrFail();

        $categories = ProjectCategory::all();
        $subCategories = ProjectSubCategory::all();
        $users = User::all();
        $equipmentRates = EquimentRentalRatesHM::all();

        // SK Penugasan Tim (Workforce Formation) yang aktif untuk project ini.
        $workforceFormations = \App\Models\WorkforceFormation::with([
                'contract:id,contract_number,start_date,end_date',
                'creator:id,name',
                'members' => fn ($q) => $q->where('is_active', true)
                                           ->orderBy('position_name')
                                           ->orderBy('employee_name'),
            ])
            ->where('project_id', $project->id)
            ->where('status', \App\Enums\WorkforceFormationStatus::ACTIVE)
            ->latest('effective_date')
            ->get();

        // SK Penetapan Unit yang aktif untuk project ini.
        $unitFormations = \App\Models\UnitFormation::with([
                'contract:id,contract_number,start_date,end_date',
                'creator:id,name',
                'items' => fn ($q) => $q->whereIn('status', ['READY', 'ACTIVE'])
                                         ->orderBy('unit_name'),
            ])
            ->where('project_id', $project->id)
            ->where('status', \App\Enums\UnitFormationStatus::ACTIVE)
            ->latest('effective_date')
            ->get();

        // Pre-fetch operator profiles untuk Deployed Units (APPROVED_FROM_WORKSHOP)
        $deployedOperatorIds = $project->unitRequests
            ->flatMap->items
            ->pluck('operator_id')
            ->filter()
            ->unique()
            ->values();
        $deployedOperators = [];
        $workforceMembers = [];
        $employeeApi = app(\App\Services\EmployeeApiService::class);
        if ($deployedOperatorIds->isNotEmpty()) {
            foreach ($deployedOperatorIds as $opId) {
                $profile = $employeeApi->getProfile((int) $opId);
                if ($profile) {
                    $deployedOperators[(int) $opId] = $profile;
                }
            }
        }

        // Pre-fetch workforce member profiles untuk tab Work Force
        $workforceMemberIds = $workforceFormations
            ->flatMap->members
            ->pluck('employee_id')
            ->filter()
            ->unique()
            ->values();
        if ($workforceMemberIds->isNotEmpty()) {
            foreach ($workforceMemberIds as $empId) {
                $profile = $employeeApi->getProfile((int) $empId);
                if ($profile) {
                    $workforceMembers[(int) $empId] = $profile;
                }
            }
        }

        return view('projects.show', compact('project', 'categories', 'subCategories', 'users', 'equipmentRates', 'workforceFormations', 'unitFormations', 'deployedOperators', 'workforceMembers'));
    }

    /**
     * Get project data for AJAX (used in edit form)
     */
    public function getProject(string $id)
    {
        $project = Project::with(['category', 'subCategory', 'pic', 'equipmentRentalRate'])
            ->where('uid', $id)
            ->firstOrFail();

        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::where('uid', $id)->firstOrFail();

        // Clean numeric values BEFORE validation
        if ($request->has('project_value')) {
            $request->merge([
                'project_value' => str_replace('.', '', $request->project_value)
            ]);
        }

        $request->validate([
            'request_date' => 'required|date',
            'project_categories_id' => 'required|exists:project_categories,id',
            'project_name' => 'required|string',
            'user_name' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'email' => 'nullable|email',
            'project_value' => 'nullable|numeric',
        ]);

        if ($project->project_status === 'AMENDMENT') {
            $oldData = $project->only($project->getFillable());
            $project->update($request->all());
            $newData = $project->only($project->getFillable());

            // Identify changed fields
            $changes = array_diff_assoc($newData, $oldData);

            if (!empty($changes)) {
                $activeAmendment = ProjectAmendment::where('project_id', $project->id)
                    ->where('status', 'IN_PROGRESS')
                    ->latest()
                    ->first();

                ProjectHistory::create([
                    'project_id' => $project->id,
                    'amendment_id' => $activeAmendment ? $activeAmendment->id : null,
                    'model_type' => 'Project',
                    'model_id' => $project->id,
                    'old_values' => array_intersect_key($oldData, $changes),
                    'new_values' => $changes,
                    'changed_by' => auth()->id(),
                ]);
            }
        } else {
            $project->update($request->all());
        }

        return response()->json(['success' => 'Project updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::where('uid', $id)->firstOrFail();

        // Only allow deletion if status is NOT STARTED
        if ($project->project_status !== 'NOT STARTED') {
            return response()->json([
                'error' => 'Cannot delete project. Only projects with status "NOT STARTED" can be deleted.'
            ], 403);
        }

        $project->delete();

        return response()->json(['success' => 'Project deleted successfully.']);
    }

    /**
     * Upload project image
     */
    public function uploadImage(Request $request, string $id)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $project = Project::where('uid', $id)->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Create directory if it doesn't exist
            $directory = storage_path('projects/' . $project->id);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Move file to storage/projects/{project_id}/
            $filePath = 'projects/' . $project->id . '/' . $fileName;
            $file->move(storage_path('projects/' . $project->id), $fileName);

            $image = ProjectImage::create([
                'project_id' => $project->id,
                'file_image' => $fileName,
                'file_path' => $filePath,
                'description' => $request->description ?? null,
            ]);

            \Log::info('New image created', ['id' => $image->id, 'uid' => $image->uid, 'path' => $filePath]);

            return response()->json([
                'success' => true,
                'image' => $image,
                'url' => url('storage/' . $filePath)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    }

    /**
     * Delete project image
     */
    public function deleteImage(string $id)
    {
        \Log::info('Deleting image', ['uid' => $id]);
        $image = ProjectImage::where('uid', $id)->firstOrFail();

        // Delete file from storage
        $fullPath = storage_path($image->file_path);
        \Log::info('Delete path', ['path' => $fullPath, 'exists' => file_exists($fullPath)]);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $image->delete();

        return response()->json(['success' => 'Image deleted successfully.']);
    }

    /**
     * Serve project image from storage
     */
    public function serveImage($project_id, $filename)
    {
        $path = storage_path('projects/' . $project_id . '/' . $filename);
        \Log::info('Serving image', ['path' => $path, 'exists' => file_exists($path)]);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
    /**
     * Search projects for Select2
     */
    public function search(Request $request)
    {
        $term = $request->term;
        $query = Project::query()->where('project_status', 'COMPLETED');

        if ($term) {
            $query->where('project_name', 'LIKE', '%' . $term . '%')
                  ->orWhere('project_number', 'LIKE', '%' . $term . '%');
        }

        $projects = $query->select('id', 'project_name', 'project_number', 'project_value')
                        ->limit(20)
                        ->get()
                        ->map(function($project) {
                            return [
                                'id' => $project->id,
                                'text' => $project->project_name . ' (' . $project->project_number . ')',
                                'project_name' => $project->project_name,
                                'project_number' => $project->project_number,
                                'project_value' => $project->project_value
                            ];
                        });

        return response()->json(['results' => $projects]);
    }
}
