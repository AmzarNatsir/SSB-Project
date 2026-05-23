<?php

use App\Http\Controllers\Api\ApiUnitRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiUnitRequestController::class, 'login']);
Route::get('/projects/search', [\App\Http\Controllers\ProjectController::class, 'search']);

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // List & detail Permintaan Unit (default: hanya FORWARDED_TO_WORKSHOP)
    Route::get('/unit-requests', [ApiUnitRequestController::class, 'index']);

    // Constraint UUID v4 (36 chars hex+hyphen) agar tidak menangkap path lain seperti
    // /api/unit-requests/eligible-contracts (web.php) yang punya middleware berbeda.
    Route::get('/unit-requests/{uid}', [ApiUnitRequestController::class, 'show'])
        ->where('uid', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');

    // Workshop update status (FORWARDED_TO_WORKSHOP → APPROVED_FROM_WORKSHOP / REJECTED_FROM_WORKSHOP)
    // Transisi divalidasi via UnitRequestStatus::canTransitionTo()
    Route::patch('/unit-requests/{uid}/status', [ApiUnitRequestController::class, 'updateStatus'])
        ->where('uid', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');

    // Update kesiapan unit per item (unit_ready, operator_id, operator_name)
    Route::patch('/unit-requests/items/{id}/ready', [ApiUnitRequestController::class, 'updateItemReady'])
        ->where('id', '[0-9]+');

    // === Unit Replacements (PTU) ===
    Route::get('/unit-replacements', [\App\Http\Controllers\Api\ApiUnitReplacementController::class, 'index']);
    Route::get('/unit-replacements/{uid}', [\App\Http\Controllers\Api\ApiUnitReplacementController::class, 'show'])
        ->where('uid', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');
    Route::patch('/unit-replacements/{uid}/status', [\App\Http\Controllers\Api\ApiUnitReplacementController::class, 'updateStatus'])
        ->where('uid', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');
    Route::patch('/unit-replacements/items/{id}/ready', [\App\Http\Controllers\Api\ApiUnitReplacementController::class, 'updateItemReady'])
        ->where('id', '[0-9]+');
});
