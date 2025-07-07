<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginWithInternalAccount;
use App\Services\Auth\IAuthService;
use App\Services\Token\ITokenService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $iAuthService, $iTokenService;
    public function __construct(IAuthService $iAuthService, ITokenService $iTokenService)
    {
        $this->iAuthService = $iAuthService;
        $this->iTokenService = $iTokenService;
    }
    public function loginWithInternalAccount(LoginWithInternalAccount $request)
    {
        try {
            $credentials = $request->validated();
            $result = $this->iAuthService->loginWithInternalAccount($credentials);
            if ($result['status'] === 200) {
                return response()->json([
                    'status' => $result['status'],
                    'access_token' => $result['access_token'],
                ], 200)->cookie('refresh_token', $result['refresh_token'], config('jwt.refresh_ttl') * 60, '/', null, false, true);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], $result['status']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã xảy ra lỗi không mong muốn: ' . $th->getMessage()
            ], 500);
        }
    }
    public function refreshToken()
    {
        try {
            $result = $this->iTokenService->refreshToken();
            return response()->json([
                'status' => 200,
                'access_token' => $result['new_access_token'],
            ], 200)->cookie('refresh_token', $result['new_refresh_token'], config('jwt.refresh_ttl') * 60, '/', null, false, true);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã xảy ra lỗi không mong muốn: ' . $th->getMessage()
            ], 500);
        }
    }
}
