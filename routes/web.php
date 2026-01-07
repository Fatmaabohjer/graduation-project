<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Breeze default profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Health Profile
    Route::get('/profile/health', [ProfileController::class, 'editHealth'])->name('profile.health.edit');
    Route::post('/profile/health', [ProfileController::class, 'updateHealth'])->name('profile.health.update');

    // Plan
    Route::get('/my-plan', [PlanController::class, 'show'])->name('plan.show');
    Route::post('/my-plan/generate', [PlanController::class, 'generate'])->name('plan.generate');
    Route::post('/my-plan/meals', [PlanController::class, 'generateMeals'])->name('plan.generateMeals');
    Route::post('/my-plan/workouts', [PlanController::class, 'generateWorkouts'])->name('plan.generateWorkouts');
});

require __DIR__.'/auth.php';
