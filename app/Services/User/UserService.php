<?php
namespace App\Services\User;

use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\DB;
use App\Services\Cloudinary\ICloudinaryService;

class UserService implements IUserService
{
  protected $iCloudinaryService;
  public function __construct(ICloudinaryService $iCloudinaryService)
  {
    $this->iCloudinaryService = $iCloudinaryService;
  }
  public function getUserWithRolesAndPermissions($user_id)
  {
    try {
      $user = User::with(['roles', 'permissions'])->where('user_id', $user_id)->firstOrFail();
      $data = [
        'user_id' => $user->user_id,
        'roles' => $user->roles->pluck('role_name')->toArray(),
        'permissions' => $user->permissions->pluck('permission_name')->toArray(),
      ];
      return $data;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getUsers()
  {
    return User::get();
  }

  public function getUsersById(string $user_id)
  {
    $user = User::find($user_id);
    if ($user) {
      return [
        'status' => 200,
        'user_info' => $user
      ];
    } else {
      return [
        'status' => 404,
        'error' => 'Không tìm thấy thông tin người dùng!'
      ];
    }
  }

  public function create(array $data)
  {
    DB::beginTransaction();
    try {
      $avatar_url = $this->iCloudinaryService->uploadImage($data['avatar'], 'avatar');

      $userData = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'phone_number' => $data['phone_number'],
        'email' => $data['email'],
        'avatar' => $avatar_url,
        'address' => $data['address'],
        'gender' => $data['gender'],
        'user_status_id' => UserStatus::Active->value
      ];

      $user = User::create($userData);
      DB::commit();

      return [
        'message' => 'Tạo mới thành công!',
        'data' => $user
      ];

    } catch (\Throwable $th) {
      DB::rollBack();
      throw new \Exception('Tạo user thất bại: ' . $th->getMessage(), 500);
    }
  }

  public function updateStatus(string $user_id, int $status)
  {
    $user = User::findOrFail($user_id);
    if ($user->user_status_id === $status) {
      return [
        'success' => false,
        'error' => 'Chưa chọn trạng thái mới'
      ];
    }
    $user->update(['user_status_id' => $status]);
    return [
      'success' => true,
      'message' => 'Thay đổi tình trạng thành công'
    ];
  }
}