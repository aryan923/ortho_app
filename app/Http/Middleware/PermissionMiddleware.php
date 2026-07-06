<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        // $user = $request->user();

        // if (!$user) {
        //     abort(401, 'Unauthenticated.');
        // }

        // $permissionList = array_values(array_filter(array_map('trim', explode('|', $permissions))));

        // if (empty($permissionList)) {
        //     return $next($request);
        // }

        // $allowed = count($permissionList) === 1
        //     ? $user->hasPermission($permissionList[0])
        //     : $user->hasAnyPermission($permissionList);

        // if (!$allowed) {
        //     abort(403, 'You do not have permission to perform this action.');
        // }

        return $next($request);
    }
}
