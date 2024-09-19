<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','start_date', 'end_date'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'track_user', 'track_id', 'user_id')->withTimestamps();
    }

    public function sessions()
    {
        return $this->hasMany(TrackSession::class, 'track_id', 'id');
    }
}
