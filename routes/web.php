<?php

use App\Http\Controllers\ProfileController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $projects = Project::latest()->get();
    return view('dashboard', ['projects' => $projects]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::post('tasks/{task}/comments', [App\Http\Controllers\CommentController::class, 'storeForTask'])->name('tasks.comments.store');
});

require __DIR__.'/auth.php';
