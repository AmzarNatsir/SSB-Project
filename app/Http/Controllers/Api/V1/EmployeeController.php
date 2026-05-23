<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\EmployeeApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $emp = $this->employees->getProfile($id);

        if (! $emp) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['data' => $emp]);
    }

    /**
     * GET /employees/{id}/photo
     * Proxy ke API HRD /api/hrd/photo/{id}. Return 404 jika tidak ada
     * sehingga frontend bisa fallback ke initial avatar via <img onerror>.
     */
    public function photo(int $id): Response
    {
        $photo = $this->employees->streamPhoto($id);

        if (! $photo) {
            abort(404);
        }

        return response($photo['content'], 200, [
            'Content-Type' => $photo['mime'],
            'Cache-Control' => 'public, max-age=300',
        ]);
    }
}
