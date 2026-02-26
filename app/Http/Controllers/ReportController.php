<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        Report::create([
            'user_id' => $request->user()->id,
            'reportable_id' => $pet->id,
            'reportable_type' => Pet::class ,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return back()->with('success', '¡Gracias! Tu reporte ha sido enviado y será revisado por nuestro equipo.');
    }
}
