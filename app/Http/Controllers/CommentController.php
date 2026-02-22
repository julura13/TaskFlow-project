<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
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
        $comment = Comment::create($request->validated());

        $request->session()->flash('comment.id', $comment->id);

        return redirect()->route('comments.index');
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
