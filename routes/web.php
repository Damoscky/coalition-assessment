<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\v1\TaskController;
use App\Http\Controllers\v1\ProjectController;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');

Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');