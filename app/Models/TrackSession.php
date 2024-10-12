<?php

namespace App\Models;

<<<<<<< HEAD
use Carbon\Carbon;
=======
>>>>>>> origin/master
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSession extends Model
{
    use HasFactory;

<<<<<<< HEAD
=======
    protected $table = 'track_sessions';

>>>>>>> origin/master
    protected $fillable = [
        'name',
        'track_id',
        'session_date',
<<<<<<< HEAD
        'start_time',
        'end_time',
        'description',
        'location',
=======
        'description',
        'location',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'session_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
>>>>>>> origin/master
    ];

    public function track()
    {
<<<<<<< HEAD
        return $this->belongsTo(Track::class);
=======
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
    public function tasks()
{
    return $this->hasMany(Task::class, 'session_id');
}
    public function notes()
    {
        return $this->hasMany(SessionNote::class, 'session_id');
>>>>>>> origin/master
    }

    public function attendance()
    {
<<<<<<< HEAD
        return $this->hasMany(Attendance::class, 'session_id');
=======
        return $this->hasMany(Attendance::class);
>>>>>>> origin/master
    }

    public function tasks()
    {
<<<<<<< HEAD
        return $this->hasMany(Task::class, 'session_id');
=======
        return $this->hasMany(Task::class);
>>>>>>> origin/master
    }

    public function notes()
    {
<<<<<<< HEAD
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

=======
        return $this->hasMany(Note::class); // Assuming you create a Note model
    }
>>>>>>> origin/master
}
