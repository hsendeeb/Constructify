<?php

namespace Database\Factories;

use App\Models\NavigationLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NavigationLink>
 */
class NavigationLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->word(),
            'url' => '#'.fake()->word(),
            'target' => '_self',
            'sort' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
