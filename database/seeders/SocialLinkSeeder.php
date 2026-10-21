<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    /**
     * Seed the footer social links.
     */
    public function run(): void
    {
        $links = [
            ['platform' => 'Facebook', 'url' => 'https://facebook.com', 'icon' => 'bi-facebook', 'sort' => 1],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com', 'icon' => 'bi-instagram', 'sort' => 2],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com', 'icon' => 'bi-linkedin', 'sort' => 3],
            ['platform' => 'X', 'url' => 'https://x.com', 'icon' => 'bi-twitter-x', 'sort' => 4],
        ];

        foreach ($links as $link) {
            SocialLink::query()->updateOrCreate(
                ['platform' => $link['platform']],
                [...$link, 'is_active' => true],
            );
        }
    }
}
