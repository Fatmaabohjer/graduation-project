<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calories_target',
        'bmi',
        'goal_type',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}
