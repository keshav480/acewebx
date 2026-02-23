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
            ['key' => 'smtp_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'smtp_port', 'value' => '587'],
            ['key' => 'smtp_username', 'value' => 'keshav.acewebx@gmail.com'],
            ['key' => 'smtp_password', 'value' => 'ngpmvshibgbucyje'],
            ['key' => 'smtp_encryption', 'value' => 'tls'],
            ['key' => 'smtp_from_address', 'value' => 'keshav.acewebx@gmail.com'],
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
