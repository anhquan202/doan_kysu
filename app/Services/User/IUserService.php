<?php
namespace App\Services\User;
interface IUserService
{
  public function getUserWithRolesAndPermissions($user_id);
}