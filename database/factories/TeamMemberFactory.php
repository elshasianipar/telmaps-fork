<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role' => $this->faker->jobTitle(),
            'bio' => $this->faker->paragraph(2),
            'photo' => null,
            'sort_order' => $this->faker->numberBetween(0, 99),
            'is_active' => true,
        ];
    }
}
