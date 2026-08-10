<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('??-???')),
            'name' => fake()->city(),
            'type' => fake()->randomElement(['province', 'regency', 'district']),
            'capital' => fake()->city(),
            'area_km2' => fake()->randomFloat(2, 100, 99999),
            'population' => fake()->numberBetween(10000, 10000000),
            'latitude' => fake()->latitude(-11, 6),
            'longitude' => fake()->longitude(95, 119),
            'boundary' => null,
        ];
    }
}
