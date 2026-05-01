<?php

namespace App\Http\Controllers;

use App\Enums\SurveyDepartment;
use App\Enums\SurveyorType;
use App\Models\SurveyorFlow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SurveyorFlowController extends Controller
{
    /**
     * Display the surveyor matrix index page.
     */
    public function index()
    {
        $flows        = SurveyorFlow::with(['user', 'role'])->get();
        $departments  = SurveyDepartment::cases();
        $users        = User::orderBy('name')->get();
        $roles        = Role::orderBy('name')->get();
        $surveyorTypes = SurveyorType::cases();

        return view('settings.surveyor-flows.index', compact(
            'flows', 'departments', 'users', 'roles', 'surveyorTypes'
        ));
    }

    /**
     * Sync all surveyor mappings — replace existing with fresh payload (AJAX PUT).
     */
    public function update(Request $request)
    {
        $request->validate([
            'flows'                 => 'present|array',
            'flows.*.department'    => 'required|string',
            'flows.*.surveyor_type' => 'required|in:USER,ROLE',
            'flows.*.user_id'       => 'nullable|exists:users,id',
            'flows.*.role_id'       => 'nullable|exists:roles,id',
        ]);

        DB::transaction(function () use ($request) {
            // Full sync: wipe existing and re-insert from client state
            SurveyorFlow::query()->delete();

            foreach ($request->flows as $item) {
                SurveyorFlow::create([
                    'department'    => $item['department'],
                    'surveyor_type' => $item['surveyor_type'],
                    'user_id'       => $item['surveyor_type'] === 'USER' ? ($item['user_id'] ?? null) : null,
                    'role_id'       => $item['surveyor_type'] === 'ROLE' ? ($item['role_id'] ?? null) : null,
                    'is_active'     => true,
                ]);
            }
        });

        return response()->json(['message' => 'Pengaturan surveyor berhasil disimpan!']);
    }

    /**
     * Delete a specific department mapping (kept for compatibility).
     */
    public function destroy($department)
    {
        SurveyorFlow::where('department', $department)->delete();

        return response()->json(['message' => 'Pengaturan surveyor berhasil dihapus!']);
    }
}
