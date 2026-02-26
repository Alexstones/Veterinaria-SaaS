<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
        $planSlug = $request->query('plan');
        $plan = Plan::where('slug', $planSlug)->firstOrFail();

        $businesses = Business::where('user_id', $request->user()->id)->get();

        return Inertia::render('Subscriptions/Create', [
            'plan' => $plan,
            'businesses' => $businesses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);

        // Logic check: ensure user owns the business
        $business = Business::where('id', $validated['business_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        // Create subscription
        $startsAt = now();
        $endsAt = now()->addMonth();

        $subscription = Subscription::create([
            'business_id' => $validated['business_id'],
            'plan_id' => $validated['plan_id'],
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active', // For now, simulation of "paid"
        ]);

        // Simulate a Payment record
        if ($plan->price > 0) {
            Payment::create([
                'subscription_id' => $subscription->id,
                'amount' => $plan->price,
                'currency' => 'MXN',
                'provider' => 'System', // Simulated provider
                'provider_id' => 'SIM_' . uniqid(),
                'status' => 'completed',
            ]);
        }

        return redirect()->route('dashboard')->with('success', '¡Excelente! Tu plan ' . $plan->name . ' ha sido activado.');
    }
}
