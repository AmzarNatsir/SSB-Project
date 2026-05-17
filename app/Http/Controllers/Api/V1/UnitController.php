<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\WorkshopApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct(protected WorkshopApiService $units) {}

    /**
     * GET /api/v1/units/search?q=...&limit=20&status=idle
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'limit' => 'nullable|integer|min:1|max:50',
            'status' => 'nullable|string|max:30',
        ]);

        $data = $this->units->search(
            $request->string('q')->toString(),
            $request->integer('limit', 20),
            $request->string('status')->toString() ?: null
        );

        return response()->json([
            'data' => $data,
            'total' => count($data),
        ]);
    }

    /**
     * GET /api/v1/units/{id}
     */
    public function show(int $id): JsonResponse
    {
        $unit = $this->units->find($id);

        if (! $unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        return response()->json(['data' => $unit]);
    }
}
