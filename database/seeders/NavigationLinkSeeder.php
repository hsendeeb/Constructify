<?php

namespace Database\Seeders;

use App\Models\NavigationLink;
use Illuminate\Database\Seeder;

class NavigationLinkSeeder extends Seeder
{
    /**
     * Seed the primary navigation.
     */
    public function run(): void
    {
        $links = [
            ['label' => 'Home', 'url' => '/#home', 'sort' => 1],
            ['label' => 'About', 'url' => '/#about', 'sort' => 2],
            ['label' => 'Services', 'url' => '/#services', 'sort' => 3],
            ['label' => 'Projects', 'url' => '/#projects', 'sort' => 4],
            ['label' => 'Contact', 'url' => '/#contact', 'sort' => 5],
        ];

        foreach ($links as $link) {
            NavigationLink::query()->updateOrCreate(
                ['label' => $link['label']],
                [
                    'url' => $link['url'],
                    'target' => '_self',
                    'sort' => $link['sort'],
                    'is_active' => true,
                ],
            );
        }
    }
}
