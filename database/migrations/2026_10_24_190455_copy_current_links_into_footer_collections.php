<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Copy the previously hard-coded footer links into editable collections.
     */
    public function up(): void
    {
        if (DB::table('footer_link_groups')->exists()) {
            return;
        }

        $now = now();

        $quickLinks = DB::table('navigation_links')
            ->where('is_active', true)
            ->orderBy('sort')
            ->get(['label', 'url', 'target'])
            ->map(fn (object $link): array => [
                'label' => $link->label,
                'url' => $link->url,
                'target' => $link->target ?: '_self',
            ])
            ->all();

        if ($quickLinks === []) {
            $quickLinks = [
                ['label' => 'Home', 'url' => '/#home', 'target' => '_self'],
                ['label' => 'About', 'url' => '/#about', 'target' => '_self'],
                ['label' => 'Services', 'url' => '/#services', 'target' => '_self'],
                ['label' => 'Projects', 'url' => '/#projects', 'target' => '_self'],
                ['label' => 'Contact', 'url' => '/#contact', 'target' => '_self'],
            ];
        }

        $serviceTitles = DB::table('services')
            ->where('is_active', true)
            ->orderBy('sort')
            ->limit(4)
            ->pluck('title')
            ->all();

        if ($serviceTitles === []) {
            $serviceTitles = [
                'Residential Building',
                'Commercial Projects',
                'Renovation & Remodeling',
                'Road & Infrastructure',
            ];
        }

        $groups = [
            ['title' => 'Quick Links', 'sort' => 1, 'links' => $quickLinks],
            [
                'title' => 'Services',
                'sort' => 2,
                'links' => array_map(fn (string $title): array => [
                    'label' => $title,
                    'url' => '/#services',
                    'target' => '_self',
                ], $serviceTitles),
            ],
        ];

        foreach ($groups as $group) {
            $groupId = DB::table('footer_link_groups')->insertGetId([
                'title' => $group['title'],
                'sort' => $group['sort'],
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $rows = [];

            foreach (array_values($group['links']) as $index => $link) {
                $rows[] = [
                    'footer_link_group_id' => $groupId,
                    'label' => $link['label'],
                    'url' => $link['url'],
                    'target' => $link['target'],
                    'sort' => $index + 1,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if ($rows !== []) {
                DB::table('footer_links')->insert($rows);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The copied links are managed from the admin panel, so they are intentionally kept.
    }
};
