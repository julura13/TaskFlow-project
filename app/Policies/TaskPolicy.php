<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $this->canModifyTask($user, $task);
    }

    public function createTask(User $user): bool
    {
        return true;
    }

    public function updateTask(User $user, Task $task): bool
    {
        return $this->canModifyTask($user, $task);
    }

    public function deleteTask(User $user, Task $task): bool
    {
        return $this->canModifyTask($user, $task);
    }

    /**
     * Only project owner or project members (or assignee) can modify tasks.
     */
    protected function canModifyTask(User $user, Task $task): bool
    {
        $project = $task->project;

        if ($project->owner_id === $user->id) {
            return true;
        }

        if ($task->assigned_to === $user->id) {
            return true;
        }

        return $project->users()->where('user_id', $user->id)->exists();
    }
}
