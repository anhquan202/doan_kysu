<?php

namespace App\Http\Controllers;

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
    public function test()
    {
        return response()->json('test', 200);
    }
}
