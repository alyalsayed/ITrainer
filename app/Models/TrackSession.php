<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'track_id',
        'session_date',
        'start_time',
        'end_time',
        'description',
        'location',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
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
        return $this->hasMany(SessionNote::class, 'track_session_id');
    }
    public function getSessionDateAttribute($value)
        {
            return Carbon::parse($value);
        }
    protected $casts = [
            'session_date' => 'datetime',
           // 'start_time' => 'time',
            //'end_time' => 'time',
        ];

}
