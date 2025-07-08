<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredRoles): Response
    {
        $userRoles = $request->get('auth_roles', []);

        if (empty($userRoles)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (in_array('superadmin', $userRoles)) {
            return $next($request);
        }

        $requiredRolesArray = explode('|', $requiredRoles);
        if (!array_intersect($requiredRolesArray, $userRoles)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
