<?php

namespace App\Http\Controllers;

use App\Models\EquimentRentalRatesHM;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EquipmentRentalRatesHMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EquimentRentalRatesHM::query()->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tarif_hm', function($row){
                    return number_format($row->tarif_hm, 0, ',', '.');
                })
                ->editColumn('harga_pasar', function($row){
                    return number_format($row->harga_pasar, 0, ',', '.');
                })
                ->editColumn('harga_fuel', function($row){
                    return number_format($row->harga_fuel, 0, ',', '.');
                })
                ->addColumn('last_update', function($row){
                    return $row->updated_at->format('j M Y');
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 edit-item-btn" 
                                    data-id="'.$row->uid.'" 
                                    data-jenis-alat="'.$row->jenis_alat.'" 
                                    data-tarif-hm="'.$row->tarif_hm.'"
                                    data-harga-pasar="'.$row->harga_pasar.'"
                                    data-harga-fuel="'.$row->harga_fuel.'"
                                    data-last-update="'.$row->updated_at.'"
                                    data-bs-toggle="offcanvas" data-bs-target="#edit_item_offcanvas">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 text-danger delete-item-btn" 
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
        
        return view('projects.equipment-rental-rates-hm.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remove dots from numeric fields for validation and storage
        $request->merge([
            'tarif_hm' => str_replace('.', '', $request->tarif_hm),
            'harga_pasar' => str_replace('.', '', $request->harga_pasar),
            'harga_fuel' => str_replace('.', '', $request->harga_fuel),
        ]);

        $request->validate([
            'jenis_alat' => 'required|string',
            'tarif_hm' => 'required|numeric',
            'harga_pasar' => 'required|numeric',
            'harga_fuel' => 'required|numeric',
        ]);

        EquimentRentalRatesHM::create($request->all());

        return response()->json(['success' => 'Equipment Rental Rate HM created successfully.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = EquimentRentalRatesHM::where('uid', $id)->firstOrFail();

        // Remove dots from numeric fields for validation and storage
        $request->merge([
            'tarif_hm' => str_replace('.', '', $request->tarif_hm),
            'harga_pasar' => str_replace('.', '', $request->harga_pasar),
            'harga_fuel' => str_replace('.', '', $request->harga_fuel),
        ]);

        $request->validate([
            'jenis_alat' => 'required|string',
            'tarif_hm' => 'required|numeric',
            'harga_pasar' => 'required|numeric',
            'harga_fuel' => 'required|numeric',
        ]);

        $item->update($request->all());

        return response()->json(['success' => 'Equipment Rental Rate HM updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = EquimentRentalRatesHM::where('uid', $id)->firstOrFail();
        $item->delete();

        return response()->json(['success' => 'Equipment Rental Rate HM deleted successfully.']);
    }
}
