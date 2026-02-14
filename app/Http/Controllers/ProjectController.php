<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;
use App\Models\User;
use App\Models\EquimentRentalRatesHM;
use App\Models\ProjectImage;
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
                    
                    if ($row->project_status === 'NOT STARTED') {
                        $editBtn = '<a href="javascript:void(0);" class="btn btn-sm btn-warning me-1 edit-project-btn" 
                            data-id="'.$row->uid.'">
                            <i class="ti ti-edit"></i>
                        </a>';
                        
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
        $project = Project::with(['category', 'subCategory', 'pic', 'equipmentRentalRate', 'images'])
            ->where('uid', $id)
            ->firstOrFail();
        
        return view('projects.show', compact('project'));
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

        $project->update($request->all());

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
}
