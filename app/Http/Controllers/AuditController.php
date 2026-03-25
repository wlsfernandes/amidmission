<?php

namespace App\Http\Controllers;

use App\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user')
            ->latest()
            ->limit(1000) // safety limit
            ->get();

        return view('admin.audits.index', compact('audits'));
    }
}
