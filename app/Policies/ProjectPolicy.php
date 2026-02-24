<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return true;
    }

    public function createProject(User $user): bool
    {
        return true;
    }

    public function updateProject(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project);
    }

    public function deleteProject(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project);
    }

    /**
     * Only project members (owner or in project_user) can create tasks.
     */
    public function createTask(User $user, Project $project): bool
    {
        return $this->isOwner($user, $project) || $this->isMember($user, $project);
    }

    protected function isOwner(User $user, Project $project): bool
    {
        return $user->id === $project->owner_id;
    }

    protected function isMember(User $user, Project $project): bool
    {
        return $project->users()->where('user_id', $user->id)->exists();
    }
}
