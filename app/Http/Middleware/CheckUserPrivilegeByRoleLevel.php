<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPrivilegeByRoleLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     * This middleware checks if the current user has a higher privilege than the target user.
     * A lower role_level means higher privilege (e.g., 0 = superadmin).
     * Users cannot perform actions on others with equal or higher role_level, including themselves.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_user_id = $request->get('auth_user_id');
        $current_user_role_level = $this->getUserRoleLevel($current_user_id);

        $target_user_id = $request->route('user_id');
        $target_user_role_level = $this->getUserRoleLevel($target_user_id);

        if (is_null($current_user_role_level) || is_null($target_user_role_level)) {
            return response()->json(['message' => 'Không xác định được quyền truy cập'], 403);
        }

        if ($current_user_role_level === 0) {
            return $next($request);
        }

        if ($current_user_role_level >= $target_user_role_level) {
            return response()->json(['message' => 'Không có quyền thực thi thao tác'], 401);
        }

        return $next($request);
    }

    private function getUserRoleLevel(string $user_id)
    {
        $user = User::with('roles')->where('user_id', $user_id)->first();
        $user_role_level = optional($user->roles->first())->role_level;
        return $user_role_level;
    }
}
