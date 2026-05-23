<?php

namespace App\Http\Controllers\Api;

use App\Enums\UnitRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\UnitRequest;
use App\Models\UnitRequestItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Project Documentation API",
    version: "1.0.0",
    description: "API untuk integrasi dengan aplikasi Workshop. Endpoint ini dipakai aplikasi terpisah untuk menerima Permintaan Unit yang sudah diteruskan, menyetujui penyiapan unit, dan mengupdate kesiapan tiap item."
)]
#[OA\Server(
    url: "/api",
    description: "SSB Project API Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class ApiUnitRequestController extends Controller
{
    /**
     * Login endpoint (Sanctum personal access token).
     */
    #[OA\Post(
        path: "/login",
        summary: "Generate Bearer Token (Sanctum) — sementara",
        description: "Endpoint sementara untuk testing. Login dengan email & password user yang sudah ada, dapatkan Bearer Token untuk dipakai di tombol Authorize di atas.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "admin@ssb.test"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login berhasil — token diterbitkan",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "token", type: "string", example: "1|abcdef1234567890..."),
                        new OA\Property(
                            property: "user",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "name", type: "string", example: "Admin"),
                                new OA\Property(property: "email", type: "string", example: "admin@ssb.test"),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Invalid credentials"),
            new OA\Response(response: 422, description: "Validasi gagal"),
        ]
    )]
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('workshop-api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    #[OA\Get(
        path: "/unit-requests",
        summary: "List Permintaan Unit yang sudah diteruskan ke Workshop",
        description: "Default-nya hanya menampilkan status FORWARDED_TO_WORKSHOP. Gunakan parameter ?status=APPROVED_FROM_WORKSHOP, ?status=REJECTED_FROM_WORKSHOP, kombinasi (comma-separated), atau ?status=all untuk mengubah filter.",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "status",
                in: "query",
                required: false,
                description: "Filter status. Default: FORWARDED_TO_WORKSHOP. Boleh comma-separated (mis. FORWARDED_TO_WORKSHOP,APPROVED_FROM_WORKSHOP) atau 'all'.",
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
            new OA\Response(response: 200, description: "List Permintaan Unit (paginated)"),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Parameter status tidak valid"),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $statusParam = $request->query('status', 'FORWARDED_TO_WORKSHOP');
        $perPage = (int) $request->query('per_page', 25);
        $perPage = max(1, min($perPage, 100));

        $query = UnitRequest::with([
            'project:id,project_code,project_name',
            'contract:id,contract_number,start_date,end_date,status',
            'items',
            'creator:id,name,email',
        ])->latest();

        if ($statusParam !== 'all') {
            $statuses = collect(explode(',', $statusParam))
                ->map(fn ($s) => trim($s))
                ->filter()
                ->map(fn ($s) => UnitRequestStatus::tryFrom($s))
                ->filter()
                ->values()
                ->all();

            if (empty($statuses)) {
                return response()->json([
                    'message' => 'Parameter status tidak valid.',
                ], 422);
            }

            $query->whereIn('status', $statuses);
        }

        return response()->json($query->paginate($perPage));
    }

    #[OA\Get(
        path: "/unit-requests/{uid}",
        summary: "Detail satu Permintaan Unit",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID (UUID) Permintaan Unit",
                schema: new OA\Schema(type: "string", format: "uuid")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Detail Permintaan Unit"),
            new OA\Response(response: 404, description: "Tidak ditemukan"),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function show(string $uid): JsonResponse
    {
        $unitRequest = UnitRequest::with([
            'project:id,project_code,project_name',
            'contract:id,contract_number,start_date,end_date,status',
            'items',
            'creator:id,name,email',
        ])->where('uid', $uid)->firstOrFail();

        return response()->json($unitRequest);
    }

    #[OA\Patch(
        path: "/unit-requests/{uid}/status",
        summary: "Update status Permintaan Unit",
        description: "Workshop memakai endpoint ini untuk menyetujui atau menolak Permintaan Unit yang diteruskan. Hanya transisi yang diizinkan UnitRequestStatus::canTransitionTo() yang diterima (mis. FORWARDED_TO_WORKSHOP → APPROVED_FROM_WORKSHOP / REJECTED_FROM_WORKSHOP).",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID (UUID) Permintaan Unit",
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
                        description: "Status tujuan. Untuk Workshop: APPROVED_FROM_WORKSHOP (menyetujui penyiapan unit) atau REJECTED_FROM_WORKSHOP (menolak permintaan).",
                        enum: [
                            "DRAFT",
                            "SUBMITTED",
                            "APPROVED",
                            "REJECTED",
                            "FORWARDED_TO_WORKSHOP",
                            "APPROVED_FROM_WORKSHOP",
                            "REJECTED_FROM_WORKSHOP",
                        ],
                        example: "APPROVED_FROM_WORKSHOP"
                    ),
                    new OA\Property(
                        property: "notes",
                        type: "string",
                        nullable: true,
                        description: "Catatan opsional dari Workshop (mis. alasan penolakan).",
                        example: "Unit siap kirim per 2026-05-25"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Status berhasil diupdate"),
            new OA\Response(response: 422, description: "Status tidak valid atau transisi tidak diizinkan"),
            new OA\Response(response: 404, description: "Permintaan Unit tidak ditemukan"),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function updateStatus(Request $request, string $uid): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        $newStatus = UnitRequestStatus::tryFrom($data['status']);
        if (! $newStatus) {
            throw ValidationException::withMessages([
                'status' => "Status '{$data['status']}' tidak dikenali.",
            ]);
        }

        $unitRequest = UnitRequest::where('uid', $uid)->firstOrFail();

        if (! $unitRequest->status->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => "Transisi {$unitRequest->status->value} → {$newStatus->value} tidak diizinkan.",
            ]);
        }

        DB::transaction(function () use ($unitRequest, $newStatus, $data) {
            $unitRequest->update([
                'status' => $newStatus,
                'notes' => $data['notes'] ?? $unitRequest->notes,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => "Status berhasil diupdate ke {$newStatus->value}.",
            'data' => $unitRequest->fresh(['items']),
        ]);
    }

    #[OA\Patch(
        path: "/unit-requests/items/{id}/ready",
        summary: "Update kesiapan unit per item (unit_ready, operator_id, operator_name)",
        description: "Hanya bisa dipanggil saat parent UnitRequest berstatus FORWARDED_TO_WORKSHOP atau APPROVED_FROM_WORKSHOP.",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID unit_request_items",
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
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Kesiapan unit berhasil diupdate"),
            new OA\Response(response: 422, description: "Parent UnitRequest tidak dalam status yang diizinkan"),
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
        ]);

        $item = UnitRequestItem::with('unitRequest')->findOrFail($id);

        $parentStatus = $item->unitRequest?->status;
        $allowedParentStatuses = [
            UnitRequestStatus::FORWARDED_TO_WORKSHOP,
            UnitRequestStatus::APPROVED_FROM_WORKSHOP,
        ];

        if (! in_array($parentStatus, $allowedParentStatuses, true)) {
            throw ValidationException::withMessages([
                'status' => 'Item hanya dapat diupdate pada Permintaan Unit berstatus FORWARDED_TO_WORKSHOP atau APPROVED_FROM_WORKSHOP.',
            ]);
        }

        $item->update([
            'unit_ready' => $data['unit_ready'],
            'operator_id' => $data['operator_id'] ?? $item->operator_id,
            'operator_name' => $data['operator_name'] ?? $item->operator_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kesiapan unit berhasil diupdate.',
            'data' => $item->fresh(),
        ]);
    }
}
