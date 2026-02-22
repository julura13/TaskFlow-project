<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'event_type' => fake()->regexify('[A-Za-z0-9]{50}'),
            'old_values' => '{}',
            'new_values' => '{}',
        ];
    }
}
