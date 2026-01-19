<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MealTemplateController;
use App\Http\Controllers\Admin\WorkoutTemplateController;
use App\Http\Controllers\ProgressController;

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

    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress', [ProgressController::class, 'store'])->name('progress.store');
    Route::delete('/progress/{entry}', [ProgressController::class, 'destroy'])->name('progress.destroy');
});
Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // ✅ Manage Users (بدون toggle-admin)
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-active', [UserManagementController::class, 'toggleActive'])->name('users.toggleActive');

        // ✅ Logs
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        Route::get('/users/{user}/logs', [LogController::class, 'userLogs'])->name('logs.user');

        // ✅ Admin Content Library
        Route::resource('meal-templates', MealTemplateController::class)->except(['show'])->names('meals');
        Route::resource('workout-templates', WorkoutTemplateController::class)->except(['show'])->names('workouts');

        Route::get('/meal-templates', [MealTemplateController::class, 'index'])->name('meals.index');
        Route::get('/meal-templates/create', [MealTemplateController::class, 'create'])->name('meals.create');
        Route::post('/meal-templates', [MealTemplateController::class, 'store'])->name('meals.store');
        Route::get('/meal-templates/{item}/edit', [MealTemplateController::class, 'edit'])->name('meals.edit');
        Route::put('/meal-templates/{item}', [MealTemplateController::class, 'update'])->name('meals.update');
        Route::delete('/meal-templates/{item}', [MealTemplateController::class, 'destroy'])->name('meals.destroy');

        Route::get('/workout-templates', [WorkoutTemplateController::class, 'index'])->name('workouts.index');
        Route::get('/workout-templates/create', [WorkoutTemplateController::class, 'create'])->name('workouts.create');
        Route::post('/workout-templates', [WorkoutTemplateController::class, 'store'])->name('workouts.store');
        Route::get('/workout-templates/{item}/edit', [WorkoutTemplateController::class, 'edit'])->name('workouts.edit');
        Route::put('/workout-templates/{item}', [WorkoutTemplateController::class, 'update'])->name('workouts.update');
        Route::delete('/workout-templates/{item}', [WorkoutTemplateController::class, 'destroy'])->name('workouts.destroy');
    });


require __DIR__.'/auth.php';
