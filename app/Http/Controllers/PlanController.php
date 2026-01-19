<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PlanGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();

        // ✅ آخر Plan مع العلاقات
        $plan = $user->plans()
            ->with(['meals', 'workouts'])
            ->latest()
            ->first();

        $meals = $plan ? $plan->meals->sortBy('day')->values() : collect();
        $workouts = $plan ? $plan->workouts->sortBy('day')->values() : collect();

        $mealsByDay = $meals->groupBy('day');
        $workoutsByDay = $workouts->groupBy('day');

        $tab = $request->query('tab', 'meals');

        return view('plan.show', compact(
            'plan', 'meals', 'workouts', 'mealsByDay', 'workoutsByDay', 'tab'
        ));
    }

    public function generate(Request $request, PlanGenerator $planGenerator): RedirectResponse
    {
        $user = $request->user();

        if (!$user->fitnessProfile) {
            return redirect()
                ->route('profile.health.edit')
                ->with('error', 'Please complete your Health Profile first.');
        }

        try {
            // ✅ توليد Plan
            $planGenerator->generateFor($user);

            // ✅ Log بعد النجاح
            app(\App\Services\ActivityLogger::class)->log(
                actorId: $user->id,
                userId: $user->id,
                action: 'generate_plan',
                description: 'Generated a new plan',
                ipAddress: $request->ip()
            );

        } catch (\RuntimeException $e) {
            // لو service يرمي HEALTH_PROFILE_MISSING (احتياط)
            if ($e->getMessage() === 'HEALTH_PROFILE_MISSING') {
                return redirect()
                    ->route('profile.health.edit')
                    ->with('error', 'Please complete your Health Profile first.');
            }

            throw $e;
        }

        return redirect()
            ->route('plan.show')
            ->with('success', 'Plan generated successfully ✅');
    }

    public function generateMeals(Request $request, PlanGenerator $planGenerator): RedirectResponse
    {
        $user = $request->user();

        $plan = Plan::where('user_id', $user->id)->latest('id')->first();
        if (!$plan) {
            return redirect()->route('plan.show')->with('error', 'Generate Plan first.');
        }

        try {
            // ✅ توليد Meals (مرة وحدة فقط)
            $planGenerator->generateMealsFor($plan);

            // ✅ Log بعد النجاح
            app(\App\Services\ActivityLogger::class)->log(
                actorId: $user->id,
                userId: $user->id,
                action: 'generate_meals',
                description: "Generated meals for plan #{$plan->id}",
                ipAddress: $request->ip()
            );

        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'NO_MEAL_TEMPLATES') {
                return redirect()
                    ->route('admin.meals.index')
                    ->with('error', 'No Meal Templates found. Add templates first.');
            }

            throw $e;
        }

        return redirect()->route('plan.show')->with('success', 'Meals generated successfully ✅');
    }

    public function generateWorkouts(Request $request, PlanGenerator $planGenerator): RedirectResponse
    {
        $user = $request->user();

        $plan = Plan::where('user_id', $user->id)->latest('id')->first();
        if (!$plan) {
            return redirect()->route('plan.show')->with('error', 'Generate Plan first.');
        }

        try {
            // ✅ توليد Workouts (مرة وحدة فقط)
            $planGenerator->generateWorkoutsFor($plan);

            // ✅ Log بعد النجاح
            app(\App\Services\ActivityLogger::class)->log(
                actorId: $user->id,
                userId: $user->id,
                action: 'generate_workouts',
                description: "Generated workouts for plan #{$plan->id}",
                ipAddress: $request->ip()
            );

        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'NO_WORKOUT_TEMPLATES') {
                return redirect()
                    ->route('admin.workouts.index')
                    ->with('error', 'No Workout Templates found. Add templates first.');
            }

            throw $e;
        }

        return redirect()->route('plan.show')->with('success', 'Workouts generated successfully ✅');
    }
}
