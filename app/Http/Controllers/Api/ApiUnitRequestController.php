<?php

namespace App\Http\Controllers\Api;

use App\Enums\UnitRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\UnitRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Unit Request API",
    version: "1.0.0",
    description: "API for managing Unit Requests for Workshop use."
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
    #[OA\Get(
        path: "/unit-requests",
        summary: "List unit requests forwarded to workshop",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of forwarded unit requests with items",
                content: new OA\JsonContent(type: "array", items: new OA\Items(type: "object"))
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            )
        ]
    )]
    public function index()
    {
        $requests = UnitRequest::with([
            'project',
            'items.quotationItem',
            'creator'
        ])
            ->where('status', UnitRequestStatus::FORWARDED_TO_WORKSHOP)
            ->latest()
            ->get();

        return response()->json($requests);
    }

    #[OA\Get(
        path: "/unit-requests/{uid}",
        summary: "Get details of a specific unit request",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "uid",
                in: "path",
                required: true,
                description: "UID of the unit request",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Unit request details",
                content: new OA\JsonContent(type: "object")
            ),
            new OA\Response(response: 404, description: "Not found"),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function show($uid)
    {
        $unitRequest = UnitRequest::with([
            'project',
            'items.quotationItem',
            'creator'
        ])->where('uid', $uid)->firstOrFail();

        return response()->json($unitRequest);
    }

    #[OA\Patch(
        path: "/unit-requests/items/{id}/ready",
        summary: "Update readiness status of a unit request item",
        tags: ["Unit Request"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the unit request item",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["unit_ready"],
                properties: [
                    new OA\Property(property: "unit_ready", type: "boolean", example: true),
                    new OA\Property(property: "operator_id", type: "integer", example: 1),
                    new OA\Property(property: "operator_name", type: "string", example: "Operator Name")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Readiness status updated successfully",
                content: new OA\JsonContent(type: "object")
            ),
            new OA\Response(response: 404, description: "Item not found"),
            new OA\Response(response: 401, description: 'Unauthenticated')
        ]
    )]
    public function updateItemReady(Request $request, $id)
    {
        $request->validate([
            'unit_ready' => 'required|boolean'
        ]);

        $item = \App\Models\UnitRequestItem::findOrFail($id);
        $item->update([
            'unit_ready' => $request->unit_ready,
            'operator_id' => $request->operator_id,
            'operator_name' => $request->operator_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit readiness status updated.',
            'item' => $item
        ]);
    }
}

