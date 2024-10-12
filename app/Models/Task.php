<?php

namespace App\Models;

use App\Models\TrackSession;
use App\Models\TaskSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'description',
        'due_date',
        'session_id',
        'created_at',  // Added timestamps
        'updated_at',
    ];

    // Relationship: A task belongs to a session
    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }

    // Relationship: A task has many submissions
    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
