<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\EmployeeApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeApiService $employees) {}

    /**
     * GET /api/v1/employees/search?q=...&limit=20&department_id=0
     *
     * Frontend dropdown (Select2 / TomSelect) consumes this.
     * department_id = 0 (default) → semua karyawan.
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'limit' => 'nullable|integer|min:1|max:50',
            'department_id' => 'nullable|integer|min:0',
        ]);

        $data = $this->employees->search(
            $request->string('q')->toString(),
            $request->integer('limit', 20),
            $request->integer('department_id', 0)
        );

        return response()->json([
            'data' => $data,
            'total' => count($data),
        ]);
    }

    /**
     * GET /api/v1/employees/{id}
     */
    public function show(int $id): JsonResponse
    {
        $emp = $this->employees->find($id);

        if (! $emp) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['data' => $emp]);
    }
}
