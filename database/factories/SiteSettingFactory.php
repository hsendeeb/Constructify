<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_name' => 'Constructify',
            'tagline' => 'Building with precision, delivering with pride.',
            'footer_text' => 'Constructify is a full-service construction partner delivering residential, commercial, and infrastructure projects with uncompromising craftsmanship.',
            'copyright' => '© '.date('Y').' Constructify. All rights reserved.',
            'meta_title' => 'Constructify — Construction Portfolio',
            'meta_description' => 'Building tomorrow\'s infrastructure today. Explore Constructify\'s construction services, projects, and story.',
            'header_cta_text' => 'Get Estimate',
            'header_cta_url' => '/#contact',
        ];
    }
}
