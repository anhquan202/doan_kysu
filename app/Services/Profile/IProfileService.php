<?php
namespace App\Services\Profile;
interface IProfileService
{
  public function me();
  public function update(array $data);

}