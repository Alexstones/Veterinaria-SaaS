<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query()->with('user');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('species')) {
            $query->where('species', $request->species);
        }

        $pets = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('Pets/Index', [
            'pets' => $pets,
            'filters' => $request->only(['type', 'species']),
        ]);
    }

    public function show(Pet $pet)
    {
        return Inertia::render('Pets/Show', [
            'pet' => $pet->load('user'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Pets/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'species' => 'required|string',
            'name' => 'nullable|string|max:255',
            'sex' => 'nullable|string',
            'size' => 'nullable|string',
            'age' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'contact_info' => 'nullable|array',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
        }

        $pet = Pet::create(array_merge($validated, [
            'user_id' => $request->user()->id,
            'status' => 'pending', // Requerir aprobación de admin
            'image_url' => $imagePath ? '/storage/' . $imagePath : null,
        ]));

        return redirect()->route('pets.index')->with('success', 'Publicación creada y pendiente de aprobación.');
    }
}
