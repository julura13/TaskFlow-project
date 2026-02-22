<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'body' => fake()->text(),
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}
