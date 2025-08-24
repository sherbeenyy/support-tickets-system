<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('web')->user() ?? auth('api')->user();

        
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            abort(403, 'You must be logged in');
        }

        
        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        
        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access Forbidden'], 403);
            }
            abort(403, 'Access forbidden for your role');
        }

        return $next($request);
    }
}
