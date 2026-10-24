<?php

namespace Database\Factories;

use App\Models\FooterLinkGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FooterLinkGroup>
 */
class FooterLinkGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
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
