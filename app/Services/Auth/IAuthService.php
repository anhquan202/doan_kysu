<?php
namespace App\Services\Auth;
interface IAuthService
{
  /**
   * Summary of loginWithInternalAccount
   * @param mixed $credentials
   * $credentials contains username and password for internal account login
   * @return mixed
   */
  public function loginWithInternalAccount($credentials);
}