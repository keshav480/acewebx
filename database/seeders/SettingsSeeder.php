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
        // Default SMTP settings
        $settings = [
            ['key' => 'smtp_host', 'value' => 'smtp.mailtrap.io'],
            ['key' => 'smtp_port', 'value' => '587'],
            ['key' => 'smtp_username', 'value' => 'your-email@example.com'],
            ['key' => 'smtp_password', 'value' => 'your-password'],
            ['key' => 'smtp_encryption', 'value' => 'tls'],
            ['key' => 'smtp_from_address', 'value' => 'noreply@acewebx.com'],
            ['key' => 'site_name', 'value' => 'Acewebx'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
