<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function ideas()
    {
        return $this->belongsToMany('App\Models\Idea');
    }

    protected $fillable = ['name'];
}
