<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table = 'track_sessions';
    protected $fillable = ['name', 'track_id', 'session_date', 'description', 'location', 'start_time', 'end_time'];
    protected $casts = [
        'session_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
    ];
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }
}
