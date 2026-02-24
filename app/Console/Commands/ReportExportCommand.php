<?php

namespace App\Console\Commands;

use App\Exports\TasksReportExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the tasks report to Excel (storage/app/reports/)';

    public function handle(): int
    {
        $timestamp = now()->format('Y-m-d_His');
        $filename = "tasks_report_{$timestamp}.xlsx";
        $path = "reports/{$filename}";

        Storage::disk('local')->makeDirectory('reports');
        Excel::store(new TasksReportExport, $path, 'local');

        $fullPath = storage_path('app/' . $path);
        $this->info("Report exported to: {$fullPath}");

        return self::SUCCESS;
    }
}
