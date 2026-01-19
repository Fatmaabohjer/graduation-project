<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealTemplate;
use Illuminate\Http\Request;

class MealTemplateController extends Controller
{
    public function index()
    {
        $items = MealTemplate::latest()->paginate(15);
        return view('admin.meals.index', compact('items'));
    }

    public function create()
    {
        return view('admin.meals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'meal_type' => ['required','string','max:50'],
            'name'      => ['required','string','max:255'],
            'calories'  => ['required','integer','min:0'],
            'goal_type' => ['nullable','string','max:50'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        MealTemplate::create($data);

        return redirect()->route('admin.meals.index')->with('success', 'Meal template created ✅');
    }

    public function edit(MealTemplate $item)
    {
        return view('admin.meals.edit', compact('item'));
    }

    public function update(Request $request, MealTemplate $item)
    {
        $data = $request->validate([
            'meal_type' => ['required','string','max:50'],
            'name'      => ['required','string','max:255'],
            'calories'  => ['required','integer','min:0'],
            'goal_type' => ['nullable','string','max:50'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $item->update($data);

        return redirect()->route('admin.meals.index')->with('success', 'Meal template updated ✅');
    }

    public function destroy(MealTemplate $item)
    {
        $item->delete();
        return redirect()->route('admin.meals.index')->with('success', 'Meal template deleted ✅');
    }
}
