<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'title', 'type', 'content'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
