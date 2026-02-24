<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Models\User;
use App\Notifications\TaskUpdatedNotification;
use Illuminate\Support\Collection;

class NotifyProjectMembers
{
    /**
     * Task IDs we have already sent notifications for in this request (avoids duplicate emails).
     *
     * @var array<int, true>
     */
    private static array $notifiedTaskIds = [];

    /**
     * When a task is updated: notify the project owner and the task assignee (each at most once).
     * Email is sent via the notification's toMail() channel (e.g. Mailpit in development).
     */
    public function handle(TaskUpdated $event): void
    {
        $task = $event->task;

        if (isset(self::$notifiedTaskIds[$task->id])) {
            return;
        }
        self::$notifiedTaskIds[$task->id] = true;

        $task->load(['project.owner', 'user']);

        $recipients = $this->recipientsForUpdate($task);
        $notification = new TaskUpdatedNotification($task);

        foreach ($recipients as $user) {
            $user->notify($notification);
        }
    }

    /**
     * Notify the project owner and the task assignee (per spec). Each receives at most one email.
     *
     * @return Collection<int, User>
     */
    private function recipientsForUpdate($task): Collection
    {
        $recipients = collect();

        if ($task->project->owner) {
            $recipients->push($task->project->owner);
        }

        if ($task->assigned_to && $task->user && $task->user->id !== $task->project->owner_id) {
            $recipients->push($task->user);
        }

        return $recipients->unique('id')->values();
    }
}
