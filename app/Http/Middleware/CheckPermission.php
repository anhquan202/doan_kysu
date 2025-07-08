<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredPermission): Response
    {
        $userPermissions = $request->get('auth_permissions', []);

        if (empty($userPermissions)) {
            return response()->json(['error' => 'Từ chối truy cập. Người dùng chưa được cấp quyền nào'], 401);
        }

        //pass all permissions for superadmin
        if (in_array('all', $userPermissions)) {
            return $next($request);
        }

        $requiredPermissionsArray = explode('|', $requiredPermission);
        if (!array_intersect($userPermissions, $requiredPermissionsArray)) {
            return response()->json(['error' => 'Từ chối truy cập. Bạn cần có quyền: ' . implode(', ', $requiredPermissionsArray)], 403);
        }

        return $next($request);
    }
}
