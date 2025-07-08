<?php
namespace App\Services\User;

use App\Models\User;

class UserService implements IUserService
{
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
}