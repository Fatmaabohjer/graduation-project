<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'day',
        'name',
        'duration_minutes',
        'level',
        'video_url',
    ];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
