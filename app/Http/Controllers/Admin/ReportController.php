<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'pet'])->latest()->paginate(20);

        return Inertia::render('Admin/Reports/Index', [
            'reports' => $reports,
        ]);
    }

    public function resolve(Report $report)
    {
        $report->update(['status' => 'resolved']);
        return back()->with('success', 'Reporte marcado como resuelto.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Reporte eliminado.');
    }
}
