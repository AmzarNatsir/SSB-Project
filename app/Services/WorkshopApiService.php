<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorkshopApiService
{
    protected string $apiUrl;
    protected ?string $token;
    protected int $cacheTtl;

    public function __construct()
    {
        $this->apiUrl = rtrim((string) config('services.workshop.api_url'), '/');
        $this->token = config('services.workshop.api_token');
        $this->cacheTtl = (int) config('services.workshop.cache_ttl', 120);
    }

    /**
     * Get all units. Returns the raw normalized list (used by legacy quotations.units proxy).
     *
     * @return array<int,array>
     */
    public function all(): array
    {
        return Cache::remember('workshop:units:all', $this->cacheTtl, function () {
            $response = $this->client()->get('/units');

            if (! $response->successful()) {
                Log::warning('WorkshopApiService.all failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return $this->mockData();
            }

            $raw = $response->json('data') ?? $response->json() ?? [];
            return collect($raw)
                ->map(fn ($unit) => $this->normalize($unit))
                ->values()
                ->all();
        });
    }

    /**
     * Search units for dropdown / autocomplete. Filter client-side over cached list.
     *
     * @return array<int,array>
     */
    public function search(string $query = '', int $limit = 20, ?string $status = null): array
    {
        $all = $this->all();
        $query = trim($query);

        $filtered = collect($all)
            ->when($status, fn ($c) => $c->where('status', $status))
            ->when($query !== '', fn ($c) => $c->filter(function (array $unit) use ($query) {
                return stripos($unit['name'], $query) !== false
                    || stripos((string) $unit['equipment_code'], $query) !== false
                    || stripos((string) $unit['type'], $query) !== false;
            }))
            ->take($limit)
            ->values()
            ->all();

        return $filtered;
    }

    /**
     * Single unit by external ID.
     */
    public function find(int $id): ?array
    {
        return collect($this->all())->firstWhere('id', $id);
    }

    /**
     * Single unit by UUID (some endpoints use uid as primary identifier).
     */
    public function findByUid(string $uid): ?array
    {
        return collect($this->all())->firstWhere('uid', $uid);
    }

    /**
     * Batch lookup keyed by id.
     *
     * @param  array<int,int>  $ids
     * @return array<int,array>
     */
    public function findMany(array $ids): array
    {
        $ids = array_unique(array_filter($ids));
        if (empty($ids)) {
            return [];
        }

        return collect($this->all())
            ->whereIn('id', $ids)
            ->keyBy('id')
            ->all();
    }

    public function flushCache(): void
    {
        Cache::forget('workshop:units:all');
    }

    protected function client(): PendingRequest
    {
        $request = Http::baseUrl($this->apiUrl)
            ->timeout(5)
            ->acceptJson();

        if (config('app.env') === 'local') {
            $request->withoutVerifying();
        }

        if ($this->token) {
            $request->withToken($this->token);
        }

        return $request;
    }

    /**
     * Normalize upstream shape into a single contract.
     */
    protected function normalize(array $unit): array
    {
        $id = (int) ($unit['id'] ?? 0);
        $uid = $unit['uid'] ?? $unit['uuid'] ?? null;
        $name = $unit['name'] ?? $unit['unit_name'] ?? '';
        $code = $unit['code'] ?? $unit['equipment_code'] ?? $unit['unit_code'] ?? null;
        $type = is_array($unit['type'] ?? null)
            ? ($unit['type']['name'] ?? null)
            : ($unit['type'] ?? $unit['unit_type'] ?? null);

        return [
            'id' => $id,
            'uid' => $uid,
            'name' => $name,
            'equipment_code' => $code,
            'type' => $type,
            'hm_current' => (float) ($unit['hm_current'] ?? $unit['hm'] ?? 0),
            'status' => $unit['status'] ?? null,
            'text' => trim($name . ($code ? " ({$code})" : '')),
        ];
    }

    /**
     * Local fallback so UI tetap jalan saat API workshop down.
     *
     * @return array<int,array>
     */
    protected function mockData(): array
    {
        if (config('app.env') !== 'local') {
            return [];
        }

        $mock = [
            ['id' => 1, 'uid' => 'unit-001', 'name' => 'Excavator PC200 (Mock)',  'code' => 'EXC-001', 'type' => 'Excavator',    'status' => 'idle'],
            ['id' => 2, 'uid' => 'unit-002', 'name' => 'Bulldozer D85SS (Mock)',  'code' => 'BLD-001', 'type' => 'Bulldozer',    'status' => 'idle'],
            ['id' => 3, 'uid' => 'unit-003', 'name' => 'Dump Truck HD465 (Mock)', 'code' => 'DT-001',  'type' => 'Dump Truck',   'status' => 'active'],
            ['id' => 4, 'uid' => 'unit-004', 'name' => 'Crane 50T (Mock)',        'code' => 'CRN-001', 'type' => 'Crane',        'status' => 'idle'],
            ['id' => 5, 'uid' => 'unit-005', 'name' => 'Motor Grader GD535 (Mock)', 'code' => 'MG-001', 'type' => 'Motor Grader', 'status' => 'idle'],
        ];

        return collect($mock)->map(fn ($u) => $this->normalize($u))->values()->all();
    }
}
