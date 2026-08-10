<?php

namespace Database\Factories;

use App\Models\FaqItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FaqItem>
 */
class FaqItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence().'?',
            'answer' => $this->faker->paragraph(3),
            'category' => $this->faker->optional()->word(),
            'sort_order' => $this->faker->numberBetween(0, 99),
            'is_active' => true,
        ];
    }
}
