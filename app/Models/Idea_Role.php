<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Idea_Role extends Pivot
{
    protected $table = 'idea_role';
    protected $primaryKey = ['idea_id', 'role_id'];
    public $incrementing = false;
    // public function ideas()
    // {
    //     return $this->belongsTo('App\Models\Idea');
    // }

    // public function roles()
    // {
    //     return $this->belongsTo('App\Models\Role');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(Idea_Role_User::class);
        // return $this->belongsToMany(User::class, 'idea_role_user', ['idea_id', 'role_id'], 'user_id');

        // // one to many try
        // return $this->hasMany(User::class);
    }
}
