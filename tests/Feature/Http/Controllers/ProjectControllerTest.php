<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Owner;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProjectController
 */
final class ProjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $projects = Project::factory()->count(3)->create();

        $response = $this->get(route('projects.index'));

        $response->assertOk();
        $response->assertViewIs('project.index');
        $response->assertViewHas('projects', $projects);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('projects.create'));

        $response->assertOk();
        $response->assertViewIs('project.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $owner = Owner::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => $title,
            'owner_id' => $owner->id,
        ]);

        $projects = Project::query()
            ->where('title', $title)
            ->where('owner_id', $owner->id)
            ->get();
        $this->assertCount(1, $projects);
        $project = $projects->first();

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('project.id', $project->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));

        $response->assertOk();
        $response->assertViewIs('project.show');
        $response->assertViewHas('project', $project);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));

        $response->assertOk();
        $response->assertViewIs('project.edit');
        $response->assertViewHas('project', $project);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'update',
            \App\Http\Requests\ProjectUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $project = Project::factory()->create();
        $title = fake()->sentence(4);
        $owner = Owner::factory()->create();

        $response = $this->put(route('projects.update', $project), [
            'title' => $title,
            'owner_id' => $owner->id,
        ]);

        $project->refresh();

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('project.id', $project->id);

        $this->assertEquals($title, $project->title);
        $this->assertEquals($owner->id, $project->owner_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));

        $this->assertModelMissing($project);
    }
}
