<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::with('owner')->get();
        $users = User::all();

        if ($projects->isEmpty() || $users->isEmpty()) {
            return;
        }

        $taskNumber = 1;

        foreach ($projects as $project) {
            $count = rand(2, 8);
            for ($i = 0; $i < $count; $i++) {
                $assignedTo = rand(0, 3) === 0 ? null : $users->random()->id;
                $task = Task::create([
                    'title' => 'Task ' . $taskNumber,
                    'description' => fake()->sentences(2, true),
                    'status' => fake()->randomElement(Status::cases()),
                    'project_id' => $project->id,
                    'assigned_to' => $assignedTo,
                ]);
                if ($assignedTo) {
                    $project->users()->syncWithoutDetaching([$assignedTo]);
                }
                $taskNumber++;
            }
        }
    }
}
