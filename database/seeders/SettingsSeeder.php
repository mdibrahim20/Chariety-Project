<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'app_name', 'value' => config('app.name'), 'type' => 'string', 'group' => 'general'],
            ['key' => 'app_timezone', 'value' => config('app.timezone'), 'type' => 'string', 'group' => 'general'],
            ['key' => 'app_locale', 'value' => config('app.locale'), 'type' => 'string', 'group' => 'general'],
            
            // Email Settings
            ['key' => 'mail_host', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_port', 'value' => '587', 'type' => 'integer', 'group' => 'email'],
            ['key' => 'mail_username', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_password', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_encryption', 'value' => 'tls', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_from_address', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => config('app.name'), 'type' => 'string', 'group' => 'email'],
            
            // Security Settings
            ['key' => 'force_2fa_for_admins', 'value' => '0', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'password_min_length', 'value' => '8', 'type' => 'integer', 'group' => 'security'],
            ['key' => 'password_require_uppercase', 'value' => '1', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'password_require_numbers', 'value' => '1', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'password_require_special', 'value' => '0', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'session_timeout', 'value' => '120', 'type' => 'integer', 'group' => 'security'],
            
            // Appearance Settings
            ['key' => 'primary_color', 'value' => '#3B82F6', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'sidebar_collapsed_default', 'value' => '0', 'type' => 'boolean', 'group' => 'appearance'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Default settings seeded successfully!');
    }
}
