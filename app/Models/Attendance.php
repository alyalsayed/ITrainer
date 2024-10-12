<?php

namespace App\Models;

use App\Models\User;
use App\Models\TrackSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    // Ensures 'id' is not auto-incremented
    public $incrementing = false;

    // Define the table associated with the model
    protected $table = 'attendance';

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id',
        'session_id',
        'status',
    ];

    // Enable timestamps for the model
    public $timestamps = true;

    // Relationship: An attendance belongs to a session (TrackSession model)
    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }

    // Relationship: An attendance belongs to a student (User model)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); // Assuming student_id is a user ID
    }
}
