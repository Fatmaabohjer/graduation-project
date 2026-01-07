<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\Plan;

class WorkoutSeeder extends Seeder
{
    public function run(): void
    {
        // لازم يكون عندك Plans موجودين قبل ما تزرعي Workouts
        $plans = Plan::all();

        if ($plans->isEmpty()) {
            $this->command->warn('No plans found. Run PlanSeeder first (or create a plan) then rerun WorkoutSeeder.');
            return;
        }

        // Workouts library (YouTube links)
        $library = [
            // Beginner
            ['name' => 'Push-ups (Beginner)', 'duration_minutes' => 10, 'level' => 'Beginner', 'video_url' => 'https://www.youtube.com/watch?v=IODxDxX7oi4'],
            ['name' => 'Bodyweight Squats', 'duration_minutes' => 12, 'level' => 'Beginner', 'video_url' => 'https://www.youtube.com/watch?v=aclHkVaku9U'],
            ['name' => 'Plank (Core)', 'duration_minutes' => 8, 'level' => 'Beginner', 'video_url' => 'https://www.youtube.com/watch?v=pSHjTRCQxIw'],
            ['name' => 'Glute Bridge', 'duration_minutes' => 10, 'level' => 'Beginner', 'video_url' => 'https://www.youtube.com/watch?v=wPM8icPu6H8'],
            ['name' => 'Low Impact Cardio', 'duration_minutes' => 15, 'level' => 'Beginner', 'video_url' => 'https://www.youtube.com/watch?v=ml6cT4AZdqI'],

            // Intermediate
            ['name' => 'Full Body HIIT (Intermediate)', 'duration_minutes' => 20, 'level' => 'Intermediate', 'video_url' => 'https://www.youtube.com/watch?v=ml6cT4AZdqI'],
            ['name' => 'Lunges', 'duration_minutes' => 12, 'level' => 'Intermediate', 'video_url' => 'https://www.youtube.com/watch?v=QOVaHwm-Q6U'],
            ['name' => 'Mountain Climbers', 'duration_minutes' => 10, 'level' => 'Intermediate', 'video_url' => 'https://www.youtube.com/watch?v=nmwgirgXLYM'],
            ['name' => 'Burpees (Intermediate)', 'duration_minutes' => 12, 'level' => 'Intermediate', 'video_url' => 'https://www.youtube.com/watch?v=TU8QYVW0gDU'],
            ['name' => 'Core Workout', 'duration_minutes' => 15, 'level' => 'Intermediate', 'video_url' => 'https://www.youtube.com/watch?v=AnYl6Nk9GOA'],

            // Advanced (اختياري)
            ['name' => 'Advanced HIIT', 'duration_minutes' => 25, 'level' => 'Advanced', 'video_url' => 'https://www.youtube.com/watch?v=CBWQGb4LyAM'],
            ['name' => 'Full Body Strength', 'duration_minutes' => 30, 'level' => 'Advanced', 'video_url' => 'https://www.youtube.com/watch?v=U0bhE67HuDY'],
        ];

        // نوزع تمارين على 7 أيام لكل Plan
        foreach ($plans as $plan) {
            for ($day = 1; $day <= 7; $day++) {
                // 1-2 workouts في اليوم (اختاري اللي تحبيه)
                $count = ($day % 2 === 0) ? 2 : 1;

                $picked = collect($library)->random($count);

                foreach ($picked as $w) {
                    Workout::create([
                        'plan_id' => $plan->id,
                        'day' => $day,
                        'name' => $w['name'],
                        'duration_minutes' => $w['duration_minutes'],
                        'level' => $w['level'],
                        'video_url' => $w['video_url'],
                    ]);
                }
            }
        }

        $this->command->info('WorkoutSeeder done ✅ Workouts added successfully.');
    }
}
