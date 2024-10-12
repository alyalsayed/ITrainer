<?php

namespace App\Models;

use Livewire\Attributes\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'title', 'type', 'content'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
