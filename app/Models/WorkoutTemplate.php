<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'duration_minutes',
        'video_url',
        'goal_type',
        'is_active',
    ];
}
