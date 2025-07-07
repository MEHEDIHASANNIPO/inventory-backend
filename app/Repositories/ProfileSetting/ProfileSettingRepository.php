<?php

namespace App\Repositories\ProfileSetting;

use App\Service\FileUploadService;
use App\Enums\PasswordUpdateStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileSettingRepository implements ProfileSettingInterface
{
    private $filePaths = 'uploads/profile';
    /*
     * @return mixed|void
     */
    public function profileInfo() {
        $data = Auth::user();

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function updateProfile($request_data) {
        $data = Auth::user();

        $data->update([
            'name' => $request_data->name,
            'email' => $request_data->email,
            'phone' => $request_data->phone,
        ]);

        // Image Upload
        if($request_data->file != null) {
            $imagePath = (new FileUploadService())->imageUpload($request_data, $data, $this->filePaths);

            $data->update([
                'file' => $imagePath
            ]);
        }

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */
    public function updatePassword($request_data) {
        $data = Auth::user();
        $hashedPassword = $data->password;

        if(Hash::check($request_data->old_password, $hashedPassword)) {
            if(!Hash::check($request_data->password, $hashedPassword)) {
                $data->update([
                    'password' => Hash::make($request_data->password)
                ]);

                return PasswordUpdateStatus::UPDATED;
            } else {
                return PasswordUpdateStatus::SAME_AS_OLD;
            }
        } else {
            return PasswordUpdateStatus::OLD_PASSWORD_MISMATCH;
        }
    }

    /*
     * @return mixed|void
     */
    public function userPermissions() {
        $data = Auth::user();

        $permissions = $data->role->permissions->pluck('permission_slug');

        return $permissions;
    }
}
