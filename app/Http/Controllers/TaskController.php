<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $tasks = Task::whereHas('project', function ($q) use ($user) {
            $q->where('owner_id', $user->id)
                ->orWhereHas('users', fn ($uq) => $uq->where('user_id', $user->id));
        })
            ->orWhere('assigned_to', $user->id)
            ->with('project', 'user')
            ->orderByStatus()
            ->latest()
            ->paginate(15);

        $users = User::orderBy('name')->get();

        return view('task.index', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }

    public function create(Request $request): View
    {
        $project = Project::findOrFail($request->project_id);
        Gate::authorize('createTask', $project);

        return view('task.create', [
            'project' => $project,
        ]);
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $project = Project::findOrFail($request->validated('project_id'));
        Gate::authorize('createTask', $project);

        $task = Task::create(array_merge($request->validated(), [
            'status' => Status::Pending->value,
            'assigned_to' => null,
        ]));

        return redirect()->route('tasks.show', $task)->with('status', __('Task created.'));
    }

    public function show(Request $request, Task $task): View
    {
        Gate::authorize('view', $task);

        $task->load(['project.owner', 'user', 'comments.user']);

        return view('task.show', [
            'task' => $task,
        ]);
    }

    public function edit(Task $task): View
    {
        Gate::authorize('updateTask', $task);

        $users = User::orderBy('name')->get();

        return view('task.edit', [
            'task' => $task,
            'users' => $users,
        ]);
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        Gate::authorize('updateTask', $task);

        $data = $request->validated();
        $data['project_id'] = $task->project_id;

        $task->update($data);

        return redirect()->route('tasks.show', $task)->with('status', __('Task updated.'));
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('updateTask', $task);

        $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', array_column(Status::cases(), 'value'))],
        ]);

        $task->update(['status' => $request->input('status')]);

        return redirect()->back()->with('status', __('Task status updated.'));
    }

    public function updateAssignee(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('updateTask', $task);

        $request->validate([
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $task->update(['assigned_to' => $request->input('assigned_to') ?: null]);

        return redirect()->back()->with('status', __('Task assignee updated.'));
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('deleteTask', $task);

        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project)->with('status', __('Task deleted.'));
    }
}
