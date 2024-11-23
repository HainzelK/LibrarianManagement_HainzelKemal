<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        // Fetch the user's roles (assuming user has 'roles' relation)
        $userRoles = auth()->user()->roles->pluck('name');
        
        // Check if the user has the required role
        if (!$userRoles->contains($role)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
