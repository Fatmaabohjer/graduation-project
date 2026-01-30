<x-app-layout>
    @php
        $user = auth()->user();

        // ✅ Fallbacks لو الكنترولر ما بعثش
        $plan = $plan ?? \App\Models\Plan::where('user_id', $user->id)->latest('start_date')->first();

        $meals = $meals ?? ($plan
            ? \App\Models\Meal::where('plan_id', $plan->id)->orderBy('day')->get()
            : collect());

        $workouts = $workouts ?? ($plan
            ? \App\Models\Workout::where('plan_id', $plan->id)->orderBy('day')->get()
            : collect());

        // ✅ Health profile (هنا مخزنين الوزن والطول فعليًا)
        $profile = $user->fitnessProfile ?? null;

        // ✅ BMI (profile first, fallback user)
        $weight = $profile->weight ?? $user->weight ?? null;
        $heightCm = $profile->height ?? $user->height ?? null;

        $bmi = null;
        if (!empty($weight) && !empty($heightCm) && $heightCm > 0) {
            $h = $heightCm / 100;
            $bmi = $weight / ($h * $h);
        }

        $bmiLabel = null;
        if ($bmi !== null) {
            if ($bmi < 18.5) $bmiLabel = 'Underweight';
            elseif ($bmi < 25) $bmiLabel = 'Normal';
            elseif ($bmi < 30) $bmiLabel = 'Overweight';
            else $bmiLabel = 'Obese';
        }

        // Tabs
        $tab = request('tab', 'meals'); // meals | workouts

        // Group by day
        $mealsByDay = $meals->groupBy(fn($m) => strtoupper($m->day ?? 'DAY'));
        $workoutsByDay = $workouts->groupBy(fn($w) => strtoupper($w->day ?? 'DAY'));

        $dayOrder = ['MON'=>1,'TUE'=>2,'WED'=>3,'THU'=>4,'FRI'=>5,'SAT'=>6,'SUN'=>7,'DAY'=>99];

        $sortedMealDays = $mealsByDay->keys()->sortBy(fn($d) => $dayOrder[$d] ?? 99)->values();
        $sortedWorkoutDays = $workoutsByDay->keys()->sortBy(fn($d) => $dayOrder[$d] ?? 99)->values();

        $periodText = $plan
            ? \Carbon\Carbon::parse($plan->start_date)->format('M d') . ' - ' . \Carbon\Carbon::parse($plan->end_date)->format('M d')
            : '—';

        $calTarget = (int) ($plan->calories_target ?? 0);
        $goalType  = $plan->goal_type ?? ($profile->goal_type ?? $user->goal_type ?? '—');

        $goalNice = str_replace(['_', '-'], ' ', $goalType);
        $goalNice = ucwords($goalNice);

        // Weekly totals
        $weeklyMealCalories = (int) $meals->sum('calories');
        $weeklyWorkoutMin = (int) $workouts->sum('duration');

        // Day names
        $dayNiceMap = [
            'MON' => 'Monday',
            'TUE' => 'Tuesday',
            'WED' => 'Wednesday',
            'THU' => 'Thursday',
            'FRI' => 'Friday',
            'SAT' => 'Saturday',
            'SUN' => 'Sunday',
        ];

        // Soft day header colors (like Canva)
        $dayHeaderClass = [
            'MON' => 'bg-blue-50',
            'TUE' => 'bg-emerald-50',
            'WED' => 'bg-violet-50',
            'THU' => 'bg-pink-50',
            'FRI' => 'bg-amber-50',
            'SAT' => 'bg-cyan-50',
            'SUN' => 'bg-orange-50',
            'DAY' => 'bg-gray-50',
        ];

        // Meal badges
        $mealBadgeClass = [
            'breakfast' => 'bg-amber-100 text-amber-900',
            'lunch'     => 'bg-emerald-100 text-emerald-900',
            'dinner'    => 'bg-violet-100 text-violet-900',
            'snack'     => 'bg-sky-100 text-sky-900',
            'default'   => 'bg-gray-100 text-gray-800',
        ];

        // Workout level badges
        $levelBadgeClass = [
            'beginner'     => 'bg-emerald-100 text-emerald-900',
            'intermediate' => 'bg-amber-100 text-amber-900',
            'advanced'     => 'bg-rose-100 text-rose-900',
            'default'      => 'bg-gray-100 text-gray-800',
        ];

        // ✅ زر أسود: النص فاتح وواضح
        $btnBlack = 'inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gray-900 text-white font-semibold tracking-wide
                    hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/30';

        // ✅ أزرار ذهبية
        $btnAmber = 'inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-amber-400 text-gray-900 font-semibold
                    hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-400/40';

        // Helper: try extract category (Upper Body / Cardio …)
        $guessWorkoutCategory = function($workout) {
            return $workout->category
                ?? $workout->workout_type
                ?? $workout->type
                ?? $workout->focus
                ?? $workout->muscle_group
                ?? null;
        };
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">My Plan</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your weekly meals & workouts, generated based on your goal.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- ✅ Dashboard button removed (exists in navbar) --}}

                {{-- Generate Plan (Black) --}}
                <form method="POST" action="{{ route('plan.generate') }}">
                    @csrf
                    <button type="submit" class="{{ $btnBlack }}">
                        Generate Plan
                    </button>
                </form>

                {{-- Generate Meals --}}
                <form method="POST" action="{{ route('plan.generateMeals') }}">
                    @csrf
                    <button type="submit" class="{{ $btnAmber }}">
                        <span class="text-lg leading-none">＋</span>
                        Generate Meals
                    </button>
                </form>

                {{-- Generate Workouts --}}
                <form method="POST" action="{{ route('plan.generateWorkouts') }}">
                    @csrf
                    <button type="submit" class="{{ $btnAmber }}">
                        <span class="text-lg leading-none">＋</span>
                        Generate Workouts
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 grid place-items-center">📅</div>
                        <div class="text-sm font-semibold text-gray-600">Plan Period</div>
                    </div>
                    <div class="mt-4 text-2xl font-extrabold text-gray-900">{{ $periodText }}</div>
                </div>

                <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 grid place-items-center">🍃</div>
                        <div class="text-sm font-semibold text-gray-600">Calories Target</div>
                    </div>
                    <div class="mt-4 text-2xl font-extrabold text-gray-900">
                        {{ $calTarget ? number_format($calTarget) : '—' }}
                        <span class="text-sm font-semibold text-gray-400">kcal/day</span>
                    </div>
                </div>

                <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 grid place-items-center">🎯</div>
                        <div class="text-sm font-semibold text-gray-600">Goal</div>
                    </div>
                    <div class="mt-4 text-2xl font-extrabold text-gray-900">{{ $goalNice }}</div>
                </div>

                {{-- ✅ BMI Card (profile-based) --}}
                <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 grid place-items-center">📊</div>
                        <div class="text-sm font-semibold text-gray-600">BMI</div>
                    </div>

                    @if($bmi)
                        <div class="mt-4 flex items-end gap-2">
                            <div class="text-2xl font-extrabold text-gray-900">{{ number_format($bmi, 1) }}</div>
                            <div class="text-sm font-semibold text-emerald-600">{{ $bmiLabel }}</div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            From: {{ $heightCm }} cm • {{ $weight }} kg
                        </div>
                    @else
                        <div class="mt-4 text-2xl font-extrabold text-gray-900">—</div>
                        <div class="mt-2 text-xs text-gray-500">
                            Add height & weight in
                            <a href="{{ route('profile.health.edit') }}" class="font-semibold text-amber-700 hover:underline">
                                Health Profile
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tabs --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('plan.show', ['tab' => 'meals']) }}"
                   class="px-6 py-3 rounded-2xl font-semibold border shadow-sm
                          {{ $tab === 'meals'
                                ? 'bg-gray-900 text-white border-gray-900 tracking-wide'
                                : 'bg-white text-gray-900 border-gray-100 hover:bg-gray-50' }}">
                    🍽️ Meals
                </a>

                <a href="{{ route('plan.show', ['tab' => 'workouts']) }}"
                   class="px-6 py-3 rounded-2xl font-semibold border shadow-sm
                          {{ $tab === 'workouts'
                                ? 'bg-gray-900 text-white border-gray-900 tracking-wide'
                                : 'bg-white text-gray-900 border-gray-100 hover:bg-gray-50' }}">
                    💪 Workouts
                </a>
            </div>

            @if(!$plan)
                <div class="rounded-2xl bg-white border border-gray-100 p-8 shadow-sm">
                    <h3 class="text-xl font-extrabold text-gray-900">No plan yet</h3>
                    <p class="mt-2 text-gray-600">
                        Generate your plan first, then generate meals and workouts.
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <form method="POST" action="{{ route('plan.generate') }}">
                            @csrf
                            <button class="{{ $btnBlack }}">Generate Plan</button>
                        </form>

                        <a href="{{ route('profile.health.edit') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white border border-gray-200 text-gray-900 font-semibold hover:bg-gray-50">
                            Update Health Profile
                        </a>
                    </div>
                </div>
            @else
                {{-- MEALS --}}
                @if($tab === 'meals')
                    @if($meals->isEmpty())
                        <div class="rounded-2xl bg-white border border-gray-100 p-8 shadow-sm">
                            <p class="text-gray-700">No meals generated yet. Click <b>Generate Meals</b>.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($sortedMealDays as $day)
                                @php
                                    $dayMeals = $mealsByDay[$day];
                                    $dayTotal = (int) $dayMeals->sum('calories');
                                    $dayName = $dayNiceMap[$day] ?? $day;
                                    $headerBg = $dayHeaderClass[$day] ?? 'bg-gray-50';
                                @endphp

                                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="px-6 py-4 flex items-center justify-between {{ $headerBg }}">
                                        <div class="font-extrabold text-gray-900">{{ $dayName }}</div>
                                        <div class="text-sm font-semibold text-gray-700">{{ number_format($dayTotal) }} kcal</div>
                                    </div>

                                    <div class="p-5 space-y-4">
                                        @foreach($dayMeals as $m)
                                            @php
                                                $typeKey = strtolower($m->meal_type ?? 'default');
                                                $badgeClass = $mealBadgeClass[$typeKey] ?? $mealBadgeClass['default'];

                                                $badgeText = match($typeKey){
                                                    'breakfast' => 'Breakfast',
                                                    'lunch' => 'Lunch',
                                                    'dinner' => 'Dinner',
                                                    'snack' => 'Snack',
                                                    default => ucfirst($typeKey),
                                                };

                                                $title = $m->name ?? $m->title ?? $m->description ?? 'Meal';
                                                $cal = (int)($m->calories ?? 0);
                                            @endphp

                                            <div class="rounded-2xl border border-gray-100 bg-white p-4">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $badgeClass }}">
                                                        {{ $badgeText }}
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-600">
                                                        {{ number_format($cal) }} kcal
                                                    </span>
                                                </div>
                                                <div class="mt-3 font-extrabold text-gray-900 leading-snug">
                                                    {{ $title }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                {{-- WORKOUTS (Canva exact) --}}
                @if($tab === 'workouts')
                    @if($workouts->isEmpty())
                        <div class="rounded-2xl bg-white border border-gray-100 p-8 shadow-sm">
                            <p class="text-gray-700">No workouts generated yet. Click <b>Generate Workouts</b>.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($sortedWorkoutDays as $day)
                                @php
                                    $dayWorkouts = $workoutsByDay[$day];
                                    $dayName = $dayNiceMap[$day] ?? $day;
                                    $headerBg = $dayHeaderClass[$day] ?? 'bg-gray-50';

                                    $first = $dayWorkouts->first();
                                    $cat = $first ? $guessWorkoutCategory($first) : null;

                                    if (!$cat && $first) {
                                        $t = strtolower($first->name ?? $first->title ?? '');
                                        if (str_contains($t, 'cardio') || str_contains($t, 'hiit')) $cat = 'Cardio';
                                        elseif (str_contains($t, 'upper')) $cat = 'Upper Body';
                                        elseif (str_contains($t, 'lower')) $cat = 'Lower Body';
                                        elseif (str_contains($t, 'core') || str_contains($t, 'abs')) $cat = 'Core & Abs';
                                        elseif (str_contains($t, 'yoga') || str_contains($t, 'stretch')) $cat = 'Yoga & Stretch';
                                        else $cat = 'Workout';
                                    }
                                @endphp

                                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="px-6 py-4 flex items-center justify-between {{ $headerBg }}">
                                        <div class="font-extrabold text-gray-900">{{ $dayName }}</div>
                                        <div class="text-sm font-semibold text-gray-700">{{ $cat }}</div>
                                    </div>

                                    <div class="p-5 space-y-4">
                                        @foreach($dayWorkouts as $w)
                                            @php
                                                $title = $w->name ?? $w->title ?? (($w->level ?? 'Workout') . ' Session');
                                                $dur   = (int)($w->duration ?? 0);

                                                $levelKey = strtolower($w->level ?? 'default');
                                                $lvlClass = $levelBadgeClass[$levelKey] ?? $levelBadgeClass['default'];
                                                $lvlText  = ucfirst($levelKey);

                                                $link = $w->youtube_url ?? $w->video_url ?? $w->link ?? null;
                                            @endphp

                                            <div class="rounded-2xl border border-gray-100 bg-white p-4">
                                                <div class="flex items-start justify-between gap-3">
                                                    <div class="min-w-0">
                                                        <div class="font-extrabold text-gray-900 leading-snug">
                                                            {{ $title }}
                                                        </div>
                                                        <div class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                                            <span>⏱️ {{ $dur }} min</span>
                                                        </div>
                                                    </div>

                                                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $lvlClass }}">
                                                        {{ $lvlText }}
                                                    </span>
                                                </div>

                                                <div class="mt-4">
                                                    @if($link)
                                                        <a href="{{ $link }}" target="_blank"
                                                           class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 rounded-2xl bg-amber-400 text-gray-900 font-semibold hover:bg-amber-300">
                                                            ▶ Watch video
                                                        </a>
                                                    @else
                                                        <button type="button" disabled
                                                           class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 rounded-2xl bg-gray-100 text-gray-500 font-semibold cursor-not-allowed">
                                                            ▶ Watch video
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
