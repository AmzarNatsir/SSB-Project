<?php

namespace App\Http\Controllers;

use App\Services\EmployeeApiService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function userPhoto(int $employeeId): Response
    {
        if ($employeeId <= 0) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        try {
            $apiUrl = rtrim((string) config('services.employee.api_url'), '/');
            $token = config('services.employee.api_token');

            $client = Http::baseUrl($apiUrl)->timeout(20)->connectTimeout(5);
            if (config('app.env') === 'local') {
                $client->withoutVerifying();
            }
            if ($token) {
                $client->withToken($token);
            }

            $response = $client->get("/api/hrd/photo/{$employeeId}");

            if (!$response->successful()) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            $body = $response->body();
            if ($body === '' || strlen($body) < 64) {
                return response('', Response::HTTP_NOT_FOUND);
            }

            return response($body, Response::HTTP_OK, [
                'Content-Type' => $response->header('Content-Type') ?: 'image/jpeg',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        } catch (\Throwable $e) {
            Log::warning('MediaController.userPhoto error', [
                'id' => $employeeId,
                'message' => $e->getMessage(),
            ]);
            return response('', Response::HTTP_NOT_FOUND);
        }
    }
}
