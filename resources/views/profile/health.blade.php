{{-- resources/views/profile/health.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl leading-tight" style="color:#2B2D42;">
                    Health Profile
                </h2>
                <p class="text-sm" style="color:#2B2D42B3;">
                    VitaPlan • Plan Better. Live Healthier
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-2">
                <span class="text-sm" style="color:#2B2D42B3;">Logged in as</span>
                <span class="text-sm font-semibold" style="color:#2B2D42;">
                    {{ $user->name ?? 'User' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10" style="background:#FFFFFF;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success + BMI Result --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl"
                     style="background:#F9C74F1A; border:1px solid #F9C74F;">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold" style="color:#2B2D42;">
                                {{ session('success') }}
                            </p>

                            @if (session('bmi'))
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="p-3 rounded-lg" style="background:#FFFFFF; border:1px solid #00000012;">
                                        <p class="text-xs uppercase tracking-wide" style="color:#2B2D42B3;">BMI</p>
                                        <p class="text-lg font-semibold" style="color:#2B2D42;">{{ session('bmi') }}</p>
                                    </div>
                                    <div class="p-3 rounded-lg" style="background:#FFFFFF; border:1px solid #00000012;">
                                        <p class="text-xs uppercase tracking-wide" style="color:#2B2D42B3;">Status</p>
                                        <p class="text-lg font-semibold" style="color:#2B2D42;">{{ session('bmiCategory') }}</p>
                                    </div>
                                    <div class="p-3 rounded-lg" style="background:#FFFFFF; border:1px solid #00000012;">
                                        <p class="text-xs uppercase tracking-wide" style="color:#2B2D42B3;">Recommendation</p>
                                        <p class="text-sm" style="color:#2B2D42;">{{ session('recommendation') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="shrink-0">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full"
                                  style="background:#F9C74F; color:#2B2D42; font-weight:700;">
                                VP
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl" style="background:#00000006; border:1px solid #00000012;">
                    <p class="font-semibold mb-2" style="color:#2B2D42;">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1" style="color:#2B2D42B3;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="rounded-2xl overflow-hidden"
                 style="border:1px solid #00000012; background:#FFFFFF; box-shadow:0 10px 30px rgba(0,0,0,0.06);">

                {{-- Card Header --}}
                <div class="px-6 py-5"
                     style="background:linear-gradient(90deg, #F9C74F22, #FFFFFF); border-bottom:1px solid #00000012;">
                    <h3 class="text-lg font-semibold" style="color:#2B2D42;">Your Health Details</h3>
                    <p class="text-sm mt-1" style="color:#2B2D42B3;">
                        Fill in your data once — VitaPlan will use it to personalize your plans.
                    </p>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('profile.health.update') }}" class="px-6 py-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Age --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Age</label>
                            <input
                                type="number"
                                name="age"
                                min="1"
                                max="120"
                                value="{{ old('age', $profile->age ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 21"
                            />
                            @error('age')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Goal Type --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Goal Type</label>
                            <select
                                name="goal_type"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none; background:#FFFFFF;"
                            >
                                <option value="">Select goal</option>
                                <option value="Lose Weight"
                                    @selected(old('goal_type', $profile->goal_type ?? '') == 'Lose Weight')>
                                    Lose Weight
                                </option>
                                <option value="Gain Muscle"
                                    @selected(old('goal_type', $profile->goal_type ?? '') == 'Gain Muscle')>
                                    Gain Muscle
                                </option>
                                <option value="Maintain"
                                    @selected(old('goal_type', $profile->goal_type ?? '') == 'Maintain')>
                                    Maintain
                                </option>
                            </select>
                            @error('goal_type')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Weight --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Weight (kg)</label>
                            <input
                                type="number"
                                step="0.1"
                                name="weight"
                                min="1"
                                value="{{ old('weight', $profile->weight ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 65"
                            />
                            @error('weight')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Height --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Height (cm)</label>
                            <input
                                type="number"
                                step="0.1"
                                name="height"
                                min="50"
                                max="250"
                                value="{{ old('height', $profile->height ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 170"
                            />
                            @error('height')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Target Weight --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">
                                Target Weight (kg) <span style="color:#2B2D42B3;">(optional)</span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="target_weight"
                                min="1"
                                value="{{ old('target_weight', $profile->target_weight ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 60"
                            />
                            @error('target_weight')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Health Condition --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">
                                Health Condition <span style="color:#2B2D42B3;">(optional)</span>
                            </label>
                            <input
                                type="text"
                                name="health_condition_type"
                                value="{{ old('health_condition_type', $profile->health_condition_type ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., Diabetes, Hypertension"
                            />
                            @error('health_condition_type')
                                <p class="text-xs mt-1" style="color:#B00020;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                        <p class="text-xs" style="color:#2B2D42B3;">
                            We use this data to calculate BMI and tailor nutrition & workout plans.
                        </p>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold"
                            style="background:#3A3A3A; color:#FFFFFF;"
                            onmouseover="this.style.background='#2B2D42'"
                            onmouseout="this.style.background='#3A3A3A'"
                        >
                            Save Profile
                        </button>
                    </div>
                </form>

                {{-- Card Footer --}}
                <div class="px-6 py-4"
                     style="border-top:1px solid #00000012; background:#00000003;">
                    <p class="text-xs" style="color:#2B2D42B3;">
                        VitaPlan © {{ now()->year }} • Primary: <span style="color:#2B2D42;">#F9C74F</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
