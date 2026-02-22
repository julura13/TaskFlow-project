<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->latest()->paginate(10);

        return view('project.index', [
            'projects' => $projects,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Project::class);

        return view('project.create');
    }

    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        Gate::authorize('create', Project::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']);
        if (Project::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'].'-'.Str::random(5);
        }

        $project = Project::create($data);

        return redirect()->route('projects.show', $project)->with('status', __('Project created.'));
    }

    public function show(Request $request, Project $project): View
    {
        Gate::authorize('view', $project);

        $project->load('tasks');
        $tasks = $project->tasks; // Laravel Collection
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', \App\Enums\Status::Completed)->count();
        $pendingTasks = $totalTasks - $completedTasks;
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

        return view('project.show', [
            'project' => $project,
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'completionPercentage' => $completionPercentage,
        ]);
    }

    public function edit(Request $request, Project $project): View
    {
        Gate::authorize('update', $project);

        return view('project.edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('update', $project);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        if (Project::where('slug', $data['slug'])->where('id', '!=', $project->id)->exists()) {
            $data['slug'] = $data['slug'].'-'.Str::random(5);
        }

        $project->update($data);

        return redirect()->route('projects.show', $project)->with('status', __('Project updated.'));
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('status', __('Project deleted.'));
    }
}
