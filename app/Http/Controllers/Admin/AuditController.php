<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Inertia\Inertia;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user', 'auditable')
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Audits/Index', [
            'audits' => $audits,
        ]);
    }
}
