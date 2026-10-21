<?php

namespace Database\Seeders;

use App\Models\Counter;
use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder
{
    /**
     * Seed the hero ribbon and about statistics.
     */
    public function run(): void
    {
        $counters = [
            ['section_key' => 'hero', 'value' => '25+', 'label' => 'Years Experience', 'icon' => 'heroicon-o-calendar-days', 'sort' => 1],
            ['section_key' => 'hero', 'value' => '850+', 'label' => 'Projects Completed', 'icon' => 'heroicon-o-building-office-2', 'sort' => 2],
            ['section_key' => 'hero', 'value' => '120+', 'label' => 'Team Experts', 'icon' => 'heroicon-o-user-group', 'sort' => 3],
            ['section_key' => 'hero', 'value' => '35+', 'label' => 'Industry Awards', 'icon' => 'heroicon-o-trophy', 'sort' => 4],
            ['section_key' => 'about', 'value' => '850+', 'label' => 'Projects Delivered', 'icon' => 'heroicon-o-building-office-2', 'sort' => 1],
            ['section_key' => 'about', 'value' => '620+', 'label' => 'Satisfied Clients', 'icon' => 'heroicon-o-face-smile', 'sort' => 2],
            ['section_key' => 'about', 'value' => '120+', 'label' => 'Skilled Workers', 'icon' => 'heroicon-o-users', 'sort' => 3],
            ['section_key' => 'about', 'value' => '35+', 'label' => 'Industry Awards', 'icon' => 'heroicon-o-trophy', 'sort' => 4],
        ];

        foreach ($counters as $counter) {
            Counter::query()->updateOrCreate(
                [
                    'section_key' => $counter['section_key'],
                    'label' => $counter['label'],
                ],
                [...$counter, 'is_active' => true],
            );
        }
    }
}
