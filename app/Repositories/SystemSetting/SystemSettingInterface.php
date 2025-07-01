<?php

namespace App\Repositories\SystemSetting;

interface SystemSettingInterface
{
    public function all();
    public function siteTimeZone();
    public function update($data, $id);
}
