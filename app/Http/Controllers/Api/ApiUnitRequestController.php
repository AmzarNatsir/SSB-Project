<?php

namespace App\Http\Controllers\Api;

use App\Enums\UnitRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\UnitRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
    #[OA\Post(
        path: "/login",
        summary: "User login to get API token",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "admin@example.com"),
                    new OA\Property(property: "password", type: "string", example: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful login",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "token", type: "string"),
                        new OA\Property(property: "user", type: "object")
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $deviceName = $request->device_name ?? 'api-token';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

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
            new OA\Response(response: 404, description: "Not found")
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
            new OA\Response(response: 404, description: "Item not found")
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

