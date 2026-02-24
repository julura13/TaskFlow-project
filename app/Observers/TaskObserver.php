<?php

namespace App\Observers;

use App\Events\TaskUpdated;
use App\Models\Task;

class TaskObserver
{
    /**
     * Task IDs we have already dispatched TaskUpdated for in this request (avoids duplicate notifications).
     *
     * @var array<int, true>
     */
    private static array $dispatchedTaskIds = [];

    public function created(Task $task): void
    {
        $task->taskHistories()->create([
            'event_type' => 'created',
            'old_values' => null,
            'new_values' => $task->getAttributes(),
        ]);

        if ($task->assigned_to) {
            $task->project->users()->syncWithoutDetaching([$task->assigned_to]);
        }
    }

    public function updated(Task $task): void
    {
        if (! $task->wasChanged()) {
            return;
        }

        $changes = $task->getChanges();
        $oldValues = [];
        foreach (array_keys($changes) as $key) {
            $oldValues[$key] = $task->getOriginal($key);
        }

        $task->taskHistories()->create([
            'event_type' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $changes,
        ]);

        if (array_key_exists('assigned_to', $changes)) {
            $oldAssigneeId = $task->getOriginal('assigned_to');
            if ($oldAssigneeId && ! $this->userAssignedToAnyTaskInProject($oldAssigneeId, $task->project_id, $task->id)) {
                $task->project->users()->detach($oldAssigneeId);
            }
            if ($task->assigned_to) {
                $task->project->users()->syncWithoutDetaching([$task->assigned_to]);
            }
        }

        if (! isset(self::$dispatchedTaskIds[$task->id])) {
            self::$dispatchedTaskIds[$task->id] = true;
            TaskUpdated::dispatch($task);
        }
    }

    public function deleting(Task $task): void
    {
        $task->taskHistories()->create([
            'event_type' => 'deleted',
            'old_values' => $task->getRawOriginal(),
            'new_values' => null,
        ]);

        $assigneeId = $task->assigned_to;
        if ($assigneeId && ! $this->userAssignedToAnyTaskInProject($assigneeId, $task->project_id, null)) {
            $task->project->users()->detach($assigneeId);
        }
    }

    /**
     * Whether the user is assigned to any task in the project (optionally excluding one task by id).
     */
    private function userAssignedToAnyTaskInProject(int $userId, int $projectId, ?int $excludeTaskId): bool
    {
        $query = Task::where('project_id', $projectId)->where('assigned_to', $userId);
        if ($excludeTaskId !== null) {
            $query->where('id', '!=', $excludeTaskId);
        }

        return $query->exists();
    }
}
