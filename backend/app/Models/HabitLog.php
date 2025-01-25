<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HabitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_id',
        'date',
        'status',
    ];

    // Define the relationship to the Habit model
    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
