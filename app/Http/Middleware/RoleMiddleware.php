<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Try web guard first, then API guard
        $user = auth('web')->user() ?? auth('api')->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login')->with('error', 'You must be logged in');
        }

        // Get role as string for comparison
        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access Forbidden'], 403);
            }
            return redirect()->route('login')->with('error', 'Access forbidden for your role');
        }

        return $next($request);
    }
}
