<?php
namespace App\Services\Cloudinary;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService implements ICloudinaryService
{
  public function uploadImage($file, $folder = null)
  {
    try {
      $result = Cloudinary::uploadApi()->upload($file->getRealPath(), [
        'folder' => $folder,
        'resource_type' => 'image',
        'public_id' => $file->getClientOriginalName(),
        'background_removal' => 'cloudinary_ai:fine_edges'
      ]);
      return $result['url'];
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}