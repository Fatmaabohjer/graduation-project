<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'day',
        'meal_type',
        'name',
        'calories',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
