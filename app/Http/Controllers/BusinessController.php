<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::query()
            ->select('businesses.*', 'plans.name as plan_name', 'plans.price as plan_price')
            ->leftJoin('subscriptions', function ($join) {
            $join->on('businesses.id', '=', 'subscriptions.business_id')
                ->where('subscriptions.status', '=', 'active')
                ->where('subscriptions.ends_at', '>', now());
        })
            ->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id');

        if ($request->has('category')) {
            $query->where('businesses.category', $request->category);
        }

        $businesses = $query
            ->where('businesses.status', 'active')
            ->orderByRaw('plans.price IS NULL ASC, plans.price DESC')
            ->latest('businesses.created_at')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Businesses/Index', [
            'businesses' => $businesses,
            'filters' => $request->only(['category']),
        ]);
    }

    public function show(Business $business)
    {
        return Inertia::render('Businesses/Show', [
            'business' => $business->load(['user', 'subscriptions.plan']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Businesses/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $business = Business::create(array_merge($validated, [
            'user_id' => $request->user()->id,
            'status' => 'pending', // Requires admin approval
            'logo' => $logoPath ? '/storage/' . $logoPath : null,
        ]));

        return redirect()->route('businesses.index')->with('success', 'Negocio registrado y pendiente de aprobación.');
    }

    public function edit(Business $business)
    {
        if ($business->user_id !== request()->user()->id) {
            abort(403);
        }
        return Inertia::render('Businesses/Edit', [
            'business' => $business,
        ]);
    }

    public function update(Request $request, Business $business)
    {
        if ($business->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'work_hours' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = '/storage/' . $request->file('logo')->store('logos', 'public');
            unset($validated['logo']);
        }

        $business->update($validated);

        return redirect()->route('businesses.show', $business)->with('success', 'Perfil de negocio actualizado.');
    }
}
