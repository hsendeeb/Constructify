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
            'footer_text' => 'Constructify is a full-service construction partner delivering residential, commercial, and infrastructure projects with uncompromising craftsmanship.',
            'copyright' => '© '.date('Y').' Constructify. All rights reserved.',
            'meta_title' => 'Constructify — Construction Portfolio',
            'meta_description' => 'Building tomorrow\'s infrastructure today. Explore Constructify\'s construction services, featured projects, and story.',
            'header_cta_text' => 'Get Estimate',
            'header_cta_url' => '/#contact',
        ]);
    }
}
