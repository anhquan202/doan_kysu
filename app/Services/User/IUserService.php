<?php
namespace App\Services\User;
interface IUserService
{
  public function getUserWithRolesAndPermissions($user_id);
  public function getUsers();
  public function getUsersById(string $user_id);
  public function create(array $data);
  public function updateStatus(string $user_id, int $status);
}