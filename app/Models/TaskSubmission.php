<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'task_id', 'submission_type', 'submission', 'status', 'feedback', 'grade'];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function getStatusAttribute()
{
    $dueDate = $this->task->due_date;
    $submissionDate = $this->created_at;

    if ($submissionDate > $dueDate) {
        return 'overdue';
    }

    return 'completed';
}

}
