<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $projectNumber = 1;

        foreach ($users->take(5) as $user) {
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                $project = Project::create([
                    'title' => 'Project ' . $projectNumber,
                    'description' => fake()->sentences(2, true),
                    'status' => fake()->randomElement(Status::cases()),
                    'owner_id' => $user->id,
                ]);
                $project->users()->attach($user->id);
                $projectNumber++;
            }
        }
    }
}
