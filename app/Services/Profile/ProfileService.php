<?php
namespace App\Services\Profile;

use App\Models\User;
use App\Services\Cloudinary\ICloudinaryService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProfileService implements IProfileService
{
  protected $iCloudinaryService;
  public function __construct(ICloudinaryService $iCloudinaryService)
  {
    $this->iCloudinaryService = $iCloudinaryService;
  }
  public function me()
  {
    $payload = JWTAuth::payload();
    $user_id = $payload->get('users')['user_id'];
    return User::findOrFail($user_id);
  }
  public function update(array $data)
  {
    try {
      $payload = JWTAuth::payload();
      $user_id = $payload->get('users')['user_id'];
      $user = User::find($user_id);
      if (!$user) {
        return ['status' => 404, 'error' => 'Không tìm thấy thông tin!'];
      }
      $avatar_url = $this->iCloudinaryService->uploadImage($data['avatar'], 'avatar');
      $data = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'phone_number' => $data['phone_number'] ?? null,
        'email' => $data['email'],
        'avatar' => $avatar_url,
        'address' => $data['address'] ?? null,
        'gender' => $data['gender'] ?? null,
      ];
      $result = $user->update($data);
      if ($result) {
        return ['status' => 200, 'message' => 'Cập nhật thông tin thành công'];
      } else {
        return ['error' => 'Cập nhật thất bại'];
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}