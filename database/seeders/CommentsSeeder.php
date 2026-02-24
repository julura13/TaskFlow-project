<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();
        $users = User::all();

        if ($tasks->isEmpty() || $users->isEmpty()) {
            return;
        }

        $tasksToComment = $tasks->random(min(15, $tasks->count()));

        foreach ($tasksToComment as $task) {
            $count = rand(0, 3);
            for ($i = 0; $i < $count; $i++) {
                Comment::create([
                    'body' => fake()->sentences(2, true),
                    'task_id' => $task->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
