<?php

use App\Models\SettingsModel;

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        $model = new SettingsModel();
        return $model->getValue($key);
    }
}
