<?php

namespace App\Console\Commands;

use App\Enums\Status;
use App\Models\Project;
use Illuminate\Console\Command;

class ReportTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a project summary table (Total Tasks, Completed, Pending, Completion %)';

    public function handle(): int
    {
        $projects = Project::with('tasks')->get();

        $rows = $projects->map(function (Project $project) {
            $tasks = $project->tasks;
            $total = $tasks->count();
            $completed = $tasks->where('status', Status::Completed)->count();
            $pending = $total - $completed;
            $percentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

            return [
                $project->title,
                $total,
                $completed,
                $pending,
                $percentage . '%',
            ];
        })->toArray();

        $this->table(
            ['Project', 'Total Tasks', 'Completed', 'Pending', 'Completion %'],
            $rows
        );

        return self::SUCCESS;
    }
}
