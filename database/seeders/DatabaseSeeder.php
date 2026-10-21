<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SiteSettingSeeder::class,
            SectionSeeder::class,
            CounterSeeder::class,
            ServiceSeeder::class,
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
            NavigationLinkSeeder::class,
            SocialLinkSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
