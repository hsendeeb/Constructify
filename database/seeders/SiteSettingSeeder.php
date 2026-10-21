<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Seed the site-wide settings.
     */
    public function run(): void
    {
        $settings = SiteSetting::query()->firstOrCreate([]);

        $settings->update([
            'brand_name' => 'Constructify',
            'tagline' => 'Building with precision. Delivering with pride.',
            'phone' => '+1 (555) 234-6789',
            'phone_secondary' => null,
            'email' => 'hello@constructify.com',
            'address' => '1200 Harbor Avenue, Suite 400, Seattle, WA 98101',
            'working_hours' => 'Mon – Fri: 8:00 AM – 6:00 PM',
            'map_embed_url' => null,
            'footer_text' => 'Constructify is a full-service construction partner delivering residential, commercial, and infrastructure projects with uncompromising craftsmanship.',
            'copyright' => '© '.date('Y').' Constructify. All rights reserved.',
            'meta_title' => 'Constructify — Construction Portfolio',
            'meta_description' => 'Building tomorrow\'s infrastructure today. Explore Constructify\'s construction services, featured projects, and story.',
            'header_cta_text' => 'Get Estimate',
            'header_cta_url' => '/#contact',
        ]);
    }
}
