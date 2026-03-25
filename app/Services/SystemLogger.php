<?php

namespace App\Services;

use App\Models\SystemLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SystemLogger
{
    public static function log(
        string $message,
        string $level = 'info',
        ?string $action = null,
        array $context = []
    ): void {
        SystemLog::create([
            'user_id' => Auth::id(),
            'level' => $level,
            'action' => $action,
            'message' => $message,
            'context' => $context,
            'ip_address' => Request::ip(),
            'url' => Request::fullUrl(),
        ]);
    }
}
