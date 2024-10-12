<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskSubmission extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id',
        'task_id',
        'submission_type',
        'submission',
        'status', // Added status
        'feedback',
        'grade',
    ];

    // Relationship: A task submission belongs to a task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relationship: A task submission belongs to a student (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Accessor to get the status of the submission (completed or overdue)
    public function getStatusAttribute()
    {
        $dueDate = $this->task->due_date;
        $submissionDate = $this->created_at;

        // If submitted after the due date, mark as overdue
        if ($submissionDate > $dueDate) {
            return 'overdue';
        }

        // Otherwise, mark as completed
        return 'completed';
    }
}
