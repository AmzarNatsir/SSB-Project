<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public function log(Model $model, string $action, ?string $userId = null, array $oldValues = [], array $newValues = [])
    {
        // If userId is not provided, try to get from auth, but be careful in jobs/commands
        $userId = $userId ?? auth()->id();

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'action' => $action,
            'user_id' => $userId,
            'old_values' => !empty($oldValues) ? $oldValues : null,
            'new_values' => !empty($newValues) ? $newValues : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
