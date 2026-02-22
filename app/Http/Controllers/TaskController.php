<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::whereHas('project', fn ($q) => $q->where('user_id', $request->user()->id))
            ->with('project', 'user')
            ->latest()
            ->paginate(15);

        return view('task.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create(Request $request): View
    {
        $projectId = $request->query('project_id');
        $projects = $request->user()->projects()->orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('task.create', [
            'projects' => $projects,
            'projectId' => $projectId ? (int) $projectId : null,
            'users' => $users,
        ]);
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $project = Project::findOrFail($request->validated('project_id'));
//        $this->authorize('view', $project);

        $task = Task::create($request->validated());

        return redirect()->route('tasks.show', $task)->with('status', __('Task created.'));
    }

    public function show(Request $request, Task $task): View
    {
//        $this->authorize('view', $task);

        $task->load(['project', 'user', 'comments.user']);

        return view('task.show', [
            'task' => $task,
        ]);
    }

    public function edit(Request $request, Task $task): View
    {
//        $this->authorize('update', $task);

        $projects = $request->user()->projects()->orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('task.edit', [
            'task' => $task,
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
//        $this->authorize('update', $task);

        $task->update($request->validated());

        return redirect()->route('tasks.show', $task)->with('status', __('Task updated.'));
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
//        $this->authorize('delete', $task);

        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project)->with('status', __('Task deleted.'));
    }
}
