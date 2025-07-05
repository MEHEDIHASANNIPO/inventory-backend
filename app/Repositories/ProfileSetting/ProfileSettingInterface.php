<?php

namespace App\Repositories\ProfileSetting;

interface ProfileSettingInterface
{
    public function profileInfo();
    public function updateProfile($data);
    public function updatePassword($data);
}
