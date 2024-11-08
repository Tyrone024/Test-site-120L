<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserRequestsController;

// Authentication routes
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Main application routes
Route::middleware('auth')->group(function () {
    Route::get('/main', [SpaController::class, 'index'])->name('main');
    Route::resource('/workspaces', WorkspaceController::class);
    Route::resource('/tasks', TaskController::class);
    Route::post('/chat', [ChatController::class, 'getResponse']);
    Route::post('/requests', [UserRequestsController::class, 'store'])->name('requests.store');
    Route::put('/requests/{userId}/{workspaceId}', [UserRequestsController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{userId}/{workspaceId}', [UserRequestsController::class, 'destroy'])->name('requests.delete');
});

// Fallback for unknown URLs
Route::fallback(function () {
    return auth()->check() ? redirect()->route('main') : redirect()->route('login');
});

/*
Route::get('/', function () {
    return view('welcome');
});
*/
