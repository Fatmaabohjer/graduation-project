<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Meal;
use App\Models\Workout;
use App\Services\PlanGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanController extends Controller
{
public function show(Request $request): View
{
    $user = $request->user();

    // ✅ جيبي آخر Plan للمستخدم (لأن العلاقة اسمها plans())
    $plan = $user->plans()
        ->with(['meals', 'workouts'])
        ->latest()
        ->first();

    // ✅ نخليهم Collections حتى لو مافيش plan
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

        // توليد Plan فقط (وبعدها المستخدم يقدر يولد meals/workouts بزرارهم)
        $planGenerator->generateFor($user);

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

        // مهم: هذي الدالة لازم تكون موجودة في PlanGenerator
        $planGenerator->generateMealsFor($plan);

        return redirect()->route('plan.show')->with('success', 'Meals generated successfully ✅');
    }

    public function generateWorkouts(Request $request, PlanGenerator $planGenerator): RedirectResponse
    {
        $user = $request->user();

        $plan = Plan::where('user_id', $user->id)->latest('id')->first();
        if (!$plan) {
            return redirect()->route('plan.show')->with('error', 'Generate Plan first.');
        }

        // مهم: هذي الدالة لازم تكون موجودة في PlanGenerator
        $planGenerator->generateWorkoutsFor($plan);

        return redirect()->route('plan.show')->with('success', 'Workouts generated successfully ✅');
    }
}
