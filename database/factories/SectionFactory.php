<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(2),
            'label' => fake()->words(2, true),
            'eyebrow' => fake()->words(3, true),
            'title' => fake()->sentence(4),
            'title_highlight' => null,
            'subtitle' => fake()->paragraph(),
            'image' => null,
            'background_image' => null,
            'image_caption' => null,
            'badge_text' => null,
            'badge_icon' => null,
            'primary_button_text' => null,
            'primary_button_url' => null,
            'secondary_button_text' => null,
            'secondary_button_url' => null,
            'is_active' => true,
            'sort' => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
