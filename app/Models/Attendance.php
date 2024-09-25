<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'attendance';
    protected $fillable = [
        'student_id',
        'session_id',
        'status',
       
    ];
    public $timestamps = true;
    



}
