<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'session_id',
    ];

=======
    protected $fillable = ['name', 'description', 'due_date', 'session_id','created_at','updated_at'];
>>>>>>> origin/master
    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }
<<<<<<< HEAD

=======
    
>>>>>>> origin/master
    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
