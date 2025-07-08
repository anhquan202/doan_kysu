<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = $request->bearerToken();
        if (!$access_token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        try {
            $decodedToken = JWTAuth::setToken($access_token)->getPayload();
            $user = $decodedToken->get('users');
            $request->merge([
                'auth_user_id' => $user['user_id'] ?? null,
                'auth_roles' => $user['roles'] ?? [],
                'auth_permissions' => $user['permissions'] ?? [],
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token expired' . $e->getMessage(),
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Token invalid' . $e->getMessage(),
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token error' . $e->getMessage(),
            ], 401);
        }
        return $next($request);
    }
}
