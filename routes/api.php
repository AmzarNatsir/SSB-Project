<?php

use App\Http\Controllers\Api\ApiUnitRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiUnitRequestController::class, 'login']);
Route::get('/projects/search', [\App\Http\Controllers\ProjectController::class, 'search']);

Route::middleware('auth:sanctum', 'throttle:60,1')->group(function () {
    Route::get('/unit-requests', [ApiUnitRequestController::class, 'index']);
    Route::get('/unit-requests/{uid}', [ApiUnitRequestController::class, 'show']);
    Route::patch('/unit-requests/items/{id}/ready', [ApiUnitRequestController::class, 'updateItemReady']);
});


