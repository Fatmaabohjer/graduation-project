<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Meal;
use App\Models\Workout;
use App\Models\User;
use Illuminate\Support\Carbon;
use RuntimeException;

class PlanGenerator
{
    public function generateFor(User $user): Plan
    {
        $profile = $user->fitnessProfile;

        if (!$profile) {
            // خليه واضح عشان نقدر نمسكه في الكونترولر ونرجّع redirect محترم
            throw new RuntimeException('HEALTH_PROFILE_MISSING');
        }

        // مثال بسيط لحساب calories_target (ممكن تطوريه بعدين)
        $caloriesTarget = (int) ($profile->calories_target ?? 2000);

        $start = Carbon::now()->startOfDay();
        $end   = (clone $start)->addDays(6);

        // لو تبّي كل مرة plan واحد فقط: امسح آخر بلان قبل ما تنشئ جديد (اختياري)
        // Plan::where('user_id', $user->id)->delete();

        $plan = Plan::create([
            'user_id'         => $user->id,
            'calories_target' => $caloriesTarget,
            'bmi'             => $profile->bmi ?? null,
            'goal_type'       => $profile->goal_type ?? 'general',
            'start_date'      => $start->toDateString(),
            'end_date'        => $end->toDateString(),
        ]);

        return $plan;
    }

    public function generateMealsFor(Plan $plan): void
    {
        // امسح القديم لنفس البلان (باش مايصيرش تكرار)
        Meal::where('plan_id', $plan->id)->delete();

        $days = range(1, 7);

        // ديمو meals (طوريها بعدين)
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

        foreach ($days as $day) {
            $target = (int) round($plan->calories_target / 1.3); // just demo

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

        $workouts = [
            1 => [
                ['Plank (Core)', 8,  'Beginner',     'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ],
            2 => [
                ['Low Impact Cardio', 15, 'Beginner', 'https://www.youtube.com/watch?v=ml6cT4AZdqI'],
                ['Full Body Strength', 30,'Advanced', 'https://www.youtube.com/watch?v=U0bhE67HuDY'],
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
