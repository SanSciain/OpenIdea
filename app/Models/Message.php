<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }

    protected $fillable = ['sender', 'text'];
}
