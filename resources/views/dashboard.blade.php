<x-app-layout>
    <x-slot name="header">
        @php
            $profileUrl  = route('profile.health.edit');
            $planUrl     = route('plan.show');
            $progressUrl = route('progress.index');
        @endphp

        {{-- نخلي الهيدر فاضي (لأن الناف بار الأساسي يجي من navigation.blade.php) --}}
    </x-slot>

    @php
        $user = auth()->user();

        // ✅ Health profile (من fitnessProfile أولاً لو موجود)
        $profile = method_exists($user, 'fitnessProfile') ? $user->fitnessProfile : null;

        $age    = $profile->age ?? $user->age ?? null;
        $height = $profile->height ?? $user->height ?? null;   // cm
        $weight = $profile->weight ?? $user->weight ?? null;   // kg

        // ✅ Plan + Meals + Workouts
        $plan = \App\Models\Plan::where('user_id', $user->id)->latest('start_date')->first();
        $meals = $plan ? \App\Models\Meal::where('plan_id', $plan->id)->get() : collect();
        $workouts = $plan ? \App\Models\Workout::where('plan_id', $plan->id)->get() : collect();

        $calTarget   = (int) ($plan->calories_target ?? 0);
        $calConsumed = (int) $meals->sum('calories');

        // ✅ Today Calories (حقيقي لو created_at موجود)
        $todayCalories = (int) $meals
            ->filter(fn($m) => optional($m->created_at)->toDateString() === now()->toDateString())
            ->sum('calories');

        // ✅ Workouts count (بدل Active Minutes)
        $workoutsCount = (int) $workouts->count();

        // ✅ Meals count (بدل Goals Met)
        $mealsCount = (int) $meals->count();

        // ✅ Plan status (بدل Day Streak)
        $planStatus = $plan ? 'Active' : 'No Plan';

        // BMI
        $bmi = null;
        if (!empty($weight) && !empty($height) && $height > 0) {
            $h = $height / 100;
            $bmi = $weight / ($h * $h);
        }

        $bmiLabel = null;
        if ($bmi !== null) {
            if ($bmi < 18.5) $bmiLabel = 'Underweight';
            elseif ($bmi < 25) $bmiLabel = 'Healthy';
            elseif ($bmi < 30) $bmiLabel = 'Overweight';
            else $bmiLabel = 'Obese';
        }

        // Weekly preview (3 عناصر)
        $weeklyItems = collect();

        foreach ($workouts as $w) {
            $weeklyItems->push([
                'title' => ($w->level ?? 'Workout') . ' Session',
                'sub'   => ($w->day ?? '—') . ' • ' . ((int)($w->duration ?? 0)) . ' MIN',
                'type'  => 'workout',
            ]);
        }

        foreach ($meals as $m) {
            $weeklyItems->push([
                'title' => ucfirst($m->meal_type ?? 'Meal') . ' Meal',
                'sub'   => ($m->day ?? '—') . ' • ' . ((int)($m->calories ?? 0)) . ' KCAL',
                'type'  => 'meal',
            ]);
        }

        $weeklyItems = $weeklyItems->take(3)->values();

        // Progress %
        $calPercent = ($calTarget > 0) ? min(100, (int) round(($calConsumed / $calTarget) * 100)) : 0;

        // placeholder weight goal
        $weightGoalTarget = null; // تقدري تربطيه لاحقاً
        $weightPercent = 75;

        $activeMin = (int) $workouts->sum('duration'); // لو موجود duration
        $weeklyActivityPercent = min(100, (int) round(($activeMin / 150) * 100));
    @endphp

    <div class="py-8 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Hero (زي ما عندك) --}}
            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-8 sm:p-10 shadow">
                <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400 opacity-10 rounded-full blur-3xl translate-x-20 -translate-y-20"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-300 opacity-10 rounded-full blur-2xl -translate-x-10 translate-y-10"></div>

                <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">
                            Welcome back, {{ $user->name }}!
                        </h1>
                        <p class="text-gray-300 text-lg">
                            Your personalized health journey awaits. Let's make today count.
                        </p>
                    </div>

                    <a href="{{ $planUrl }}"
                       class="flex items-center gap-2 px-6 py-3 font-semibold rounded-2xl transition-all hover:scale-105 whitespace-nowrap"
                       style="background-color:#F9C74F;color:#111827;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Generate / View Plan</span>
                    </a>
                </div>
            </section>

            {{-- ✅ الكاردس الأربعة (بس اللي اتغيروا) --}}
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- 1) Meals Count --}}
                <div class="stat-card bg-white rounded-3xl p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background-color: rgba(249, 199, 79, 0.2);">
                            <svg class="w-5 h-5" style="color:#F9C74F" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            Meals
                        </span>
                    </div>

                    <p class="text-3xl font-extrabold text-gray-900 mb-1">{{ $mealsCount }}</p>
                    <p class="text-sm text-gray-500">Meals in Plan</p>
                </div>

                {{-- 2) Today Calories --}}
                <div class="stat-card bg-white rounded-3xl p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-orange-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                            Today
                        </span>
                    </div>

                    <p class="text-3xl font-extrabold text-gray-900 mb-1">{{ number_format($todayCalories) }}</p>
                    <p class="text-sm text-gray-500">Today Calories</p>
                </div>

                {{-- 3) Workouts Count --}}
                <div class="stat-card bg-white rounded-3xl p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            Workouts
                        </span>
                    </div>

                    <p class="text-3xl font-extrabold text-gray-900 mb-1">{{ $workoutsCount }}</p>
                    <p class="text-sm text-gray-500">Workouts in Plan</p>
                </div>

                {{-- 4) Plan Status --}}
                <div class="stat-card bg-white rounded-3xl p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-3xl bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                            {{ $plan ? 'Active' : 'Missing' }}
                        </span>
                    </div>

                    <p class="text-3xl font-extrabold text-gray-900 mb-1">
                        {{ $plan ? '✓' : '—' }}
                    </p>
                    <p class="text-sm text-gray-500">Plan Status</p>
                </div>

            </section>

            {{-- ✅ من هنا وتحت: نفس ستايل Canva (ما تغيرش) --}}
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Health Profile --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-extrabold text-gray-900">Health Profile</h2>
                        <a href="{{ $profileUrl }}" class="p-2 rounded-xl hover:bg-gray-100 transition-colors" title="Edit">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 grid place-items-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-600">Age</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $age ? $age.' years' : '—' }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 grid place-items-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5"/>
                                    </svg>
                                </div>
                                <span class="text-gray-600">Height</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $height ? $height.' cm' : '—' }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 grid place-items-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                                    </svg>
                                </div>
                                <span class="text-gray-600">Weight</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $weight ? $weight.' kg' : '—' }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 grid place-items-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-600">BMI</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $bmi !== null ? number_format($bmi,1) : 'N/A' }}</span>
                                @if($bmiLabel)
                                    <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">
                                        {{ $bmiLabel }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Weekly Preview --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-extrabold text-gray-900">Weekly Preview</h2>
                        <a href="{{ $planUrl }}" class="text-sm font-medium hover:underline" style="color:#F9C74F;">
                            View All
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($weeklyItems as $i)
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                                            {{ $i['type']==='workout' ? 'bg-emerald-100' : '' }}"
                                     style="{{ $i['type']==='meal' ? 'background-color: rgba(249,199,79,.2);' : '' }}">
                                    @if($i['type']==='meal')
                                        <svg class="w-6 h-6" style="color:#c9a23f" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 6h16M4 12h16M4 18h7"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $i['title'] }}</h3>
                                    <p class="text-sm text-gray-500">{{ $i['sub'] }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No plan items yet. Click “Generate / View Plan”.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Track Progress --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-extrabold text-gray-900">Track Progress</h2>
                        <a href="{{ $progressUrl }}" class="p-2 rounded-xl hover:bg-gray-100 transition-colors" title="Refresh">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-6">
                        {{-- Weight Goal (placeholder) --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Weight Goal</span>
                                <span class="text-sm text-gray-500">
                                    {{ $weight ? $weight.' kg' : '—' }} / {{ $weightGoalTarget ? $weightGoalTarget.' kg' : 'goal' }}
                                </span>
                            </div>
                            <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $weightPercent }}%; background-color:#F9C74F;"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Keep tracking regularly</p>
                        </div>

                        {{-- Weekly Activity --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Weekly Activity</span>
                                <span class="text-sm text-gray-500">{{ $activeMin }} min</span>
                            </div>
                            <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $weeklyActivityPercent }}%;"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Target: 150 min/week</p>
                        </div>

                        {{-- Daily Calories --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Daily Calories</span>
                                <span class="text-sm text-gray-500">
                                    {{ number_format($calConsumed) }}{{ $calTarget ? ' / '.number_format($calTarget) : '' }}
                                </span>
                            </div>
                            <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $calPercent }}%;"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Based on your current plan</p>
                        </div>
                    </div>

                    <a href="{{ $progressUrl }}"
                       class="w-full mt-6 py-3 px-6 bg-black hover:bg-gray-800 text-white font-semibold rounded-2xl transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Update Progress
                    </a>
                </div>

            </section>

            <footer class="text-center text-sm text-gray-400 pt-6 pb-2">
                VitaPlan • Your health, your way
            </footer>
        </div>
    </div>
</x-app-layout>
