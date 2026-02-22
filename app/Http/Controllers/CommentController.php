<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreForTaskRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function storeForTask(CommentStoreForTaskRequest $request, Task $task): RedirectResponse
    {
        $task->comments()->create([
            'body' => $request->validated('body'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('tasks.show', $task)->with('status', __('Comment added.'));
    }

    public function index(Request $request): View
    {
        $comments = Comment::all();

        return view('comment.index', [
            'comments' => $comments,
        ]);
    }

    public function create(Request $request): View
    {
        return view('comment.create');
    }

    public function store(CommentStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $comment = Comment::create($data);

        return redirect()->route('tasks.show', $data['task_id'])->with('status', __('Comment added.'));
    }

    public function show(Request $request, Comment $comment): View
    {
        return view('comment.show', [
            'comment' => $comment,
        ]);
    }

    public function edit(Request $request, Comment $comment): View
    {
        return view('comment.edit', [
            'comment' => $comment,
        ]);
    }

    public function update(CommentUpdateRequest $request, Comment $comment): RedirectResponse
    {
        $comment->update($request->validated());

        $request->session()->flash('comment.id', $comment->id);

        return redirect()->route('comments.index');
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('comments.index');
    }
}
