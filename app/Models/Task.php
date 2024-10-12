<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'due_date', 'session_id','created_at','updated_at'];
    public function session()
    {
        return $this->belongsTo(TrackSession::class, 'session_id');
    }
    
    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
