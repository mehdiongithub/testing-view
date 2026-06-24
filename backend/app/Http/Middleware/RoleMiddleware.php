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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
 
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
 
        if (!$user->is_active) {
            return response()->json(['message' => 'Account is deactivated'], 403);
        }
 
        if (!in_array($user->role, $roles, true)) {
            return response()->json([
                'message' => 'Access denied. Required role: ' . implode(' or ', $roles),
            ], 403);
        }
 
        return $next($request);
    }

}
