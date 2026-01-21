<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_type',
        'name',
        'calories',
        'goal_type',
        'health_condition_type',
        'is_active',
    ];
}
