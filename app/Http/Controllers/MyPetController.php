<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyPetController extends Controller
{
    public function index(Request $request)
    {
        $pets = Pet::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return Inertia::render('Pets/MyPets', [
            'pets' => $pets,
        ]);
    }

    public function edit(Pet $pet, Request $request)
    {
        // Ensure user owns this pet
        abort_if($pet->user_id !== $request->user()->id, 403);

        return Inertia::render('Pets/Edit', [
            'pet' => $pet,
        ]);
    }

    public function update(Request $request, Pet $pet)
    {
        abort_if($pet->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'species' => 'required|string',
            'sex' => 'nullable|string',
            'size' => 'nullable|string',
            'age' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $pet->update($validated);

        return back()->with('success', 'Publicación actualizada.');
    }

    public function close(Pet $pet, Request $request)
    {
        abort_if($pet->user_id !== $request->user()->id, 403);
        $pet->update(['status' => 'closed']);
        return back()->with('success', 'Publicación cerrada.');
    }

    public function reopen(Pet $pet, Request $request)
    {
        abort_if($pet->user_id !== $request->user()->id, 403);
        $pet->update(['status' => 'pending']);
        return back()->with('success', 'Publicación enviada nuevamente a revisión.');
    }
}
