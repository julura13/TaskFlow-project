<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = \App\Models\Task::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(1, true),
            'status' => fake()->randomElement(Status::cases()),
            'project_id' => Project::factory(),
            'assigned_to' => null,
        ];
    }
}
