<?php

namespace App\Exports;

use App\Enums\Status;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksReportExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return ['Project', 'Total Tasks', 'Completed', 'Pending', 'Completion %'];
    }

    public function collection()
    {
        return Project::with('tasks')->get()->map(function (Project $project) {
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
        });
    }
}
