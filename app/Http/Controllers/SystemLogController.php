<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;

class SystemLogController extends Controller
{
    public function index()
    {
        $logs = SystemLog::orderByDesc('created_at')
            ->limit(1000) // safety limit
            ->get();

        return view('admin.system-logs.index', compact('logs'));
    }
}
