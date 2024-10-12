<?php

namespace App\Models;

use App\Models\TrackSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'instructor_id',
        'hr_id', // Added hr_id for the HR relationship
    ];

    // Casting specific fields to their respective data types
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationships
    public function sessions()
    {
        return $this->hasMany(TrackSession::class, 'track_id', 'id'); // Corrected to TrackSession
    }

    // Many-to-Many relationship with users (instructors, students, etc.)
    public function users()
    {
        return $this->belongsToMany(User::class, 'track_user', 'track_id', 'user_id')->withTimestamps();
    }

    // Relationship for instructors
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Relationship for HR
    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_id');
    }
}
