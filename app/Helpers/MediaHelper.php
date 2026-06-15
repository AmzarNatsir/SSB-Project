<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class MediaHelper
{
    public static function getUserPhotoUrl(int|string|null $employeeId): ?string
    {
        if (!$employeeId) {
            return null;
        }

        return route('media.user-photo', ['employeeId' => $employeeId]);
    }
}
