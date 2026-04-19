<?php

namespace App\Http\Controllers;

use App\Models\ScoringCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ScoringPlanProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $criteria = ScoringCriteria::withCount('options')->latest()->get();
            return DataTables::of($criteria)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="'.route('scoring-plan-project.edit', $row->id).'" class="dropdown-item rounded-1">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <form action="'.route('scoring-plan-project.destroy', $row->id).'" method="POST" class="d-inline">
                                    '.csrf_field().'
                                    '.method_field("DELETE").'
                                    <button type="button" class="dropdown-item rounded-1 text-danger delete-btn">
                                        <i class="ti ti-trash me-2"></i>Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('reference.scoring_plan_project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reference.scoring_plan_project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weighting' => 'required|integer',
            'options' => 'required|array|min:1',
            'options.*.label' => 'required|string|max:255',
            'options.*.score' => 'required|integer',
            'options.*.description' => 'required|string',
        ], [
            'options.required' => 'At least one scoring option must be provided.',
            'options.*.label.required' => 'The option label is required.',
            'options.*.score.required' => 'The option score is required.',
            'options.*.description.required' => 'The option description is required.',
        ]);

        DB::beginTransaction();
        try {
            $criteria = ScoringCriteria::create([
                'name' => $request->name,
                'weighting' => $request->weighting,
            ]);

            foreach ($request->options as $option) {
                $criteria->options()->create([
                    'label' => $option['label'],
                    'score' => $option['score'],
                    'description' => $option['description']
                ]);
            }

            DB::commit();
            return redirect()->route('scoring-plan-project.index')->with('success', 'Scoring Plan created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create Scoring Plan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $criteria = ScoringCriteria::with('options')->findOrFail($id);
        return view('reference.scoring_plan_project.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weighting' => 'required|integer',
            'options' => 'required|array|min:1',
            'options.*.label' => 'required|string|max:255',
            'options.*.score' => 'required|integer',
            'options.*.description' => 'required|string',
        ], [
            'options.required' => 'At least one scoring option must be provided.',
            'options.*.label.required' => 'The option label is required.',
            'options.*.score.required' => 'The option score is required.',
            'options.*.description.required' => 'The option description is required.',
        ]);

        $criteria = ScoringCriteria::findOrFail($id);

        DB::beginTransaction();
        try {
            $criteria->update([
                'name' => $request->name,
                'weighting' => $request->weighting,
            ]);

            // Recreate options to keep it simple and handle additions/deletions easily
            $criteria->options()->delete();
            foreach ($request->options as $option) {
                $criteria->options()->create([
                    'label' => $option['label'],
                    'score' => $option['score'],
                    'description' => $option['description']
                ]);
            }

            DB::commit();
            return redirect()->route('scoring-plan-project.index')->with('success', 'Scoring Plan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update Scoring Plan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $criteria = ScoringCriteria::findOrFail($id);
        $criteria->delete(); // options will be cascade-deleted by DB constraint

        return redirect()->route('scoring-plan-project.index')->with('success', 'Scoring Plan deleted successfully.');
    }
    /**
     * Show the full view table component.
     */
    public function fullView()
    {
        $criteria = ScoringCriteria::with('options')->orderBy('id', 'asc')->get();
        return view('reference.scoring_plan_project._full_view_table', compact('criteria'));
    }

    /**
     * Export the full view as PDF.
     */
    public function exportPdf()
    {
        $criteria = ScoringCriteria::with('options')->orderBy('id', 'asc')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reference.scoring_plan_project.pdf', compact('criteria'))
                    ->setPaper('a4', 'landscape');
                    
        return $pdf->stream('Scoring_Plan_Project.pdf');
    }
}
