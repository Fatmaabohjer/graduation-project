<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\User;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Register a user first, then rerun PlanSeeder.');
            return;
        }

        foreach ($users as $user) {

            // لا تكرر plan لنفس المستخدم
            if (Plan::where('user_id', $user->id)->exists()) {
                continue;
            }

            Plan::create([
                'user_id' => $user->id,
                'calories_target' => null,
                'bmi' => null,
                'goal_type' => null,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(6)->toDateString(), // 7 days total
            ]);
        }

        $this->command->info('PlanSeeder done ✅ Plans created for users.');
    }
}
