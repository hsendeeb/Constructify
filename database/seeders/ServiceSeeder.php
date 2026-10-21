<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed the service cards.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Residential Building',
                'description' => 'Custom homes and multi-family communities built around how people actually live, with healthy materials and lasting finishes.',
                'icon' => 'heroicon-o-home-modern',
                'sort' => 1,
            ],
            [
                'title' => 'Commercial Projects',
                'description' => 'Offices, retail, and hospitality spaces delivered on schedule with minimal disruption to the businesses around them.',
                'icon' => 'heroicon-o-building-office-2',
                'sort' => 2,
            ],
            [
                'title' => 'Renovation & Remodeling',
                'description' => 'Careful transformations of existing structures — from structural upgrades to complete interior fit-outs.',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'sort' => 3,
            ],
            [
                'title' => 'Road & Infrastructure',
                'description' => 'Roads, bridges, drainage, and civic works engineered for heavy use and built to serve the community for decades.',
                'icon' => 'heroicon-o-map',
                'sort' => 4,
            ],
            [
                'title' => 'Project Management',
                'description' => 'One accountable team coordinating trades, budgets, inspections, and schedules from mobilization to closeout.',
                'icon' => 'heroicon-o-clipboard-document-check',
                'sort' => 5,
            ],
            [
                'title' => 'Architecture & Design',
                'description' => 'Collaborative design support that balances bold ideas with buildability, energy performance, and real-world budgets.',
                'icon' => 'heroicon-o-pencil-square',
                'sort' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['title' => $service['title']],
                [...$service, 'is_active' => true],
            );
        }
    }
}
