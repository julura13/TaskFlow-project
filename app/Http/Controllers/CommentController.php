<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreForTaskRequest;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function storeForTask(CommentStoreForTaskRequest $request, Task $task): RedirectResponse
    {
        Gate::authorize('view', $task);

        $task->comments()->create([
            'body' => $request->validated('body'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('tasks.show', $task)->with('status', __('Comment added.'));
    }

    public function destroyFromTask(Request $request, Task $task, Comment $comment): RedirectResponse
    {
        if ($comment->task_id !== $task->id) {
            abort(404);
        }

        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('tasks.show', $task)->with('status', __('Comment deleted.'));
    }
}
