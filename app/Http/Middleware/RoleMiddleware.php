<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        $roleList = array_values(array_filter(array_map('trim', explode('|', $roles))));

        if (empty($roleList)) {
            return $next($request);
        }

        foreach ($roleList as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have access to this resource.');
    }
}
