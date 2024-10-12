<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSession extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'track_sessions';

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'track_id',
        'session_date',
        'start_time',
        'end_time',
        'description',
        'location',
    ];

    // Specify the data types for certain attributes
    protected $casts = [
        'session_date' => 'datetime',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    // Relationships
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'session_id');
    }

    public function notes()
    {
        return $this->hasMany(SessionNote::class, 'session_id');
    }

    // Accessor to format session date
    public function getSessionDateAttribute($value)
    {
        return Carbon::parse($value);
    }
}
