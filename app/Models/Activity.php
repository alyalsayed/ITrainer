<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'activities';

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'description',
        'created_at',
        'updated_at',
    ];

    // Defining the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
