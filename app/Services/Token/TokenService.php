<?php
namespace App\Services\Token;

use App\Helpers\TokenHelper;
use Exception;
use Illuminate\Support\Str;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Cookie;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class TokenService implements ITokenService
{
  protected $iUserService, $tokenHelper;
  public function __construct(IUserService $iUserService)
  {
    $this->iUserService = $iUserService;
  }
  public function generateToken($data)
  {
    try {
      return JWTAuth::getJWTProvider()->encode($data);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  public function decodeToken($token)
  {
    try {
      return JWTAuth::getJWTProvider()->decode($token);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  public function validateToken($token)
  {
    try {
      return JWTAuth::getJWTProvider()->validate($token);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  public function refreshToken()
  {
    try {
      $refresh_token = Cookie::get('refresh_token');
      if (!$refresh_token) {
        throw new Exception('Refresh token is invalid');
      }

      $decoded_refresh_token = $this->decodeToken($refresh_token);
      $user_id = $decoded_refresh_token['sub'];

      //craete new access token with user, roles and permissions
      $user_with_roles_permissions = $this->iUserService->getUserWithRolesAndPermissions($user_id);
      $claims_access = [
        'exp' => time() + config('jwt.ttl') * 60,
        'sub' => $user_id,
        'users' => $user_with_roles_permissions
      ];
      $new_access_token = $this->generateToken($claims_access);
      //create new refresh token
      $claims_refresh = [
        'exp' => time() + config('jwt.refresh_ttl') * 60,
        'jti' => Str::uuid(),
        'sub' => $user_id,
        'token_type' => 'refresh'
      ];
      $new_refresh_token = $this->generateToken($claims_refresh);

      return [
        'new_access_token' => $new_access_token,
        'new_refresh_token' => $new_refresh_token
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}