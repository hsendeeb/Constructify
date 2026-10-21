<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Seed the portfolio projects.
     */
    public function run(): void
    {
        $projects = [
            [
                'category' => 'Residential',
                'title' => 'Skyline Residences',
                'description' => 'A 48-unit hillside community pairing warm timber facades with resilient, low-maintenance landscaping.',
                'location' => 'Seattle, WA',
                'year' => '2025',
                'is_featured' => true,
                'sort' => 1,
            ],
            [
                'category' => 'Commercial',
                'title' => 'Northgate Business Hub',
                'description' => 'A six-storey workplace campus delivered around a live transit corridor without interrupting service.',
                'location' => 'Portland, OR',
                'year' => '2025',
                'is_featured' => true,
                'sort' => 2,
            ],
            [
                'category' => 'Infrastructure',
                'title' => 'Eastbridge Expressway',
                'description' => 'Four kilometres of upgraded arterial road, drainage, and pedestrian connections built in phased closures.',
                'location' => 'Tacoma, WA',
                'year' => '2024',
                'is_featured' => true,
                'sort' => 3,
            ],
            [
                'category' => 'Residential',
                'title' => 'Harbourview Apartments',
                'description' => 'Waterfront apartments designed for passive cooling, shared courtyards, and long-term durability.',
                'location' => 'Bellingham, WA',
                'year' => '2024',
                'is_featured' => false,
                'sort' => 4,
            ],
            [
                'category' => 'Commercial',
                'title' => 'The Vista Offices',
                'description' => 'A full interior fit-out and structural refresh for a 12,000 sq ft professional services headquarters.',
                'location' => 'Bellevue, WA',
                'year' => '2023',
                'is_featured' => false,
                'sort' => 5,
            ],
            [
                'category' => 'Infrastructure',
                'title' => 'Riverside Waterworks',
                'description' => 'A new pump station and flood-resilient embankment protecting a growing riverside district.',
                'location' => 'Everett, WA',
                'year' => '2023',
                'is_featured' => false,
                'sort' => 6,
            ],
        ];

        foreach ($projects as $project) {
            $category = ProjectCategory::query()
                ->where('slug', Str::slug($project['category']))
                ->first();

            Project::query()->updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                [
                    'project_category_id' => $category?->id,
                    'title' => $project['title'],
                    'description' => $project['description'],
                    'location' => $project['location'],
                    'year' => $project['year'],
                    'is_featured' => $project['is_featured'],
                    'sort' => $project['sort'],
                    'is_active' => true,
                ],
            );
        }
    }
}
