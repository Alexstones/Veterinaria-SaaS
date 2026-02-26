<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $hasRole = $request->user() && $request->user()->role === $role;

        // Custom check for the "Special Email" requested by the user for Admin access
        $isAdminEmail = $role === 'admin' && $request->user() && $request->user()->email === 'alan@veterinaria.com';

        if (!$hasRole && !$isAdminEmail) {
            abort(403, 'Acceso denegado. Panel exclusivo para administradores autorizados.');
        }

        return $next($request);
    }
}
