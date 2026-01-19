<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\FitnessUser;
use App\Models\ProgressEntry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Health Profile (baseline)
        $profile = FitnessUser::where('user_id', $user->id)->first();

        $startWeight  = (float) ($profile->weight ?? 0);
        $targetWeight = (float) ($profile->target_weight ?? 0);

        // History entries
        $entries = ProgressEntry::where('user_id', $user->id)
            ->orderBy('date', 'asc') // ✅ اسم العمود عندك "date"
            ->get();

        // Edit mode (اختياري)
        $editId = $request->query('edit');
        $editEntry = null;
        if ($editId) {
            $editEntry = ProgressEntry::where('user_id', $user->id)->where('id', $editId)->first();
        }

        // Current weight: آخر وزن مسجل، لو مافيش نخليه baseline
        $currentWeight = $entries->count()
            ? (float) $entries->last()->weight_kg
            : $startWeight;

        // Change text
        $diff = $currentWeight - $startWeight;
        if (abs($diff) < 0.001) {
            $changeText = 'No change';
        } elseif ($diff > 0) {
            $changeText = '+' . number_format($diff, 2) . ' kg';
        } else {
            $changeText = number_format($diff, 2) . ' kg';
        }

        // To target
        $toTargetText = null;
        if ($targetWeight > 0) {
            $remain = $targetWeight - $currentWeight;
            if (abs($remain) < 0.001) {
                $toTargetText = 'Reached target ✅';
            } elseif ($remain > 0) {
                $toTargetText = number_format($remain, 2) . ' kg to reach target';
            } else {
                $toTargetText = number_format(abs($remain), 2) . ' kg below target';
            }
        }

        // Chart data (line): baseline + entries
        $chartLabels = [];
        $chartWeights = [];

        if ($startWeight > 0) {
            $chartLabels[] = 'Start';
            $chartWeights[] = $startWeight;
        }

        foreach ($entries as $e) {
            $chartLabels[] = $e->date->format('Y-m-d');
            $chartWeights[] = (float) $e->weight_kg;
        }

        return view('progress.index', compact(
            'profile',
            'entries',
            'startWeight',
            'currentWeight',
            'targetWeight',
            'changeText',
            'toTargetText',
            'chartLabels',
            'chartWeights',
            'editEntry'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $profile = FitnessUser::where('user_id', $user->id)->first();
        if (!$profile) {
            return redirect()->route('profile.health.edit')
                ->with('error', 'Complete Health Profile first.');
        }

        $validated = $request->validate([
            'date'            => ['required', 'date'],
            'weight_kg'       => ['required', 'numeric', 'min:1', 'max:500'],
            'calories_burned' => ['nullable', 'integer', 'min:0', 'max:20000'],
            'notes'           => ['nullable', 'string', 'max:255'],
        ]);

        // ✅ target_weight يجي من Health Profile (مش من الفورم)
        $target = (float) ($profile->target_weight ?? null);

        // ✅ المهم: Update أو Create لنفس اليوم (يمنع Duplicate)
        ProgressEntry::updateOrCreate(
            [
                'user_id' => $user->id,
                'date'    => $validated['date'],
            ],
            [
                'weight_kg'        => $validated['weight_kg'],
                'target_weight_kg' => $target ?: null,
                'calories_burned'  => $validated['calories_burned'] ?? null,
                'notes'            => $validated['notes'] ?? null,
            ]
        );

        return redirect()->route('progress.index')->with('success', 'Progress saved ✅');
    }

    public function destroy(ProgressEntry $entry): RedirectResponse
    {
        abort_if($entry->user_id !== Auth::id(), 403);

        $entry->delete();

        return redirect()->route('progress.index')->with('success', 'Entry deleted ✅');
    }
}


