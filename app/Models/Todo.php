<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['task', 'status', 'user_id']; // Include 'user_id' if you have it in your database

    protected $attributes = [
        'status' => 'pending',
    ];
}
