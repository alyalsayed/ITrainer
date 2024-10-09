<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';

    protected $fillable = ['student_id', 'session_id', 'status'];

    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); // Assuming student_id is a user ID
    }
}
