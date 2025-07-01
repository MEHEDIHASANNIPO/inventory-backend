<?php

namespace App\Repositories\SystemSetting;

use App\Models\SystemSetting;

class SystemSettingRepository implements SystemSettingInterface
{
    /*
     * @return mixed|void
     */

    public function all() {
        $data = SystemSetting::firstOrFail();

        return $data;
    }

    /*
     * @return mixed|void
     */

    public function siteTimeZone() {
        $data = [];

        $data['availableTimezones']   = timezone_identifiers_list();
        $data['defaultTimezoneIndex'] = array_search(config('app.timezone'), $data['availableTimezones']);

        return $data;
    }

    /*
     * @params data
     * @return mixed|void
     */

    public function update($requested_data, $id) {
        $data = SystemSetting::findOrFail($id);

        $data->update([
            'site_name' => $requested_data->site_name,
            'site_tagline' => $requested_data->site_tagline,
            'site_email' => $requested_data->site_email,
            'site_phone' => $requested_data->site_phone,
            'site_facebook_link' => $requested_data->site_facebook_link,
            'site_address' => $requested_data->site_address,
            'meta_keywords' => $requested_data->meta_keywords,
            'meta_description' => $requested_data->meta_description,
            'meta_author' => $requested_data->meta_author,
        ]);

        $availableTimezones = timezone_identifiers_list();
        $selectedTimezone   = $availableTimezones[$requested_data->site_timezone] ?? 'UTC';

        $timezoneConfigFile = config_path('timezone.php');
        $configContent      = '<?php return "' . $selectedTimezone . '";';
        file_put_contents($timezoneConfigFile, $configContent);

        return $data;
    }
}
