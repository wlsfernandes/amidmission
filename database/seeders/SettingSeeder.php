<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent duplicate singleton
        if (Setting::count() > 0) {
            return;
        }

        Setting::create([
            'site_name' => 'Amid Mission',

            'image_url' => '/images/logo.png',
            'favicon_url' => '/images/favicon.ico',

            'contact_email' => 'info@amidmission.com',
            'contact_phone' => '+1 000 000 0000',
            'address' => 'Atlanta, GA',

            'footer_text' => '© ' . date('Y') . ' Amid Mission. All rights reserved.',

            'default_seo_title' => 'Amid Mission',
            'default_seo_description' => 'Empowering missions and communities globally.',
        ]);
    }
}