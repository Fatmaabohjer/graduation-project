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

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl"
                     style="background:#F9C74F1A; border:1px solid #F9C74F;">
                    <p class="font-semibold" style="color:#2B2D42;">{{ session('success') }}</p>
                </div>
            @endif

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

            <div class="rounded-2xl overflow-hidden"
                 style="border:1px solid #00000012; background:#FFFFFF; box-shadow:0 10px 30px rgba(0,0,0,0.06);">

                <div class="px-6 py-5"
                     style="background:linear-gradient(90deg, #F9C74F22, #FFFFFF); border-bottom:1px solid #00000012;">
                    <h3 class="text-lg font-semibold" style="color:#2B2D42;">Your Health Details</h3>
                    <p class="text-sm mt-1" style="color:#2B2D42B3;">
                        Fill in your data — VitaPlan uses it to personalize meals & workouts.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.health.update') }}" class="px-6 py-6">
                    @csrf

                    @php
                        $diet = old('dietary_condition', $profile->dietary_condition ?? 'none');
                        $injury = old('health_condition_type', $profile->health_condition_type ?? 'none');
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Age</label>
                            <input type="number" name="age" min="1" max="120"
                                value="{{ old('age', $profile->age ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 21" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Goal Type</label>
                            <select name="goal_type" class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none; background:#FFFFFF;">
                                <option value="">Select goal</option>
                                <option value="Lose Weight" @selected(old('goal_type', $profile->goal_type ?? '') == 'Lose Weight')>Lose Weight</option>
                                <option value="Gain Muscle" @selected(old('goal_type', $profile->goal_type ?? '') == 'Gain Muscle')>Gain Muscle</option>
                                <option value="Maintain" @selected(old('goal_type', $profile->goal_type ?? '') == 'Maintain')>Maintain</option>
                                <option value="general" @selected(old('goal_type', $profile->goal_type ?? '') == 'general')>general</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" min="1"
                                value="{{ old('weight', $profile->weight ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 65" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">Height (cm)</label>
                            <input type="number" step="0.1" name="height" min="50" max="250"
                                value="{{ old('height', $profile->height ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 170" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">
                                Target Weight (kg) <span style="color:#2B2D42B3;">(optional)</span>
                            </label>
                            <input type="number" step="0.1" name="target_weight" min="1"
                                value="{{ old('target_weight', $profile->target_weight ?? '') }}"
                                class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none;"
                                placeholder="e.g., 60" />
                        </div>

                        {{-- ✅ Dietary condition (MEALS) --}}
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">
                                Dietary Condition (Meals)
                            </label>
                            <select name="dietary_condition" class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none; background:#FFFFFF;">
                                <option value="none" @selected($diet === 'none' || $diet === '' || $diet === null)>None</option>
                                <option value="diabetes" @selected($diet === 'diabetes')>Diabetes-friendly</option>
                                <option value="gluten_free" @selected($diet === 'gluten_free')>Gluten-Free</option>
                                <option value="lactose_free" @selected($diet === 'lactose_free')>Lactose-Free</option>
                                <option value="low_salt" @selected($diet === 'low_salt')>Low-Salt</option>
                                <option value="high_protein" @selected($diet === 'high_protein')>High-Protein</option>
                            </select>
                        </div>

                        {{-- ✅ Health condition (WORKOUTS) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1" style="color:#2B2D42;">
                                Health Condition / Injury (Workouts)
                            </label>
                            <select name="health_condition_type" class="w-full rounded-xl px-4 py-3"
                                style="border:1px solid #00000020; outline:none; background:#FFFFFF;">
                                <option value="none" @selected($injury === 'none' || $injury === '' || $injury === null)>None</option>
                                <option value="back_pain" @selected($injury === 'back_pain')>Back pain</option>
                                <option value="knee_pain" @selected($injury === 'knee_pain')>Knee pain</option>
                                <option value="shoulder_pain" @selected($injury === 'shoulder_pain')>Shoulder pain</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                        <p class="text-xs" style="color:#2B2D42B3;">
                            
                        </p>

                        <button type="submit"
                            class="px-6 py-3 rounded-2xl font-semibold text-gray-900 shadow-sm
                                           transition-all duration-200 transform hover:-translate-y-1 hover:shadow-md
                                           focus:outline-none focus:ring-2 focus:ring-offset-2"
                                    style="background-color: var(--vp-accent);">
                            Save Profile

                        </button>
                    </div>
                </form>

                <div class="px-6 py-4"
                     style="border-top:1px solid #00000012; background:#00000003;">
                    <p class="text-xs" style="color:#2B2D42B3;">
                        VitaPlan © {{ now()->year }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>