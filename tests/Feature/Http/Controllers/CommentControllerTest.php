<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommentController
 */
final class CommentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $comments = Comment::factory()->count(3)->create();

        $response = $this->get(route('comments.index'));

        $response->assertOk();
        $response->assertViewIs('comment.index');
        $response->assertViewHas('comments', $comments);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('comments.create'));

        $response->assertOk();
        $response->assertViewIs('comment.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentController::class,
            'store',
            \App\Http\Requests\CommentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $body = fake()->text();
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->post(route('comments.store'), [
            'body' => $body,
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        $comments = Comment::query()
            ->where('body', $body)
            ->where('user_id', $user->id)
            ->where('task_id', $task->id)
            ->get();
        $this->assertCount(1, $comments);
        $comment = $comments->first();

        $response->assertRedirect(route('comments.index'));
        $response->assertSessionHas('comment.id', $comment->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comments.show', $comment));

        $response->assertOk();
        $response->assertViewIs('comment.show');
        $response->assertViewHas('comment', $comment);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comments.edit', $comment));

        $response->assertOk();
        $response->assertViewIs('comment.edit');
        $response->assertViewHas('comment', $comment);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentController::class,
            'update',
            \App\Http\Requests\CommentUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $comment = Comment::factory()->create();
        $body = fake()->text();
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->put(route('comments.update', $comment), [
            'body' => $body,
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        $comment->refresh();

        $response->assertRedirect(route('comments.index'));
        $response->assertSessionHas('comment.id', $comment->id);

        $this->assertEquals($body, $comment->body);
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($task->id, $comment->task_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->delete(route('comments.destroy', $comment));

        $response->assertRedirect(route('comments.index'));

        $this->assertModelMissing($comment);
    }
}
