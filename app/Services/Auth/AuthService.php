<?php
namespace App\Services\Auth;

use Illuminate\Support\Str;
use App\Models\InternalAccout;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Hash;
use App\Services\Token\ITokenService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService implements IAuthService
{
  protected $iTokenService, $iUserService;
  public function __construct(ITokenService $iTokenService, IUserService $iUserService)
  {
    $this->iTokenService = $iTokenService;
    $this->iUserService = $iUserService;
  }
  public function loginWithInternalAccount($credentials)
  {
    $user = InternalAccout::where('username', $credentials['username'])->first();

    if (!$user) {
      return [
        'status' => 404,
        'message' => 'Tài khoản không tồn tại'
      ];
    }

    $is_correct_password = Hash::check($credentials['password'], $user->password);
    if (!$is_correct_password) {
      return [
        'status' => 401,
        'message' => 'Thông tin đăng nhập không chính xác'
      ];
    }

    $user_with_roles_permissions = $this->iUserService->getUserWithRolesAndPermissions($user->user_id);
    $access_token = JWTAuth::claims(['users' => $user_with_roles_permissions])->attempt($credentials);

    $claims_refresh = [
      'exp' => time() + config('jwt.refresh_ttl') * 60,
      'jti' => Str::uuid(),
      'sub' => $user->user_id,
      'token_type' => 'refresh'
    ];
    $refresh_token = $this->iTokenService->generateToken($claims_refresh);

    if (!$access_token) {
      return [
        'status' => 500,
        'message' => 'Đã xảy ra lỗi khi tạo token truy cập!'
      ];
    }

    return [
      'status' => 200,
      'message' => 'Đăng nhập thành công!',
      'user_id' => $user->user_id,
      'access_token' => $access_token,
      'refresh_token' => $refresh_token,
    ];
  }
}