<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessModerationController extends Controller
{
    public function index()
    {
        $businesses = Business::with('user')->latest()->paginate(20);

        return Inertia::render('Admin/Businesses/Index', [
            'businesses' => $businesses,
        ]);
    }

    public function approve(Business $business)
    {
        $business->update(['status' => 'active']);
        return back()->with('success', 'Negocio aprobado y activo en el directorio.');
    }

    public function reject(Business $business, Request $request)
    {
        $business->update(['status' => 'rejected']);
        return back()->with('info', 'Negocio rechazado.');
    }
}
