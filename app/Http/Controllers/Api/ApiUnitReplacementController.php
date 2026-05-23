<?php

namespace App\Http\Controllers\Api;

use App\Enums\UnitReplacementStatus;
use App\Http\Controllers\Controller;
use App\Models\UnitReplacement;
use App\Models\UnitReplacementItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class ApiUnitReplacementController extends Controller
{
    #[OA\Get(
        path: "/unit-replacements",
        summary: "List Penggantian Unit (PTU) yang sudah diteruskan ke Workshop",
        description: "Default-nya hanya menampilkan status FORWARDED_TO_WORKSHOP. Gunakan parameter ?status=APPROVED_FROM_WORKSHOP, ?status=REJECTED_FROM_WORKSHOP, kombinasi (comma-separated), atau ?status=all untuk mengubah filter.",
        tags: ["Unit Replacement"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "status",
                in: "query",
                required: false,
                description: "Filter status. Default: FORWARDED_TO_WORKSHOP. Boleh comma-separated atau 'all'.",
                schema: new OA\Schema(type: "string", example: "FORWARDED_TO_WORKSHOP")
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                description: "Jumlah item per halaman (1-100). Default: 25.",
                schema: new OA\Schema(type: "integer", default: 25, minimum: 1, maximum: 100)
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: "List PTU (paginated)"),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Parameter status tidak valid"),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $statusParam = $request->query('status', 'FORWARDED_TO_WORKSHOP');
        $perPage = (int) $request->query('per_page', 25);
        $perPage = max(1, min($perPage, 100));

        $query = UnitReplacement::with([
            'project:id,project_code,project_name',
            'unitRequest:id,uid,request_number',
            'contract:id,contract_number,start_date,end_date,status',
            'items',
            'creator:id,name,email',
        ])->latest();

        if ($statusParam !== 'all') {
            $statuses = collect(explode(',', $statusParam))
                ->map(fn ($s) => trim($s))
                ->filter()
                ->map(fn ($s) => UnitReplacementStatus::tryFrom($s))
                ->filter()
                ->values()
                ->all();

            if (empty($statuses)) {
                return response()->json(['message' => 'Parameter status tidak valid.'], 422);
            }

            $query->whereIn('status', $statuses);
        }

        return response()->json($query->paginate($perPage));
    }

    #[OA\Get(
        path: "/unit-replacements/{uid}",
        summary: "Detail satu PTU",
        tags: ["Unit Replacement"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID (UUID) PTU",
                schema: new OA\Schema(type: "string", format: "uuid")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Detail PTU"),
            new OA\Response(response: 404, description: "Tidak ditemukan"),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function show(string $uid): JsonResponse
    {
        $unitReplacement = UnitReplacement::with([
            'project:id,project_code,project_name',
            'unitRequest:id,uid,request_number',
            'contract:id,contract_number,start_date,end_date,status',
            'items',
            'creator:id,name,email',
        ])->where('uid', $uid)->firstOrFail();

        return response()->json($unitReplacement);
    }

    #[OA\Patch(
        path: "/unit-replacements/{uid}/status",
        summary: "Update status PTU",
        description: "Workshop memakai endpoint ini untuk menyetujui atau menolak PTU yang diteruskan. Hanya transisi yang diizinkan UnitReplacementStatus::canTransitionTo() yang diterima.",
        tags: ["Unit Replacement"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID (UUID) PTU",
                schema: new OA\Schema(type: "string", format: "uuid")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["status"],
                properties: [
                    new OA\Property(
                        property: "status",
                        type: "string",
                        description: "Status tujuan. Untuk Workshop: APPROVED_FROM_WORKSHOP atau REJECTED_FROM_WORKSHOP.",
                        enum: [
                            "DRAFT", "SUBMITTED", "APPROVED", "REJECTED",
                            "FORWARDED_TO_WORKSHOP", "APPROVED_FROM_WORKSHOP", "REJECTED_FROM_WORKSHOP",
                        ],
                        example: "APPROVED_FROM_WORKSHOP"
                    ),
                    new OA\Property(property: "notes", type: "string", nullable: true, example: "Unit pengganti siap kirim"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Status berhasil diupdate"),
            new OA\Response(response: 422, description: "Status tidak valid atau transisi tidak diizinkan"),
            new OA\Response(response: 404, description: "PTU tidak ditemukan"),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function updateStatus(Request $request, string $uid): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        $newStatus = UnitReplacementStatus::tryFrom($data['status']);
        if (! $newStatus) {
            throw ValidationException::withMessages([
                'status' => "Status '{$data['status']}' tidak dikenali.",
            ]);
        }

        $unitReplacement = UnitReplacement::where('uid', $uid)->firstOrFail();

        if (! $unitReplacement->status->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => "Transisi {$unitReplacement->status->value} → {$newStatus->value} tidak diizinkan.",
            ]);
        }

        DB::transaction(function () use ($unitReplacement, $newStatus, $data) {
            $unitReplacement->update([
                'status' => $newStatus,
                'notes' => $data['notes'] ?? $unitReplacement->notes,
            ]);

            // Saat workshop approve, tandai original UR items sebagai sudah diganti
            if ($newStatus === UnitReplacementStatus::APPROVED_FROM_WORKSHOP) {
                $unitReplacement->load('items');
                foreach ($unitReplacement->items as $ptuItem) {
                    if ($ptuItem->original_unit_request_item_id) {
                        \App\Models\UnitRequestItem::where('id', $ptuItem->original_unit_request_item_id)
                            ->whereNull('replaced_at')
                            ->update([
                                'replaced_at' => now(),
                                'replaced_by_item_id' => $ptuItem->id,
                            ]);
                    }
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Status berhasil diupdate ke {$newStatus->value}.",
            'data' => $unitReplacement->fresh(['items']),
        ]);
    }

    #[OA\Patch(
        path: "/unit-replacements/items/{id}/ready",
        summary: "Update kesiapan unit pengganti per item",
        description: "Hanya bisa dipanggil saat parent PTU berstatus FORWARDED_TO_WORKSHOP atau APPROVED_FROM_WORKSHOP.",
        tags: ["Unit Replacement"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID unit_replacement_items",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["unit_ready"],
                properties: [
                    new OA\Property(property: "unit_ready", type: "boolean", example: true),
                    new OA\Property(property: "operator_id", type: "integer", nullable: true, example: 12),
                    new OA\Property(property: "operator_name", type: "string", nullable: true, example: "Budi Santoso"),
                    new OA\Property(property: "remarks", type: "string", nullable: true, example: "Unit ready, ready to mob"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Kesiapan unit berhasil diupdate"),
            new OA\Response(response: 422, description: "Parent PTU tidak dalam status yang diizinkan"),
            new OA\Response(response: 404, description: "Item tidak ditemukan"),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function updateItemReady(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'unit_ready' => 'required|boolean',
            'operator_id' => 'nullable|integer',
            'operator_name' => 'nullable|string|max:200',
            'remarks' => 'nullable|string|max:500',
        ]);

        $item = UnitReplacementItem::with('unitReplacement')->findOrFail($id);

        $parentStatus = $item->unitReplacement?->status;
        $allowed = [
            UnitReplacementStatus::FORWARDED_TO_WORKSHOP,
            UnitReplacementStatus::APPROVED_FROM_WORKSHOP,
        ];

        if (! in_array($parentStatus, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => 'Item hanya dapat diupdate pada PTU berstatus FORWARDED_TO_WORKSHOP atau APPROVED_FROM_WORKSHOP.',
            ]);
        }

        $item->update([
            'unit_ready' => $data['unit_ready'],
            'operator_id' => $data['operator_id'] ?? $item->operator_id,
            'operator_name' => $data['operator_name'] ?? $item->operator_name,
            'remarks' => $data['remarks'] ?? $item->remarks,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kesiapan unit pengganti berhasil diupdate.',
            'data' => $item->fresh(),
        ]);
    }
}
