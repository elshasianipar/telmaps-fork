<?php

namespace Database\Factories;

use App\Models\DeforestationRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeforestationRecord>
 */
class DeforestationRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region_id' => Region::factory(),
            'land_cover_type_id' => LandCoverType::factory(),
            'year' => fake()->year('now'),
            'change_type' => fake()->randomElement(['loss', 'gain', 'stable']),
            'area_km2' => fake()->randomFloat(2, 0.1, 9999),
            'cause' => fake()->randomElement(['Illegal logging', 'Land conversion', 'Mining', 'Fire', 'Infrastructure', null]),
            'source' => fake()->randomElement(['Landsat 8', 'Sentinel-2', 'MODIS', 'PlanetScope']),
            'geometry' => null,
            'notes' => fake()->sentence(),
        ];
    }
}
