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

        // بسيط: calories_target
        $caloriesTarget = (int) ($profile->calories_target ?? 2000);

        $start = Carbon::now()->startOfDay();
        $end   = (clone $start)->addDays(6);

        $plan = Plan::create([
            'user_id'         => $user->id,
            'calories_target' => $caloriesTarget,
            'bmi'             => $profile->bmi ?? null,
            'goal_type'       => $profile->goal_type ?? ($profile->goal ?? 'general'), // دعم الاسمين
            'start_date'      => $start->toDateString(),
            'end_date'        => $end->toDateString(),
        ]);

        return $plan;
    }

    public function generateMealsFor(Plan $plan): void
    {
        // نمسح القديم لنفس البلان
        Meal::where('plan_id', $plan->id)->delete();

        $goal = $plan->goal_type ?? 'general';

        // ✅ نحاول نجيب templates من DB
        $templates = MealTemplate::query()
            ->where('is_active', true)
            ->where(function ($q) use ($goal) {
                $q->whereNull('goal_type')
                  ->orWhere('goal_type', $goal)
                  ->orWhere('goal_type', 'general');
            })
            ->get();

        // ✅ لو في templates: استخدمهم
        if ($templates->isNotEmpty()) {
            $byType = $templates->groupBy(fn ($t) => strtolower($t->meal_type));

            foreach (range(1, 7) as $day) {
                foreach (['breakfast', 'lunch', 'dinner'] as $type) {
                    $pool = $byType->get($type, collect());

                    // لو نوع ناقص، نعدّي (وإلا تقدري تthrow حسب رغبتك)
                    if ($pool->isEmpty()) {
                        continue;
                    }

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

            return; // ✅ مهم: ما نكملوش للديمو
        }

        // ✅ Fallback للديمو (لو مافيش templates)
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
            $b = $demo['breakfast'][($day - 1) % count($demo['breakfast'])];
            $l = $demo['lunch'][($day - 1) % count($demo['lunch'])];
            $d = $demo['dinner'][($day - 1) % count($demo['dinner'])];

            $meals = [
                ['Breakfast', $b[0], $b[1]],
                ['Lunch',     $l[0], $l[1]],
                ['Dinner',    $d[0], $d[1]],
            ];

            foreach ($meals as [$type, $name, $cal]) {
                Meal::create([
                    'plan_id'   => $plan->id,
                    'day'       => $day,
                    'meal_type' => $type,
                    'name'      => $name,
                    'calories'  => $cal,
                ]);
            }
        }
    }

    public function generateWorkoutsFor(Plan $plan): void
    {
        Workout::where('plan_id', $plan->id)->delete();

        $goal = $plan->goal_type ?? 'general';

        // ✅ نحاول نجيب templates من DB
        $templates = WorkoutTemplate::query()
            ->where('is_active', true)
            ->where(function ($q) use ($goal) {
                $q->whereNull('goal_type')
                  ->orWhere('goal_type', $goal)
                  ->orWhere('goal_type', 'general');
            })
            ->get();

        // ✅ لو في templates: اختار منها
        if ($templates->isNotEmpty()) {
            foreach (range(1, 7) as $day) {
                // تمرين واحد لكل يوم (تقدري تخليه أكثر)
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

        // ✅ Fallback للديمو (لو مافيش templates)
        $workouts = [
            1 => [
                ['Plank (Core)', 8,  'Beginner', 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ],
            2 => [
                ['Low Impact Cardio', 15, 'Beginner', 'https://www.youtube.com/watch?v=ml6cT4AZdqI'],
                ['Full Body Strength', 30, 'Advanced', 'https://www.youtube.com/watch?v=U0bhE67HuDY'],
            ],
            3 => [
                ['Core Workout', 15, 'Intermediate', 'https://www.youtube.com/watch?v=AnYl6Nk9GOA'],
            ],
            4 => [
                ['Stretching / Mobility', 10, 'Beginner', 'https://www.youtube.com/watch?v=4pKly2JojMw'],
            ],
            5 => [
                ['Plank (Core)', 8, 'Beginner', 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ],
            6 => [
                ['Plank (Core)', 8, 'Beginner', 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ],
            7 => [
                ['Plank (Core)', 8, 'Beginner', 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ],
        ];

        foreach (range(1, 7) as $day) {
            foreach ($workouts[$day] ?? [] as [$name, $minutes, $level, $url]) {
                Workout::create([
                    'plan_id'          => $plan->id,
                    'day'              => $day,
                    'name'             => $name,
                    'duration_minutes' => $minutes,
                    'level'            => $level,
                    'video_url'        => $url,
                ]);
            }
        }
    }
}
