<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'userType',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'userType' => 'string',
            'last_seen' => 'datetime',
        ];
    }
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'track_user', 'user_id', 'track_id');
    }

    public function sessions()
    {
        return $this->hasManyThrough(TrackSession::class, Track::class, 'user_id', 'track_id', 'id', 'id');
    }
    public function tasks()
    {
        return $this->hasMany(TaskSubmission::class, 'student_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
