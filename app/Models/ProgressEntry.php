<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight_kg',
        'target_weight_kg',
        'calories_burned',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'weight_kg' => 'decimal:2',
        'target_weight_kg' => 'decimal:2',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
