<?php

namespace Database\Factories;

use App\Models\About;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<About>
 */
class AboutFactory extends Factory
{
    public function definition(): array
    {
        return [
            'is_active' => true,
            'hero_eyebrow' => 'About TELF',
            'hero_title' => $this->faker->sentence(6),
            'hero_subtitle' => $this->faker->paragraph(2),
            'story_eyebrow' => 'Kisah kami',
            'story_title' => $this->faker->sentence(8),
            'story_body' => $this->faker->paragraph(4),
            'mission' => $this->faker->paragraph(3),
            'vision' => $this->faker->paragraph(3),
        ];
    }
}
