<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantSlug = $request->header('X-Tenant-Slug') ?? $request->route('tenant');

        if (!$tenantSlug) {
            // Default to Cuauhtémoc for MVP if no tenant specified
            $tenantSlug = 'cuauhtemoc';
        }

        $tenant = \App\Models\Tenant::where('slug', $tenantSlug)->first();

        if (!$tenant) {
            abort(404, 'Tenant not found.');
        }

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
