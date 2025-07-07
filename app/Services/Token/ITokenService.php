<?php
namespace App\Services\Token;
interface ITokenService
{
  public function generateToken($data);
  public function decodeToken($token);
  public function validateToken($token);
  public function refreshToken();
}