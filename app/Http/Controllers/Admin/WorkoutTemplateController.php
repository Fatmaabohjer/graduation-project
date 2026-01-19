<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutTemplate;
use Illuminate\Http\Request;

class WorkoutTemplateController extends Controller
{
    public function index()
    {
        $items = WorkoutTemplate::latest()->paginate(15);
        return view('admin.workouts.index', compact('items'));
    }

    public function create()
    {
        return view('admin.workouts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => ['required','string','max:255'],
            'level'            => ['nullable','string','max:50'],
            'duration_minutes' => ['nullable','integer','min:0'],
            'video_url'        => ['nullable','string','max:500'], // نخليها string (مش strict url) عشان ما تتعطليش
            'goal_type'        => ['nullable','string','max:50'],
            'is_active'        => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        WorkoutTemplate::create($data);

        return redirect()->route('admin.workouts.index')->with('success', 'Workout template created ✅');
    }

    public function edit(WorkoutTemplate $item)
    {
        return view('admin.workouts.edit', compact('item'));
    }

    public function update(Request $request, WorkoutTemplate $item)
    {
        $data = $request->validate([
            'name'             => ['required','string','max:255'],
            'level'            => ['nullable','string','max:50'],
            'duration_minutes' => ['nullable','integer','min:0'],
            'video_url'        => ['nullable','string','max:500'],
            'goal_type'        => ['nullable','string','max:50'],
            'is_active'        => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $item->update($data);

        return redirect()->route('admin.workouts.index')->with('success', 'Workout template updated ✅');
    }

    public function destroy(WorkoutTemplate $item)
    {
        $item->delete();
        return redirect()->route('admin.workouts.index')->with('success', 'Workout template deleted ✅');
    }
}
