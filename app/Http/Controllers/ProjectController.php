<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->with('owner')->latest()->paginate(10);

        return view('project.index', [
            'projects' => $projects,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('createProject', Project::class);

        return view('project.create');
    }

    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        Gate::authorize('createProject', Project::class);

        $data = $request->validated();

        $data['owner_id'] = $request->user()->id;

        $project = Project::create($data);
        $project->users()->attach($request->user()->id);

        return redirect()->route('projects.show', $project)->with('status', __('Project created.'));
    }

    public function show(Project $project): View
    {
        Gate::authorize('view', $project);

        $project->loadMissing('owner');
        $tasks = $project->tasks()->orderByStatus()->get();
        $project->setRelation('tasks', $tasks);
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', Status::Completed)->count();
        $pendingTasks = $totalTasks - $completedTasks;
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

        $users = User::orderBy('name')->get();

        return view('project.show', [
            'project' => $project,
            'tasks' => $tasks,
            'users' => $users,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'completionPercentage' => $completionPercentage,
        ]);
    }

    public function edit(Project $project): View
    {
        Gate::authorize('updateProject', $project);

        return view('project.edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectStoreRequest $request, Project $project): RedirectResponse
    {
        Gate::authorize('updateProject', $project);

        $data = $request->validated();

        $project->update($data);

        return redirect()->route('projects.show', $project)->with('status', __('Project updated.'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('deleteProject', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('status', __('Project deleted.'));
    }
}
