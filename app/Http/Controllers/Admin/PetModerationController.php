<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PetModerationController extends Controller
{
    public function index()
    {
        $pets = Pet::with('user')->latest()->paginate(20);

        return Inertia::render('Admin/Pets/Index', [
            'pets' => $pets,
        ]);
    }

    public function approve(Pet $pet)
    {
        $pet->update(['status' => 'active']);
        return back()->with('success', 'Publicación aprobada.');
    }

    public function reject(Pet $pet, Request $request)
    {
        $pet->update(['status' => 'rejected']);
        // Here we could also log the reason in the audits table
        return back()->with('info', 'Publicación rechazada.');
    }
}
