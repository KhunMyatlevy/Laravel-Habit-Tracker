<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProgressController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Registration and login routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Logout route within the authenticated group
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']); // Logout user

    Route::get('habits', [HabitController::class, 'index']); // Fetch all habits
    Route::post('habits', [HabitController::class, 'store']); // Create a new habit
    Route::get('habits/{id}', [HabitController::class, 'show']); // Fetch a specific habit
    Route::put('habits/{id}', [HabitController::class, 'update']); // Update a specific habit
    Route::delete('habits/{id}', [HabitController::class, 'destroy']); // Delete a specific habit
    
    Route::post('/habits/{id}/track', [ProgressController::class, 'track']); // Track the habit for a specific date (completed/skipped)
    Route::get('/habits/{id}/history', [ProgressController::class, 'habitHistory']);// Fetch the habit history
    Route::get('/reports/streaks/{id}', [ReportsController::class, 'streak']);// Fetch the current streak for a specific habit
    Route::get('/reports/completion', [ReportsController::class, 'completion']);// Fetch the completion summary for all habits
});

