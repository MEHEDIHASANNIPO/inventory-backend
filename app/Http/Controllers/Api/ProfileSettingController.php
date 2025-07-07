<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Enums\PasswordUpdateStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\ProfileSettingResource;
use App\Repositories\ProfileSetting\ProfileSettingInterface;

class ProfileSettingController extends Controller
{
    use ApiResponse;

    private $profileSettingRepository;

    public function __construct(ProfileSettingInterface $profileSettingRepository) {
        $this->profileSettingRepository = $profileSettingRepository;
    }

    // Porfile Info
    public function profileInfo() {
        $data = $this->profileSettingRepository->profileInfo();

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found');
        }
        return $this->ResponseSuccess(new ProfileSettingResource($data));
    }

    // Update Profile
    public function updateProfile(UpdateProfileRequest $request) {
        Gate::authorize('update-profile');

        $data = $this->profileSettingRepository->updateProfile($request);

        try {
            return $this->ResponseSuccess(new ProfileSettingResource($data), null, 'Profile Updated');
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    // Update Password
    public function updatePassword(UpdatePasswordRequest $request) {
        Gate::authorize('change-password');

        $data = $this->profileSettingRepository->updatePassword($request);

        try {
            if($data == PasswordUpdateStatus::UPDATED) {
                return $this->ResponseSuccess([], null, 'Password Updated');
            } elseif ($data == PasswordUpdateStatus::SAME_AS_OLD) {
                return $this->ResponseError([], null, "New Password Can't be same as Old Password!");
            } elseif ($data == PasswordUpdateStatus::OLD_PASSWORD_MISMATCH) {
                return $this->ResponseError([], null, "Old Password Didn't Matched!");
            }
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    // User Permissions
    public function userPermissions() {
        $data = $this->profileSettingRepository->userPermissions();

        try {
            return $this->ResponseSuccess($data, null, 'Permission Fetched');
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }
}
