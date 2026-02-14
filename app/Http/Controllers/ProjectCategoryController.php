<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = ProjectCategory::latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 edit-category-btn" 
                                    data-id="'.$row->uid.'" 
                                    data-code="'.$row->code.'" 
                                    data-name="'.$row->name.'"
                                    data-bs-toggle="offcanvas" data-bs-target="#edit_category_offcanvas">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 text-danger delete-category-btn" 
                                    data-id="'.$row->uid.'">
                                    <i class="ti ti-trash me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('projects.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Using modal in index, so no view needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:project_categories,code',
            'name' => 'required|string|unique:project_categories,name',
        ]);

        ProjectCategory::create($request->all());

        return redirect()->route('project-category.index')
            ->with('success', 'Project Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCategory $projectCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        // Using modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projectCategory = ProjectCategory::where('uid', $id)->firstOrFail();

        $request->validate([
            'code' => ['required', 'string', Rule::unique('project_categories')->ignore($projectCategory->id)],
            'name' => ['required', 'string', Rule::unique('project_categories')->ignore($projectCategory->id)],
        ]);

        $projectCategory->update($request->all());

        return redirect()->route('project-category.index')
            ->with('success', 'Project Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projectCategory = ProjectCategory::where('uid', $id)->firstOrFail();
        $projectCategory->delete();

        return redirect()->route('project-category.index')
            ->with('success', 'Project Category deleted successfully.');
    }
}
