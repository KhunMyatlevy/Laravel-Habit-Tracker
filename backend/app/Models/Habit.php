<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'frequency',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

