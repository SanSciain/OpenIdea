<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function ideas()
    {
        return $this->belongsToMany('App\Idea');
    }

    protected $fillable = ['name'];
}
