<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Meal;
use App\Models\Workout;
use App\Models\User;
use App\Models\MealTemplate;
use App\Models\WorkoutTemplate;
use Illuminate\Support\Carbon;
use RuntimeException;

class PlanGenerator
{
    public function generateFor(User $user): Plan
    {
        $profile = $user->fitnessProfile;

        if (!$profile) {
            throw new RuntimeException('HEALTH_PROFILE_MISSING');
        }

        $caloriesTarget = (int) ($profile->calories_target ?? 2000);

        $start = Carbon::now()->startOfDay();
        $end   = (clone $start)->addDays(6);

        return Plan::create([
            'user_id'         => $user->id,
            'calories_target' => $caloriesTarget,
            'bmi'             => $profile->bmi ?? null,
            'goal_type'       => $profile->goal_type ?? ($profile->goal ?? 'general'),
            'start_date'      => $start->toDateString(),
            'end_date'        => $end->toDateString(),
        ]);
    }

    public function generateMealsFor(Plan $plan): void
    {
        Meal::where('plan_id', $plan->id)->delete();

        $user = $plan->user;
        $profile = $user?->fitnessProfile;

        $goal = $plan->goal_type ?? 'general';

        $dietary = $profile?->dietary_condition;
        $dietary = is_string($dietary) ? strtolower(trim($dietary)) : null;
        if ($dietary === '' || $dietary === 'none') $dietary = null;

        // base: goal + active
        $base = MealTemplate::query()
            ->where('is_active', true)
            ->where(function ($q) use ($goal) {
                $q->whereNull('goal_type')
                  ->orWhere('goal_type', $goal)
                  ->orWhere('goal_type', 'general');
            });

        $mealTypes = ['breakfast', 'lunch', 'dinner'];

        // ✅ لكل meal_type بروحه: specific إذا موجود، وإلا general
        $pools = [];
        foreach ($mealTypes as $type) {
            $typeCap = ucfirst($type);

            if ($dietary) {
                $specific = (clone $base)
                    ->where('meal_type', $typeCap)
                    ->where('dietary_condition', $dietary)
                    ->get();

                if ($specific->isNotEmpty()) {
                    $pools[$type] = $specific;
                    continue;
                }
            }

            $fallback = (clone $base)
                ->where('meal_type', $typeCap)
                ->where(function ($q) {
                    $q->whereNull('dietary_condition')
                      ->orWhere('dietary_condition', 'none');
                })
                ->get();

            $pools[$type] = $fallback;
        }

        // ✅ لو كلهم فاضيين، fallback demo
        $anyTemplates = collect($pools)->flatten(1);
        if ($anyTemplates->isEmpty()) {
            $demo = [
                'breakfast' => [
                    ['Oatmeal + Banana', 400],
                    ['Eggs + Toast', 450],
                    ['Yogurt + Granola', 380],
                ],
                'lunch' => [
                    ['Tuna Sandwich', 520],
                    ['Chicken Salad', 500],
                    ['Rice + Beans', 550],
                ],
                'dinner' => [
                    ['Pasta (Light)', 620],
                    ['Soup + Bread', 500],
                    ['Grilled Fish + Veggies', 560],
                ],
            ];

            foreach (range(1, 7) as $day) {
                foreach ($mealTypes as $type) {
                    $arr = $demo[$type];
                    $picked = $arr[($day - 1) % count($arr)];

                    Meal::create([
                        'plan_id'   => $plan->id,
                        'day'       => $day,
                        'meal_type' => ucfirst($type),
                        'name'      => $picked[0],
                        'calories'  => (int) $picked[1],
                    ]);
                }
            }
            return;
        }

        foreach (range(1, 7) as $day) {
            foreach ($mealTypes as $type) {
                $pool = $pools[$type] ?? collect();
                if ($pool->isEmpty()) continue;

                $picked = $pool->random();

                Meal::create([
                    'plan_id'   => $plan->id,
                    'day'       => $day,
                    'meal_type' => ucfirst($type),
                    'name'      => $picked->name,
                    'calories'  => (int) $picked->calories,
                ]);
            }
        }
    }

    public function generateWorkoutsFor(Plan $plan): void
    {
        Workout::where('plan_id', $plan->id)->delete();

        $user = $plan->user;
        $profile = $user?->fitnessProfile;

        $goal = $plan->goal_type ?? 'general';

        $health = $profile?->health_condition_type;
        $health = is_string($health) ? strtolower(trim($health)) : null;
        if ($health === '' || $health === 'none') $health = null;

        $base = WorkoutTemplate::query()
            ->where('is_active', true)
            ->where(function ($q) use ($goal) {
                $q->whereNull('goal_type')
                  ->orWhere('goal_type', $goal)
                  ->orWhere('goal_type', 'general');
            });

        if ($health) {
            $specific = (clone $base)
                ->where('health_condition_type', $health)
                ->get();

            $templates = $specific->isNotEmpty()
                ? $specific
                : (clone $base)->where(function ($q) {
                    $q->whereNull('health_condition_type')
                      ->orWhere('health_condition_type', 'none');
                })->get();
        } else {
            $templates = (clone $base)->where(function ($q) {
                $q->whereNull('health_condition_type')
                  ->orWhere('health_condition_type', 'none');
            })->get();
        }

        if ($templates->isNotEmpty()) {
            foreach (range(1, 7) as $day) {
                $picked = $templates->random();
                Workout::create([
                    'plan_id'          => $plan->id,
                    'day'              => $day,
                    'name'             => $picked->name,
                    'duration_minutes' => $picked->duration_minutes,
                    'level'            => $picked->level,
                    'video_url'        => $picked->video_url,
                ]);
            }
            return;
        }

        // fallback demo
        $demo = [
            ['Plank (Core)', 8, 'Beginner', 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ['Low Impact Cardio', 15, 'Beginner', 'https://www.youtube.com/watch?v=ml6cT4AZdqI'],
            ['Stretching / Mobility', 10, 'Beginner', 'https://www.youtube.com/watch?v=4pKly2JojMw'],
        ];

        foreach (range(1, 7) as $day) {
            $picked = $demo[($day - 1) % count($demo)];
            Workout::create([
                'plan_id'          => $plan->id,
                'day'              => $day,
                'name'             => $picked[0],
                'duration_minutes' => $picked[1],
                'level'            => $picked[2],
                'video_url'        => $picked[3],
            ]);
        }
    }
}
