<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'title',
        'type',
        'content',
    ];

    public function session()
    {
        return $this->belongsTo(TrackSession::class);
    }
    public function trackSession()
    {
        return $this->belongsTo(TrackSession::class, 'track_session_id');
    }

}
