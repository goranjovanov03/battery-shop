<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialSettings = [
            [
                'key' => 'social_facebook_url',
                'value' => '#',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Facebook page URL',
            ],
            [
                'key' => 'social_facebook_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'contact',
                'description' => 'Show Facebook icon in footer',
            ],
            [
                'key' => 'social_instagram_url',
                'value' => '#',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Instagram profile URL',
            ],
            [
                'key' => 'social_instagram_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'contact',
                'description' => 'Show Instagram icon in footer',
            ],
            [
                'key' => 'social_whatsapp_url',
                'value' => '#',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'WhatsApp contact URL (use https://wa.me/number)',
            ],
            [
                'key' => 'social_whatsapp_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'contact',
                'description' => 'Show WhatsApp icon in footer',
            ],
        ];

        foreach ($socialSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}