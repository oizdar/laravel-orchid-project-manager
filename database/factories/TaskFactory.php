<?php

namespace Database\Factories;

use App\Enums\TaskStatusesEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(50),
            'description' => fake()->text(250),
            'start_date' => fake()->dateTimeBetween('tomorrow', '+1 month')->format('Y-m-d'),
            'end_date' => null,
            'status' => fake()->randomElement(TaskStatusesEnum::values()),
            'user_id' => User::all('id')->random()->id ?? null,
            'project_id' => Project::all('id')->random()->id,
        ];
    }


}
