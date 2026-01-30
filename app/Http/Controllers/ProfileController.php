<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * ✅ Breeze default profile routes point here:
     * GET /profile -> profile.edit
     *
     * بما إن مشروعك يعتمد على Health Profile، نخلي /profile يوديك مباشرة لصفحة /profile/health
     */
    public function edit(Request $request)
    {
        return redirect()->route('profile.health.edit');
    }

    /**
     * PATCH /profile -> profile.update
     * ما نحتاجوش في مشروعك توا، لكن نخليه موجود باش ما يطيحش route.
     * ممكن لاحقًا تخليه يعدّل name/email لو تبّي.
     */
    public function update(Request $request)
    {
        // نخليها بسيطة وما نغيروش شي
        return redirect()->route('profile.health.edit')
            ->with('status', 'Profile updated.');
    }

    /**
     * DELETE /profile -> profile.destroy
     * نفس الفكرة: نخليه موجود فقط باش ما يصيرش error.
     */
    public function destroy(Request $request)
    {
        // ما نحذفوش حساب توا (لو تبّي نفعّلها بعدين)
        return redirect()->route('profile.health.edit')
            ->with('status', 'Delete account is not enabled yet.');
    }

    // ===============================
    // ✅ Health Profile (شغلك الحالي)
    // ===============================

    public function editHealth(Request $request)
    {
        $user = $request->user();
        $profile = $user->fitnessProfile;

        return view('profile.health', compact('user', 'profile'));
    }

    public function updateHealth(Request $request)
    {
        $data = $request->validate([
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'weight' => ['required', 'numeric', 'min:1'],
            'height' => ['required', 'numeric', 'min:50', 'max:250'],
            'target_weight' => ['nullable', 'numeric', 'min:1'],
            'goal_type' => ['required', 'string', 'max:50'],

            // ✅ تمارين
            'health_condition_type' => ['nullable', 'string', 'max:50'],

            // ✅ وجبات
            'dietary_condition' => ['nullable', 'string', 'max:50'],
        ]);

        // ✅ Normalize values (باش ما يصيرش mismatch)
        $data['health_condition_type'] = isset($data['health_condition_type'])
            ? strtolower(trim($data['health_condition_type']))
            : null;

        if (($data['health_condition_type'] ?? null) === '' || ($data['health_condition_type'] ?? null) === 'none') {
            $data['health_condition_type'] = null;
        }

        $data['dietary_condition'] = isset($data['dietary_condition'])
            ? strtolower(trim($data['dietary_condition']))
            : null;

        if (($data['dietary_condition'] ?? null) === '' || ($data['dietary_condition'] ?? null) === 'none') {
            $data['dietary_condition'] = null;
        }

        $user = $request->user();

        $profile = $user->fitnessProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // BMI
        $heightMeters = $profile->height / 100;
        $bmi = $heightMeters > 0 ? ($profile->weight / ($heightMeters * $heightMeters)) : null;

        $bmiCategory = null;
        $recommendation = null;

        if ($bmi !== null) {
            if ($bmi < 18.5) {
                $bmiCategory = 'Underweight';
                $recommendation = 'Focus on healthy calorie surplus with strength training.';
            } elseif ($bmi < 25) {
                $bmiCategory = 'Normal';
                $recommendation = 'Maintain your routine with balanced meals and regular activity.';
            } elseif ($bmi < 30) {
                $bmiCategory = 'Overweight';
                $recommendation = 'Start a moderate calorie deficit and increase daily movement.';
            } else {
                $bmiCategory = 'Obese';
                $recommendation = 'Prioritize gradual weight loss and low-impact workouts.';
            }
        }

        return redirect()
            ->route('profile.health.edit')
            ->with('success', 'Health profile saved successfully.')
            ->with('bmi', $bmi ? round($bmi, 1) : null)
            ->with('bmiCategory', $bmiCategory)
            ->with('recommendation', $recommendation);
    }
}
