<?php

use App\Http\Controllers\Api\ApiUnitRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiUnitRequestController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/unit-requests', [ApiUnitRequestController::class, 'index']);
    Route::get('/unit-requests/{uid}', [ApiUnitRequestController::class, 'show']);
    Route::patch('/unit-requests/items/{id}/ready', [ApiUnitRequestController::class, 'updateItemReady']);
});


