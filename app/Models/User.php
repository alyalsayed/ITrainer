<?php

namespace App\Models;

use App\Models\Track;
use App\Models\TrackSession;
use App\Models\TaskSubmission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'userType', // Ensuring it matches the database column
        'profile_image',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'userType' => 'string', // Ensuring it matches the database column
        'last_seen' => 'datetime',
    ];

    const USER_TYPES = ['admin', 'student', 'instructor', 'hr'];

    /**
     * Relationships
     */

    // Many-to-Many: A user can belong to many tracks
    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }

    // HasManyThrough: A user has many sessions through tracks
    public function sessions()
    {
        return $this->hasManyThrough(TrackSession::class, Track::class, 'user_id', 'track_id', 'id', 'id');
    }

    // One-to-Many: A user (student) can submit many tasks
    public function tasks()
    {
        return $this->hasMany(TaskSubmission::class, 'student_id');
    }

    // One-to-Many: A user can receive many messages
    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
