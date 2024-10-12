<?php

namespace App\Models;

use App\Models\TrackSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionNote extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'session_id',
        'title',
        'type',
        'content',
    ];

    // Relationship: A session note belongs to a track session
    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }
}
