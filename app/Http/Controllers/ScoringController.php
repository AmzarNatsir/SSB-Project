<?php

namespace App\Http\Controllers;

use App\Models\Scoring;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ScoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $scoring = Scoring::latest()->get();
            return DataTables::of($scoring)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 edit-scoring-btn" 
                                    data-id="'.$row->uid.'" 
                                    data-kebutuhan="'.$row->kebutuhan.'" 
                                    data-skor_min="'.$row->skor_min.'"
                                    data-skor_max="'.$row->skor_max.'"
                                    data-bobot="'.$row->bobot.'"
                                    data-keterangan_skor="'.$row->keterangan_skor.'"
                                    data-nama_departemen="'.$row->nama_departemen.'"
                                    data-bs-toggle="offcanvas" data-bs-target="#edit_scoring_offcanvas">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 text-danger delete-scoring-btn" 
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
        return view('reference.scoring.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kebutuhan' => 'required|string',
            'skor_min' => 'required|integer',
            'skor_max' => 'required|integer',
            'bobot' => 'required|integer',
            'nama_departemen' => 'required|string',
        ]);

        Scoring::create($request->all());

        return redirect()->route('scoring.index')
            ->with('success', 'Scoring reference created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scoring = Scoring::where('uid', $id)->firstOrFail();

        $request->validate([
            'kebutuhan' => 'required|string',
            'skor_min' => 'required|integer',
            'skor_max' => 'required|integer',
            'bobot' => 'required|integer',
            'nama_departemen' => 'required|string',
        ]);

        $scoring->update($request->all());

        return redirect()->route('scoring.index')
            ->with('success', 'Scoring reference updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scoring = Scoring::where('uid', $id)->firstOrFail();
        $scoring->delete();

        return redirect()->route('scoring.index')
            ->with('success', 'Scoring reference deleted successfully.');
    }
}
