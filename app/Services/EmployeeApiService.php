<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmployeeApiService
{
    protected string $apiUrl;
    protected ?string $token;
    protected int $cacheTtl;
    protected int $timeout;

    public function __construct()
    {
        $this->apiUrl = rtrim((string) config('services.employee.api_url'), '/');
        $this->token = config('services.employee.api_token');
        $this->cacheTtl = (int) config('services.employee.cache_ttl', 300);
        $this->timeout = (int) config('services.employee.timeout', 20);
    }

    /**
     * Search employees for dropdown / autocomplete.
     * Filtering by `q` is done client-side after fetching the department list.
     *
     * @return array<int,array{id:int,name:string,position:?string,text:string}>
     */
    public function search(string $query = '', int $limit = 20, int $departmentId = 0): array
    {
        $all = $this->getByDepartment($departmentId);
        $query = trim($query);

        $filtered = $query === ''
            ? $all
            : array_values(array_filter($all, function (array $emp) use ($query) {
                return stripos($emp['name'], $query) !== false
                    || stripos((string) $emp['employee_number'], $query) !== false
                    || stripos((string) $emp['position'], $query) !== false;
            }));

        return array_slice($filtered, 0, $limit);
    }

    /**
     * Get all employees in a department (0 = all departments).
     * Cached per department.
     *
     * @return array<int,array>
     */
    public function getByDepartment(int $departmentId = 0): array
    {
        $cacheKey = "employees:dept:{$departmentId}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($departmentId) {
            try {
                $response = $this->client()->get("/api/hrd/employee/department/{$departmentId}");
            } catch (ConnectionException $e) {
                Log::warning('EmployeeApiService.getByDepartment connection error', [
                    'department_id' => $departmentId,
                    'message' => $e->getMessage(),
                ]);
                return $this->mockData();
            } catch (\Throwable $e) {
                Log::error('EmployeeApiService.getByDepartment unexpected error', [
                    'department_id' => $departmentId,
                    'message' => $e->getMessage(),
                ]);
                return $this->mockData();
            }

            if (! $response->successful()) {
                Log::warning('EmployeeApiService.getByDepartment failed', [
                    'department_id' => $departmentId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return $this->mockData();
            }

            $raw = $response->json('data') ?? $response->json() ?? [];
            return collect($raw)
                ->map(fn ($emp) => $this->normalize($emp))
                ->values()
                ->all();
        });
    }

    /**
     * Get a single employee by external ID (for snapshot when saving transaction).
     * Looks up inside the cached "all departments" list.
     */
    public function find(int $id): ?array
    {
        return collect($this->getByDepartment(0))
            ->firstWhere('id', $id);
    }

    /**
     * Fetch single employee profile via /api/hrd/profile/{id}.
     * Falls back to find() (cached list) if endpoint fails.
     */
    public function getProfile(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $cacheKey = "employees:profile:{$id}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($id) {
            try {
                $response = $this->client()->get("/api/hrd/profile/{$id}");
                if ($response->successful()) {
                    $raw = $response->json('data') ?? $response->json() ?? null;
                    if (is_array($raw) && ! empty($raw)) {
                        return $this->normalize($raw);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('EmployeeApiService.getProfile error', [
                    'id' => $id,
                    'message' => $e->getMessage(),
                ]);
            }
            return $this->find($id);
        });
    }

    /**
     * Stream binary photo from /api/hrd/photo/{id}.
     * Returns ['content' => string, 'mime' => string] or null when missing.
     */
    public function streamPhoto(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $cacheKey = "employees:photo:{$id}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($id) {
            try {
                $response = $this->client()->get("/api/hrd/photo/{$id}");
                if (! $response->successful()) {
                    return null;
                }
                $body = $response->body();
                if ($body === '' || strlen($body) < 64) {
                    return null;
                }
                return [
                    'content' => $body,
                    'mime' => $response->header('Content-Type') ?: 'image/jpeg',
                ];
            } catch (\Throwable $e) {
                Log::warning('EmployeeApiService.streamPhoto error', [
                    'id' => $id,
                    'message' => $e->getMessage(),
                ]);
                return null;
            }
        });
    }

    /**
     * Get many employees in one call (for table rendering snapshots).
     *
     * @param  array<int,int>  $ids
     * @return array<int,array>  keyed by id
     */
    public function findMany(array $ids): array
    {
        $ids = array_unique(array_filter($ids));
        if (empty($ids)) {
            return [];
        }

        return collect($this->getByDepartment(0))
            ->whereIn('id', $ids)
            ->keyBy('id')
            ->all();
    }

    /**
     * Bust cache when external master changes (manual trigger / webhook).
     */
    public function flushCache(): void
    {
        // Simple approach: flush all dept caches we might have created.
        // Refine to tagged cache if Redis is used in production.
        for ($i = 0; $i <= 50; $i++) {
            Cache::forget("employees:dept:{$i}");
        }
    }

    protected function client(): PendingRequest
    {
        $request = Http::baseUrl($this->apiUrl)
            ->timeout($this->timeout)
            ->connectTimeout(5)
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
     * Normalize upstream shape (API HRD pakai field bahasa Indonesia) into a single contract.
     *
     * Upstream sample:
     *   { "id": 2436, "nik": "202408021", "nm_lengkap": "Muh. Alfara Zacky",
     *     "nm_divisi": "Divisi Supporting", "nm_departemen": "General Affair",
     *     "nm_jabatan": "Penjaga Alat", "status_karyawan": "Kontrak" }
     */
    protected function normalize(array $emp): array
    {
        $name     = $emp['nm_lengkap'] ?? $emp['name'] ?? $emp['full_name'] ?? '';
        $position = $emp['nm_jabatan'] ?? $emp['position'] ?? $emp['position_name'] ?? $emp['jabatan'] ?? null;
        $id       = (int) ($emp['id'] ?? $emp['employee_id'] ?? 0);
        $nik      = $emp['nik'] ?? $emp['employee_number'] ?? $emp['nip'] ?? $emp['code'] ?? null;
        $division   = $emp['nm_divisi']    ?? $emp['division']   ?? null;
        $department = $emp['nm_departemen'] ?? $emp['department'] ?? $emp['department_name'] ?? null;
        $status     = $emp['status_karyawan'] ?? $emp['employee_status'] ?? null;

        return [
            'id' => $id,
            'employee_number' => $nik,
            'name' => $name,
            'position' => $position,
            'division' => $division,
            'department' => $department,
            'department_id' => $emp['department_id'] ?? null,
            'status_karyawan' => $status,
            'email' => $emp['email'] ?? null,
            'phone' => $emp['phone'] ?? $emp['phone_number'] ?? null,
            // Display di dropdown: "Nama — Jabatan (Kontrak/Harian)"
            'text' => trim(
                $name
                . ($position ? " — {$position}" : '')
                . ($status   ? " ({$status})"   : '')
            ),
        ];
    }

    /**
     * Local fallback so UI can still develop when API_EMPLOYEE is down.
     *
     * @return array<int,array>
     */
    protected function mockData(): array
    {
        if (config('app.env') !== 'local') {
            return [];
        }

        $mock = [
            ['id' => 101, 'employee_number' => 'EMP-001', 'name' => 'Budi Santoso',  'position' => 'Operator Excavator', 'department_id' => 4, 'department' => 'Operasional'],
            ['id' => 102, 'employee_number' => 'EMP-002', 'name' => 'Andi Wijaya',   'position' => 'Operator Bulldozer', 'department_id' => 4, 'department' => 'Operasional'],
            ['id' => 103, 'employee_number' => 'EMP-003', 'name' => 'Citra Lestari', 'position' => 'Mekanik',            'department_id' => 5, 'department' => 'Workshop'],
            ['id' => 104, 'employee_number' => 'EMP-004', 'name' => 'Dewi Pratiwi',  'position' => 'Admin Lapangan',     'department_id' => 6, 'department' => 'Admin'],
            ['id' => 105, 'employee_number' => 'EMP-005', 'name' => 'Eko Saputra',   'position' => 'Foreman',            'department_id' => 4, 'department' => 'Operasional'],
        ];

        return collect($mock)->map(fn ($e) => $this->normalize($e))->values()->all();
    }
}
