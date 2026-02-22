<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TaskController
 */
final class TaskControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertViewIs('task.index');
        $response->assertViewHas('tasks', $tasks);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertOk();
        $response->assertViewIs('task.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'store',
            \App\Http\Requests\TaskStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $status = fake()->word();
        $project = Project::factory()->create();
        $assigned_to = User::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'title' => $title,
            'status' => $status,
            'project_id' => $project->id,
            'assigned_to_id' => $assigned_to->id,
        ]);

        $tasks = Task::query()
            ->where('title', $title)
            ->where('status', $status)
            ->where('project_id', $project->id)
            ->where('assigned_to_id', $assigned_to->id)
            ->get();
        $this->assertCount(1, $tasks);
        $task = $tasks->first();

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('task.id', $task->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response->assertOk();
        $response->assertViewIs('task.show');
        $response->assertViewHas('task', $task);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertOk();
        $response->assertViewIs('task.edit');
        $response->assertViewHas('task', $task);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'update',
            \App\Http\Requests\TaskUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $task = Task::factory()->create();
        $title = fake()->sentence(4);
        $status = fake()->word();
        $project = Project::factory()->create();
        $assigned_to = User::factory()->create();

        $response = $this->put(route('tasks.update', $task), [
            'title' => $title,
            'status' => $status,
            'project_id' => $project->id,
            'assigned_to_id' => $assigned_to->id,
        ]);

        $task->refresh();

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('task.id', $task->id);

        $this->assertEquals($title, $task->title);
        $this->assertEquals($status, $task->status);
        $this->assertEquals($project->id, $task->project_id);
        $this->assertEquals($assigned_to->id, $task->assigned_to_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertModelMissing($task);
    }
}
