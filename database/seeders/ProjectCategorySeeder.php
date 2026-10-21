<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Seed the project filter categories.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Residential', 'sort' => 1],
            ['name' => 'Commercial', 'sort' => 2],
            ['name' => 'Infrastructure', 'sort' => 3],
        ];

        foreach ($categories as $category) {
            ProjectCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'sort' => $category['sort'],
                    'is_active' => true,
                ],
            );
        }
    }
}
