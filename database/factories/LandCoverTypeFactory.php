<?php

namespace Database\Factories;

use App\Models\LandCoverType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LandCoverType>
 */
class LandCoverTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('LC-?')),
                        'name' => fake()->word(),
            'color' => '#'.strtoupper(fake()->hexColor()),
            'description' => fake()->sentence(),
            'is_forest' => fake()->boolean(60),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
