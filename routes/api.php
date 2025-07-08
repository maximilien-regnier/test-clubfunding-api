<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});

// Protected user endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Project API routes
Route::apiResource('projects', ProjectController::class);

// Get tasks for a specific project
Route::get('projects/{project}/tasks', [ProjectController::class, 'tasks']);

// Task API routes
Route::apiResource('tasks', TaskController::class);
