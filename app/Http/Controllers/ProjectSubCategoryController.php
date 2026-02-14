<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategories = ProjectSubCategory::with('category')->latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($subCategories)
                ->addIndexColumn()
                ->addColumn('category_name', function($row){
                    return $row->category ? $row->category->name : '-';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 edit-sub-category-btn" 
                                    data-id="'.$row->uid.'" 
                                    data-category-id="'.$row->category_id.'"
                                    data-code="'.$row->code.'" 
                                    data-name="'.$row->name.'"
                                    data-bs-toggle="offcanvas" data-bs-target="#edit_sub_category_offcanvas">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 text-danger delete-sub-category-btn" 
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
        
        $categories = ProjectCategory::all(); // For the Add/Edit dropdowns
        return view('projects.sub-category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'code' => 'required|string|unique:project_sub_categories,code',
            'name' => 'required|string',
        ]);

        ProjectSubCategory::create($request->all());

        return redirect()->route('project-sub-category.index')
            ->with('success', 'Project Sub Category created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subCategory = ProjectSubCategory::where('uid', $id)->firstOrFail();

        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'code' => ['required', 'string', Rule::unique('project_sub_categories')->ignore($subCategory->id)],
            'name' => 'required|string',
        ]);

        $subCategory->update($request->all());

        return redirect()->route('project-sub-category.index')
            ->with('success', 'Project Sub Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = ProjectSubCategory::where('uid', $id)->firstOrFail();
        $subCategory->delete();

        return redirect()->route('project-sub-category.index')
            ->with('success', 'Project Sub Category deleted successfully.');
    }
}
