<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::patch('tasks/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::patch('tasks/{task}/assignee', [App\Http\Controllers\TaskController::class, 'updateAssignee'])->name('tasks.update-assignee');
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::post('tasks/{task}/comments', [App\Http\Controllers\CommentController::class, 'storeForTask'])->name('tasks.comments.store');
    Route::delete('tasks/{task}/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroyFromTask'])->name('tasks.comments.destroy');
});

require __DIR__.'/auth.php';
