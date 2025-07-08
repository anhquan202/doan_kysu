<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login-with-internal-account', 'loginWithInternalAccount');
    Route::get('refresh-token', 'refreshToken');
});
Route::prefix('admin/user')->middleware(['auth.jwt.custom', 'roles:admin', 'permissions:user.read|user.create'])->controller(UserController::class)->group(function () {
    Route::get('/roles-and-permissions/{user_id}', 'getUserWithRolesAndPermissions');
    Route::get('/test', 'test');
});
Route::prefix('/profile')->middleware(['auth.jwt.custom'])->controller(ProfileController::class)->group(function () {
    Route::get('/me', 'me');
    Route::post('/update', 'update');
});