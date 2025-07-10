<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserStatus as UserStatusRequest;
use App\Services\User\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected $iUserService;
  public function __construct(IUserService $iUserService)
  {
    $this->iUserService = $iUserService;
  }
  public function getUserWithRolesAndPermissions($user_id)
  {
    try {
      $user = $this->iUserService->getUserWithRolesAndPermissions($user_id);
      return response()->json($user, 200);
    } catch (\Throwable $th) {
      return response()->json(['error' => 'User not found', 'error_detail' => $th->getMessage()], 404);
    }
  }

  public function getUsers()
  {
    try {
      $users = $this->iUserService->getUsers();
      return response()->json(['message' => 'Danh sách người dùng', 'users' => $users], 200);
    } catch (\Throwable $th) {
      return response()->json(['error' => $th->getMessage()]);
    }
  }

  public function getUserById(string $user_id)
  {
    try {
      $result = $this->iUserService->getUsersById($user_id);
      if ($result['status'] === 200) {
        return response()->json(['message' => 'Thông tin người dùng', 'user_info' => $result['user_info']], 200);
      } else {
        return response()->json(['error' => $result['error']], 404);
      }
    } catch (\Throwable $th) {
      return response()->json(['error' => $th->getMessage()], 500);

    }
  }

  public function create(ProfileRequest $profileRequest)
  {
    try {
      $data = $profileRequest->validated();
      $result = $this->iUserService->create($data);
      return response()->json([
        'message' => $result['message'],
        'new_user' => $result['data']
      ], 201);

    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th->getMessage()
      ], $th->getCode() ?: 500);
    }
  }

  public function updateStatus(string $user_id, UserStatusRequest $request)
  {
    try {
      $response = $request->validated();
      $update_status_result = $this->iUserService->updateStatus($user_id, $response['status']);
      if (!$update_status_result['success']) {
        return response()->json(['error' => $update_status_result['error']], 400);
      }
      return response()->json(['message' => $update_status_result['message']], 200);
    } catch (\Throwable $th) {
      return response()->json(['error' => $th->getMessage()], 500);

    }
  }
  public function test()
  {
    try {
      return response()->json('test', 200);
    } catch (\Throwable $th) {
      return response()->json($th->getMessage(), 500);

    }
  }
}
