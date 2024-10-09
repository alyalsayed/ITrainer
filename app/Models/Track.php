<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'instructor_id', 'hr_id']; // Added hr_id

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    // Relationship for instructors and HR
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_id');
    }
}
