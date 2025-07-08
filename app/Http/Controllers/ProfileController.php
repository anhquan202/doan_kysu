<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\Cloudinary\ICloudinaryService;
use App\Services\Profile\IProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  protected $iProfileService, $iCloudinaryService;
  public function __construct(IProfileService $iProfileService, ICloudinaryService $iCloudinaryService)
  {
    $this->iProfileService = $iProfileService;
    $this->iCloudinaryService = $iCloudinaryService;
  }
  public function me()
  {
    try {
      $result = $this->iProfileService->me();
      if ($result) {
        return response()->json(['message' => 'Thông tin người dùng', 'user' => $result], 200);
      } else {
        return response()->json(['error' => 'Không tìm thấy thông tin'], 404);
      }
    } catch (\Throwable $th) {
      return response()->json(['error' => $th->getMessage()], 500);
    }
  }

  public function update(ProfileRequest $profileRequest)
  {
    try {
      $data = $profileRequest->validated();
      $result = $this->iProfileService->update($data);
      if ($result['status'] === 200) {
        return response()->json(['message' => $result['message']], 200);
      } else {
        return response()->json(['error' => $result['error']], 200);

      }
    } catch (\Throwable $th) {
      return response()->json(['error' => 'Đã xảy ra lỗi. ' . $th->getMessage()], 500);
    }
  }
}
