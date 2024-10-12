<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'session_id',
        'title',
        'type',
        'content',
    ];
=======
    protected $fillable = ['session_id', 'title', 'type', 'content'];
>>>>>>> origin/master

    public function session()
    {
        return $this->belongsTo(TrackSession::class);
    }
<<<<<<< HEAD
    public function trackSession()
    {
        return $this->belongsTo(TrackSession::class, 'track_session_id');
    }

=======
>>>>>>> origin/master
}
