<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value'];
    protected $useTimestamps = true;

    /**
     * Get a setting value by key
     */
    public function getValue($key)
    {
        $row = $this->where('setting_key', $key)->first();
        return $row ? $row['setting_value'] : null;
    }

    /**
     * Save or update setting
     */
   // Save or update a setting
    public function saveSetting($key, $value)
    {
        $existing = $this->where('setting_key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['setting_value' => $value]);
        } else {
            return $this->insert(['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    // Optional helper to get single setting
    public function get($key)
    {
        $row = $this->where('setting_key', $key)->first();
        return $row['setting_value'] ?? null;
    }

    // Optional helper to get all as key=>value array
    public function getAll()
    {
        $all = $this->findAll();
        $settings = [];
        foreach($all as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }
}
