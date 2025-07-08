<?php
namespace App\Services\Cloudinary;
interface ICloudinaryService
{
  public function uploadImage($file, $folder = null);
}