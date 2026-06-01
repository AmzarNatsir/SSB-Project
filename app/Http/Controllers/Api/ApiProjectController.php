<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ApiProjectController extends Controller
{
    #[OA\Get(
        path: "/projects",
        summary: "List Project (uid, project_name, project_code)",
        description: "Mengembalikan daftar project dalam bentuk ringkas: hanya uid, project_name, dan project_code. **Hanya menampilkan project dengan project_status = COMPLETED**. Mendukung pencarian via parameter `q` (mencari di project_name / project_code / project_number) dan paginasi via `per_page` (default 25, max 100).",
        tags: ["Project"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "q",
                in: "query",
                required: false,
                description: "Kata kunci pencarian (project_name / project_code / project_number).",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                description: "Jumlah item per halaman (1-100, default 25).",
                schema: new OA\Schema(type: "integer", default: 25, minimum: 1, maximum: 100)
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar project (paginated)"),
            new OA\Response(
                response: 401,
                description: "Unauthenticated — token tidak dikirim / tidak valid / expired. Login dulu via POST /api/login lalu klik tombol Authorize di atas.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Unauthenticated."),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 25);
        $perPage = max(1, min($perPage, 100));
        $q = trim((string) $request->query('q', ''));

        $query = Project::query()
            ->select(['id', 'uid', 'project_name', 'project_code'])
            ->where('project_status', 'COMPLETED')
            ->latest('id');

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('project_name', 'like', "%{$q}%")
                  ->orWhere('project_code', 'like', "%{$q}%")
                  ->orWhere('project_number', 'like', "%{$q}%");
            });
        }

        $paginator = $query->paginate($perPage);

        $paginator->getCollection()->transform(fn ($p) => [
            'uid' => $p->uid,
            'project_name' => $p->project_name,
            'project_code' => $p->project_code,
        ]);

        return response()->json($paginator);
    }

    #[OA\Get(
        path: "/projects/{uid}",
        summary: "Detail Project (seluruh data)",
        description: "Mengembalikan seluruh data project beserta relasi utama (kategori, subkategori, PIC, equipment rental rate, surveys, latest budget/quotation/negotiation, contracts aktif, unit requests, replacements, returns, transfers). **Hanya project dengan project_status = COMPLETED yang dapat diakses.**",
        tags: ["Project"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID (UUID) Project",
                schema: new OA\Schema(type: "string", format: "uuid")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Detail project"),
            new OA\Response(response: 404, description: "Project tidak ditemukan"),
            new OA\Response(
                response: 401,
                description: "Unauthenticated — token tidak dikirim / tidak valid / expired. Login dulu via POST /api/login lalu klik tombol Authorize di atas.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Unauthenticated."),
                    ]
                )
            ),
        ]
    )]
    public function show(string $uid): JsonResponse
    {
        $project = Project::with([
            'category',
            'subCategory',
            'pic',
            'equipmentRentalRate',
            'unitRequests' => function ($query) {
                $query->where('status', \App\Enums\UnitRequestStatus::APPROVED_FROM_WORKSHOP)
                      ->with(['items', 'creator:id,name'])->latest();
            },
        ])->where('uid', $uid)->where('project_status', 'COMPLETED')->firstOrFail();

        return response()->json($project);
    }
}
