<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'status' => fake()->regexify('[A-Za-z0-9]{50}'),
            'project_id' => Project::factory(),
            'assigned_to' => User::factory()->create()->assigned_to,
            'assigned_to_id' => User::factory(),
        ];
    }
}
