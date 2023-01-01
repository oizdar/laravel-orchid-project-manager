<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject' => fake()->text(50),
            'description' => fake()->text(250),
            'start_date' => fake()->dateTimeBetween('tomorrow', '+1 month')->format('Y-m-d'),
            'end_date' => null
        ];
    }
}
