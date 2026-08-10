<?php

namespace Database\Factories;

use App\Models\MapLayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MapLayer>
 */
class MapLayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'type' => fake()->randomElement(['geojson', 'tiles', 'wms']),
            'config' => ['opacity' => fake()->randomFloat(2, 0.1, 1.0)],
            'style' => ['color' => '#'.fake()->hexColor()],
            'is_active' => fake()->boolean(80),
            'is_default' => false,
            'min_year' => fake()->year(),
            'max_year' => fake()->year(),
        ];
    }
}
